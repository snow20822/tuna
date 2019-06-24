<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Repositories\SchshipRepositories;
use App\Repositories\AlbumNameRepositories;
use App\Repositories\RandPRepositories;
use App\Repositories\RaceRepositories;
use App\Services\GalleryServices;
use App\Services\PhotoUploadServices;
use Request;

class HonoraryRecordController extends Controller
{

    /*
     * index
     */
    public function index()
    {
        return view('student.honoraryRecord');
    }

    /*
     * init
     */
    public function init()
    {
        $userId = getUserId();

        return [
            'Schship' => SchshipRepositories::getByFilters(['Stu_Id' => $userId]),
            'Race' => RaceRepositories::getByFilters(['Stu_Id' => $userId]),
            'RandP' => RandPRepositories::getByFilters(['Stu_Id' => $userId]),
        ];
    }

    /*
     * add
     */
    public function schshipAdd()
    {
        $postData = Request::input();

        if ( isset($postData['Schship_name']) ) {
            $postData['Stu_Id'] = getUserId();
            return SchshipRepositories::create($postData);
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 需填選必填選項'
        ];
    }

    /*
     * edit
     */
    public function schshipEdit()
    {
        $postData = Request::input();

        if ( isset($postData['Schship_name']) && isset($postData['Id']) ) {
            //id
            $id = $postData['Id'];
            unset($postData['Id']);

            return SchshipRepositories::updateById($postData, $id);
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 需填選必填選項'
        ];
    }

    /*
     * delete
     */
    public function schshipDelete()
    {
        $postData = Request::input();

        if ( isset($postData['Id']) ) {
            return SchshipRepositories::delete($postData['Id']);
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 刪除失敗'
        ];
    }

    /*
     * race add
     */
    public function raceAdd()
    {
        $postData = Request::all();
        $userId = getUserId();

        if ( isset($postData['Race_term']) && isset($postData['Race_name']) && isset($postData['Race_term_type']) ) {
            //三張圖片
            $images = [
                'img_1' => isset($postData['img_1']) ? $postData['img_1'] : '',
                'img_2' => isset($postData['img_2']) ? $postData['img_2'] : '',
                'img_3' => isset($postData['img_3']) ? $postData['img_3'] : '',
            ];

            //非相簿上傳圖片各種邏輯 各種複雜 XDD
            $uploadPhoto = GalleryServices::uploadPhotoAction($images, RaceRepositories::FOLDER_NAME, $postData['Race_name']);

            if ( $uploadPhoto['status'] == 'success' ) {
                //insert to db
                $insert = [
                    'Stu_Id' => $userId,
                    'Race_term' => $postData['Race_term'],
                    'Race_name' => $postData['Race_name'],
                    'Race_award' => $postData['Race_award'],
                    'Race_location' => $postData['Race_location'],
                    'Race_photo' => json_encode($uploadPhoto['img']),
                    'Folder' => $uploadPhoto['Folder'],
                    'SubFolder' => $uploadPhoto['SubFolder'],
                    'Race_unit' => $postData['Race_unit'],
                    'Race_exp' => $postData['Race_exp'],
                    'Race_term_type' => $postData['Race_term_type'],
                ];

                return RaceRepositories::create($insert);
            } else {
                return $uploadPhoto;
            }
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 需填選必填選項'
        ];
    }

    /*
     * race add
     */
    public function raceEdit()
    {
        $postData = Request::all();
        $userId = getUserId();

        if ( isset($postData['Race_term']) && isset($postData['Race_name']) && isset($postData['Race_term_type']) && isset($postData['Id']) ) {

            //三張圖片
            $images = [
                'img_1' => isset($postData['img_1']) ? $postData['img_1'] : '',
                'img_2' => isset($postData['img_2']) ? $postData['img_2'] : '',
                'img_3' => isset($postData['img_3']) ? $postData['img_3'] : '',
            ];

            $uploadPhoto = GalleryServices::uploadPhotoAction($images, RaceRepositories::FOLDER_NAME, $postData['Race_name'], $postData['SubFolder']);

            if ( $uploadPhoto['status'] == 'success' ) {
                $updateData = [
                    'Race_term' => $postData['Race_term'],
                    'Race_unit' => $postData['Race_unit'],
                    'Race_name' => $postData['Race_name'],
                    'Race_location' => $postData['Race_location'],
                    'Race_award' => $postData['Race_award'],
                    'Race_exp' => $postData['Race_exp'],
                    'Race_term_type' => $postData['Race_term_type'],
                ];

                //update path name
                GalleryServices::updateAlbumName($postData['SubFolder'], $userId, $postData['Race_name']);

                if ( ! $uploadPhoto['imgEmpty']) {
                    //有編輯圖片
                    $updateData['Race_photo'] = GalleryServices::editImg($userId, $postData['Race_photo'], $uploadPhoto['img']);
                }

                return RaceRepositories::updateById($updateData, $postData['Id']);
            } else {
                return [
                    'status' => 'error',
                    'msg' => '發生錯誤 創立資料夾失敗'
                ];
            }
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 需填選必填選項'
        ];
    }

    /*
     * parc delete
     */
    public function raceDelete()
    {
        $postData = Request::input();
        $userId = getUserId();

        if ( isset($postData['Id']) && isset($postData['photo_decode']) && isset($postData['SubFolder']) && isset($postData['Folder']) ) {
            if ( RaceRepositories::delete($postData['Id']) ) {
                //rm folder and file
                if ( AlbumNameRepositories::deleteByFilters([
                    'Stu_Id' => getUserId(),
                    'Path_Name' => $postData['SubFolder'],
                ]) ) {
                    //rm db
                    if ( GalleryServices::deleteImgs($userId, $postData['photo_decode']) ) {
                        $targetUrl = $postData['Folder'] . '/' . $postData['SubFolder'];

                        if ( GalleryServices::deleteFolder($targetUrl) ) {
                            return [
                                'status' => 'success'
                            ];
                        }
                    }
                }
            }
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 刪除失敗'
        ];
    }
}
