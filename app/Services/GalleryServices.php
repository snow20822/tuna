<?php

namespace App\Services;

use App\Repositories\AlbumNameRepositories;
use App\Repositories\AlbumRepositories;
use File;

class GalleryServices
{
    /**
     * 取得是否有對應pid
     *
     * @param array
     */
    public static function getPidGroup($gallery)
    {
        foreach ($gallery as $key => $info) {
            $gallery[$key]['has_children'] = AlbumNameRepositories::checkHasChildren([
                'P_Id' => $info['Id']
            ]);

            if ($gallery[$key]['has_children']) {
                //get first photo
                $getChildrenData = AlbumNameRepositories::getJoinAlbumByFilters([
                    'tbStu_Album_Name.Stu_Id' => getUserId(),
                    'tbStu_Album_Name.P_Id' => $info['Id']
                ]);

                $gallery[$key]['img_use_photo'] = $getChildrenData[0]['img_use_photo'];
            }
        }

        return $gallery;
    }

    /**
     * 取得是否有對應pid
     *
     * @param array
     */
    public static function formatThreeGroup($gallery)
    {
        $chunkData = array_chunk($gallery, 3);

        foreach ($chunkData as $key => $info) {
            $count = count($info);
            if ($count < 3) {
                //需補空值進去
                for ($num = 1; $num <= (3 - $count); $num++) {
                    $chunkData[$key][] = [
                        'empty' => true
                    ];
                }
            }
        }

        return $chunkData;
    }

    /**
     * 取得是否有對應pid
     *
     * @param array
     */
    public static function createTargetFolder($folderName)
    {
        $userId = getUserId();
        $uploadFolderUrl = public_path(env('UPLOAD_FOLDER_NAME'));
        $targetUrl = $uploadFolderUrl . '/' . $userId . '/' . $folderName;

        if ( File::exists($targetUrl) ) {
            return true;
        }

        return File::makeDirectory($targetUrl);
    }

    /**
     * 取得是否有對應pid
     *
     * @param array
     */
    public static function createSubFolder($id, $folderName, $postName, $pathName = null)
    {
        if ( is_null($pathName) ) {
            $pathName = strval(time()).str_random(5);
        }
        $path = $folderName . '/' . $pathName;

        //create Folder
        if ( self::createTargetFolder($path) ) {
            $create = AlbumNameRepositories::create([
                'Stu_Id' => getUserId(),
                'Name' => $postName,
                'Path_Name' => $pathName,
                'P_Id' => $id,
            ]);

            if ( $create['status'] == 'success' ) {
                return [
                    'status' => 'success',
                    'pathName' => $pathName,
                    'id' => $create['id'],
                ];
            }
        }

        return [
            'status' => 'error',
        ];
    }

    /**
     * 取得是否有對應pid
     *
     * @param array
     */
    public static function deleteFolder($folderName)
    {
        $userId = getUserId();
        $uploadFolderUrl = public_path(env('UPLOAD_FOLDER_NAME'));
        $targetUrl = $uploadFolderUrl . '/' . $userId . '/' . $folderName;

        return File::deleteDirectory($targetUrl);
    }

    /**
     * 刪除檔案
     */
    public static function deleteImageByUrl($path)
    {
        $targetUrl = public_path() . '/' . $path;

        return File::delete($targetUrl);
    }

    /*
     * 判斷是否有預設資料夾 沒有就產生
     */
    public static function checkDefaultPhotoFolder()
    {
        //先判斷已登入 然後id = getUserId()
        $isLogin = true;
        $userId = getUserId();

        if ($isLogin) {
            //判斷資料夾是否存在  不存在就創立
            $uploadFolderUrl = public_path(env('UPLOAD_FOLDER_NAME'));
            if ( ! file_exists($uploadFolderUrl)) {
                File::makeDirectory($uploadFolderUrl);
            }
            $targetUrl = $uploadFolderUrl . '/' . $userId;
            if ( ! file_exists($targetUrl)) {
                File::makeDirectory($targetUrl);
            }

            //default
            foreach (config('photoFolderDefault') as $folder => $folderCn) {
                if ( ! file_exists($targetUrl . '/' . $folder)) {
                    if ( File::makeDirectory($targetUrl . '/' . $folder) ) {
                        //check data isset
                        $check = AlbumNameRepositories::getByFilters([
                            'Stu_Id' => getUserId(),
                            'Path_Name' => $folder,
                            'Name' => $folderCn,
                        ]);
                        if (count($check) == 0) {
                            //insert to db
                            AlbumNameRepositories::create([
                                'Stu_Id' => getUserId(),
                                'Path_Name' => $folder,
                                'Name' => $folderCn,
                                'P_Id' => 0,
                            ]);
                        }
                    }
                }
            }
        }
    }

    /**
     * 非相簿上傳圖片各種邏輯
     */
    public static function uploadPhotoAction($images, $type, $activ_name, $pathName = null)
    {
        $userId = getUserId();
        $targetAlbum = AlbumNameRepositories::getByFilters([
            'Stu_Id' => $userId,
            'Path_Name' => $type
        ]);


        if ( empty($targetAlbum) ) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 尚未創立預設資料夾'
            ];
        }

        $albumNameData = $targetAlbum[0];

        $uploadPoto = GalleryServices::createSubFolder($albumNameData['Id'], $albumNameData['Path_Name'], $activ_name, $pathName);

        if ( $uploadPoto['status'] == 'success' ) {
            //檢查圖片格式對不對
            $checkImg = PhotoUploadServices::checkImgMime($images);

            if ( $checkImg['status'] == 'error') {
                return $checkImg;
            }
            /*
             *   有圖片的話先存進去 在處理db
             *   $images(上傳圖片檔案array)
             *   $albumNameData['Path_Name'] (取得資料夾名稱 路徑用)
             *   $uploadPoto['pathName'] (取得剛創好的資料夾名稱 路徑用)
             *   $postData['Activ_name'] (使用者輸入得名稱)
             *   $uploadPoto['id'] (create id)
             */
            $imgArray = PhotoUploadServices::uploadArrayPhoto($images, $albumNameData['Path_Name'], $uploadPoto['pathName'], $activ_name, $uploadPoto['id']);

            //檢查images是不是都是空的
            $checkEmpty = true;
            foreach ($images as $img) {
                if ( ! empty($img) ) {
                    $checkEmpty = false;
                    break;
                }
            }

            return [
                'status' => 'success',
                'img' => $imgArray,
                'Folder' => $albumNameData['Path_Name'],
                'SubFolder' => $uploadPoto['pathName'],
                'imgEmpty' => $checkEmpty,
            ];
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 創立資料夾失敗'
        ];
    }

    /**
     * 圖片編輯邏輯
     */
    public static function editImg($userId, $sourceImg, $uploadImg)
    {
        $result = [];
        $arrayKey = ['img_1', 'img_2', 'img_3'];
        $decodeSource = json_decode($sourceImg, true);

        foreach ($arrayKey as $key) {
            if ($uploadImg[$key] != '') {
                //把原來這檔案刪了吧 db也要清除
                if ( File::exists($decodeSource[$key]) ) {
                    if ( File::delete($decodeSource[$key]) ) {
                        //delete db
                        AlbumRepositories::deleteByFilters([
                            'Stu_Id' => $userId,
                            'Album_Photo_Path' => $decodeSource[$key],
                        ]);
                    }
                }

                $result[$key] = $uploadImg[$key];
            } else {
                $result[$key] = $decodeSource[$key];
            }
        }

        return json_encode($result);
    }

    /**
     * 刪除img db
     *
     */
    public static function deleteImgs($userId, $imgs)
    {
        foreach ($imgs as $url) {
            if ( ! is_null($url)) {
                //delete db
                $goDelete = AlbumRepositories::deleteByFilters([
                    'Stu_Id' => $userId,
                    'Album_Photo_Path' => $url,
                ]);

                if ($goDelete['status'] == 'error') {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * 圖片編輯邏輯
     */
    public static function updateAlbumName($folder, $userId, $name)
    {
        $updateData = [
            'Name' => $name,
        ];

        $where = [
            'Stu_Id' => $userId,
            'Path_Name' => $folder,
        ];

        return AlbumNameRepositories::updateByFilters($updateData, $where);
    }
}