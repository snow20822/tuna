<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\GalleryServices;
use App\Repositories\AlbumNameRepositories;
use App\Repositories\ShareRepositories;
use Request;

class ShareSearchController extends Controller
{
    /*
     * index
     */
    public function index()
    {
        $request = Request::input();

        return view('student.shareSearch', [
            'search' => isset($request['search']) ? $request['search'] : ''
        ]);
    }

    /*
     * init
     */
    public function init()
    {
        $request = Request::input();
        $userId = getUserId();

        if ( ! empty($request['search']) ) {
            $other = ShareRepositories::searchTitle($request['search']);
        } else {
            $other = [];
        }
        

        return [
            'Share' => ShareRepositories::getByFilters(['Stu_Id' => $userId]),
            'Other' => $other,
        ];
    }

    /*
     * share add
     */
    public function add()
    {
        $postData = Request::all();
        $userId = getUserId();

        if ( isset($postData['Share_title']) ) {
            //三張圖片
            $images = [
                'img_1' => isset($postData['img_1']) ? $postData['img_1'] : '',
                'img_2' => isset($postData['img_2']) ? $postData['img_2'] : '',
                'img_3' => isset($postData['img_3']) ? $postData['img_3'] : '',
            ];

            //非相簿上傳圖片各種邏輯 各種複雜 XDD
            $uploadPhoto = GalleryServices::uploadPhotoAction($images, ShareRepositories::FOLDER_NAME, $postData['Share_title']);

            if ( $uploadPhoto['status'] == 'success' ) {
                //insert to db
                $insert = [
                    'Stu_Id' => $userId,
                    'Share_time' => $postData['Share_time'],
                    'Share_location' => $postData['Share_location'],
                    'Share_photo' => json_encode($uploadPhoto['img']),
                    'Folder' => $uploadPhoto['Folder'],
                    'SubFolder' => $uploadPhoto['SubFolder'],
                    'Share_cont' => $postData['Share_cont'],
                    'Share_author' => $postData['Share_author'],
                    'Share_title' => $postData['Share_title'],
                ];

                return ShareRepositories::create($insert);
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
     * share add
     */
    public function edit()
    {
        $postData = Request::all();
        $userId = getUserId();

        if ( isset($postData['Share_title']) && isset($postData['Id']) ) {
            //三張圖片
            $images = [
                'img_1' => isset($postData['img_1']) ? $postData['img_1'] : '',
                'img_2' => isset($postData['img_2']) ? $postData['img_2'] : '',
                'img_3' => isset($postData['img_3']) ? $postData['img_3'] : '',
            ];

            $uploadPhoto = GalleryServices::uploadPhotoAction($images, ShareRepositories::FOLDER_NAME, $postData['Share_title'], $postData['SubFolder']);

            if ( $uploadPhoto['status'] == 'success' ) {
                $updateData = [
                    'Share_title' => $postData['Share_title'],
                    'Share_time' => $postData['Share_time'],
                    'Share_location' => $postData['Share_location'],
                    'Share_cont' => $postData['Share_cont'],
                    'Share_author' => $postData['Share_author'],
                ];

                //update path name
                GalleryServices::updateAlbumName($postData['SubFolder'], $userId, $postData['Share_title']);

                if ( ! $uploadPhoto['imgEmpty']) {
                    //有編輯圖片
                    $updateData['Share_photo'] = GalleryServices::editImg($userId, $postData['Share_photo'], $uploadPhoto['img']);
                }

                return ShareRepositories::updateById($updateData, $postData['Id']);
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
     * share delete
     */
    public function delete()
    {
        $postData = Request::input();
        $userId = getUserId();

        if ( isset($postData['Id'])  && isset($postData['photo_decode']) && isset($postData['SubFolder']) && isset($postData['Folder']) ) {
            if ( ShareRepositories::delete($postData['Id']) ) {
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
