<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Repositories\AlbumNameRepositories;
use App\Repositories\AlbumRepositories;
use App\Repositories\AlbumClassRepositories;
use App\Services\PhotoUploadServices;
use App\Services\GalleryServices;
use Request;

class GalleryDetailController extends Controller
{

    /*
     * init
     */
    public function init()
    {
        $request = Request::input();
        $folderId = isset($request['folderId']) ? $request['folderId'] : 0;

        $album = AlbumRepositories::getByFilters([
            'tbStu_Album.Folder_Name_Id' => $folderId,
            'tbStu_Album.Stu_Id' => getUserId()
        ]);

        return [
            'album' => $album,
            'count' => count($album),
        ];
    }

    /*
     * gallery photo edit
     */
    public function edit()
    {
        $grandpaName = null;
        $grandpaFolderName = null;
        $request = Request::input();
        $folderId = isset($request['folderId']) ? $request['folderId'] : 0;
        $pId = isset($request['pId']) ? $request['pId'] : 0;

        if ($folderId == 0) {
            //不可能是0 jump to gallery
            return redirect('/student/myGallery');
        }

        //爺爺名稱
        if ($pId != 0) {
            $grandpa = AlbumNameRepositories::getByFilters(['Id' => $pId, 'Stu_Id' => getUserId()]);
            if ( empty($grandpa)) {
                //找不到就是被刪掉了
                return redirect('/student/myGallery');
            }

            $grandpaName = $grandpa[0]['Name'];
            $grandpaFolderName = $grandpa[0]['Path_Name'];
        }

        //老爸名稱
        $parent = AlbumNameRepositories::getByFilters(['Id' => $folderId, 'Stu_Id' => getUserId()]);

        if ( empty($parent)) {
            //找不到就是被刪掉了
            return redirect('/student/myGallery');
        }

        $parentName = $parent[0]['Name'];
        $parentFolderName = $parent[0]['Path_Name'];

        return view('student.myGalleryDetailEdit', [
            'folderId' => $folderId,
            'pId' => $pId,
            'parentName' => $parentName,
            'grandpaName' => $grandpaName,
            'parentFolderName' => $parentFolderName,
            'grandpaFolderName' => $grandpaFolderName,
            'albumClass' => AlbumClassRepositories::getAll()
        ]);
    }

    /*
     * create
     */
    public function add()
    {
        $request = Request::all();

        if ( isset($request['img']) && isset($request['Album_Class_Id']) && isset($request['Album_Mark']) && isset($request['Folder_Name_Id']) && isset($request['parentFolderName'])) {
            //check count
            $count = AlbumRepositories::getCount([
                'Folder_Name_Id' => $request['Folder_Name_Id'],
                'Stu_Id' => getUserId()
            ]);

            if ($count >= 3) {
                return [
                    'status' => 'error',
                    'message' => '最多只能三張相片'
                ];
            }

            $imgInfo = $request['img'];
            //student login id
            $userId = getUserId();
            //fileName
            $fileName = strval(time()).str_random(5) . '.' . $imgInfo->getClientOriginalExtension();

            $option = [
                'fit' => false,
                'resize' => false,
            ];

            $uploadResult =  PhotoUploadServices::doUpload($imgInfo, $userId, $option, $fileName, $request['grandpaFolderName'], $request['parentFolderName']);

            if ($uploadResult['status'] == 'success') {
                //insert to db
                $insert = [
                    'Stu_Id' => $userId,
                    'Album_Photo' => $fileName,
                    'Album_Photo_Path' => $uploadResult['photo_path'],
                    'Album_Class_Id' => $request['Album_Class_Id'],
                    'Album_Mark' => $request['Album_Mark'],
                    'Folder_Name_Id' => $request['Folder_Name_Id'],
                ];

                return AlbumRepositories::create($insert);
            }
        }

        return [
            'status' => 'error',
            'message' => '發生錯誤或必填欄位未輸入'
        ];
    }

    /*
     * create
     */
    public function editPost()
    {
        $request = Request::all();

        if ( isset($request['Album_Class_Id']) && isset($request['Album_Mark']) && isset($request['parentFolderName']) && isset($request['Album_Photo_Path']) && isset($request['Id']) ) {

            $updateData = [
                'Album_Class_Id' => $request['Album_Class_Id'],
                'Album_Mark' => $request['Album_Mark'],
            ];

            //有換圖
            if (isset($request['img'])) {
                $imgInfo = $request['img'];
                //student login id
                $userId = getUserId();
                //fileName
                $fileName = strval(time()).str_random(5) . '.' . $imgInfo->getClientOriginalExtension();

                $option = [
                    'fit' => false,
                    'resize' => false,
                ];

                $uploadResult =  PhotoUploadServices::doUpload($imgInfo, $userId, $option, $fileName, $request['grandpaFolderName'], $request['parentFolderName']);

                if ($uploadResult['status'] == 'success') {
                    //rm old file
                    if ( GalleryServices::deleteImageByUrl($request['Album_Photo_Path']) ) {
                        $updateData['Album_Photo_Path'] = $uploadResult['photo_path'];
                        $updateData['Album_Photo'] = $fileName;
                    } else {
                        return [
                            'status' => 'error',
                            'message' => '發生錯誤舊檔案刪除失敗'
                        ];
                    }
                }
            }

            //go update
            return AlbumRepositories::updateById($updateData, $request['Id']);

        }

        return [
            'status' => 'error',
            'message' => '發生錯誤或必填欄位未輸入'
        ];
    }

    /*
     * gallery delete
     */
    public function delete()
    {
        $postData = Request::input();

        if ( isset($postData['Id']) && isset($postData['filePath'])) {
            if ( AlbumRepositories::delete($postData['Id']) ) {
                //rm folder and file
                if ( GalleryServices::deleteImageByUrl($postData['filePath']) ) {
                    return [
                        'status' => 'success'
                    ];
                }
            }
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 刪除失敗'
        ];
    }
}
