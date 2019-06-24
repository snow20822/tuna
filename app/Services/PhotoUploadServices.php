<?php

namespace App\Services;

use Intervention\Image\ImageManagerStatic as Image;
use App\Repositories\AlbumRepositories;
use App\Repositories\AlbumNameRepositories;
use App\Services\GalleryServices;
use File, Auth;

class PhotoUploadServices
{
    /**
     * 圖片上傳
     *
     * @param  object $imgInfo
     * @param  int $userId
     * @param  string $fileName
     * @param  string $type (default null) 類別
     * @param  string $feature (default null) 功能
     * @return []
     */
    public static function doUpload($imgInfo, $userId, $option, $fileName, $type = null, $feature = null)
    {
        // read image from temporary file
        $img = Image::make($imgInfo->getRealPath());
        //upload url
        $uploadUrl = public_path(env('UPLOAD_FOLDER_NAME')) . '/' . $userId;
        $toDbUrl = env('UPLOAD_FOLDER_NAME') . '/' . $userId;
        //3MB
        if ($img->filesize() > 3000000) {
            return [
                'status' => 'error',
                'msg' => '檔案大小超過3MB'
            ];
        }

        //check mime
        if ($img->mime() != 'image/jpeg' && $img->mime() != 'image/png' && $img->mime() != 'image/gif') {
            return [
                'status' => 'error',
                'msg' => '請確認圖片格式是否為正確'
            ];
        }
        //判斷資料夾是否存在  不存在就創立
        GalleryServices::checkDefaultPhotoFolder();

        if ( ! is_null($type)) {
            $uploadUrl = $uploadUrl . '/' . $type;
            if ( ! file_exists($uploadUrl)) {
                File::makeDirectory($uploadUrl);
            }

            $toDbUrl = $toDbUrl . '/' . $type;
        }
        if ( ! is_null($feature)) {
            $uploadUrl = $uploadUrl . '/' . $feature;
            if ( ! file_exists($uploadUrl)) {
                File::makeDirectory($uploadUrl);
            }

            $toDbUrl = $toDbUrl . '/' . $feature;
        }

        //finel upload url
        $uploadUrl = $uploadUrl . '/' . $fileName;
        $toDbUrl = $toDbUrl . '/' . $fileName;

        // resize image resize (integer $width, integer $height)
        if (isset($option['resize']) && $option['resize']) {
            $img->resize($option['resizeWidth'], $option['resizeHeight'], function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        //fit (integer $width, integer $height)
        if (isset($option['fit']) && $option['fit']) {
            $img->fit($option['fitWidth'], $option['fitHeight']);
        }
        // save image
        $img->save($uploadUrl);

        return [
            'status' => 'success',
            'msg' => '上傳成功',
            'photo_path' => $toDbUrl
        ];
    }

    /**
     * upload array photo
     */
    public static function uploadArrayPhoto($images, $grandpaFolderName, $parentFolderName, $postName, $createId)
    {
        $resultImgPath = [];
        //student login id
        $userId = getUserId();

        $num = 1;
        foreach ($images as $imgName => $image) {
            if ($image != '') {
                //fileName
                $fileName = strval(time()).str_random(5) . '.' . $image->getClientOriginalExtension();

                $option = [
                    'fit' => false,
                    'resize' => false,
                ];

                $uploadResult =  self::doUpload($image, $userId, $option, $fileName, $grandpaFolderName, $parentFolderName);

                if ( $uploadResult['status'] == 'success' ) {
                    $photoPath = $uploadResult['photo_path'];
                    //insert to db
                    $insert = [
                        'Stu_Id' => $userId,
                        'Album_Photo' => $fileName,
                        'Album_Photo_Path' => $uploadResult['photo_path'],
                        'Album_Mark' => '第' . $num . '張圖片',
                        'Folder_Name_Id' => $createId,
                    ];

                    $create = AlbumRepositories::create($insert);

                    if ( $create['status'] == 'success' ) {
                        $resultImgPath[$imgName] = $uploadResult['photo_path'];
                    }
                }
            } else {
                $resultImgPath[$imgName] = '';
            }

            $num++;
        }

        return $resultImgPath;
    }

    public static function checkImgMime($images)
    {
        foreach ($images as $imgInfo) {
            if ( $imgInfo != '' ) {
                // read image from temporary file
                $img = Image::make($imgInfo->getRealPath());
                //check mime
                if ($img->mime() != 'image/jpeg' && $img->mime() != 'image/png' && $img->mime() != 'image/gif') {
                    return [
                        'status' => 'error',
                        'msg' => '請確認圖片格式是否為正確'
                    ];
                }

                if ($img->filesize() > 3000000) {
                    return [
                        'status' => 'error',
                        'msg' => '檔案大小超過3MB'
                    ];
                }
            }
        }

        return ['status' => 'success'];
    }
}