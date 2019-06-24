<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Repositories\ExhiRepositories;
use App\Repositories\AlbumNameRepositories;
use App\Repositories\PerworksRepositories;
use App\Repositories\ShowRepositories;
use App\Services\GalleryServices;
use App\Services\PhotoUploadServices;
use Request;

class WorkProjectController extends Controller
{

    /*
     * index
     */
    public function index()
    {
        return view('student.workProject');
    }

    /*
     * init
     */
    public function init()
    {
        $userId = getUserId();

        return [
            'Perworks' => PerworksRepositories::getJoinAlbumByFilters(['tbStu_Perworks.Stu_Id' => $userId]),
            'Exhi' => ExhiRepositories::getByFilters(['Stu_Id' => $userId]),
            'Show' => ShowRepositories::getByFilters(['Stu_Id' => $userId]),
        ];
    }

    /*
     * Exhi add
     */
    public function exhiAdd()
    {
        $postData = Request::all();
        $userId = getUserId();

        if ( isset($postData['Exhi_unit']) ) {
            //三張圖片
            $images = [
                'img_1' => isset($postData['img_1']) ? $postData['img_1'] : '',
                'img_2' => isset($postData['img_2']) ? $postData['img_2'] : '',
                'img_3' => isset($postData['img_3']) ? $postData['img_3'] : '',
            ];

            //非相簿上傳圖片各種邏輯 各種複雜 XDD
            $uploadPhoto = GalleryServices::uploadPhotoAction($images, ExhiRepositories::FOLDER_NAME, $postData['Exhi_unit']);

            if ( $uploadPhoto['status'] == 'success' ) {
                //insert to db
                $insert = [
                    'Stu_Id' => $userId,
                    'Exhi_unit' => $postData['Exhi_unit'],
                    'Exhi_time_start' => $postData['Exhi_time_start'],
                    'Exhi_time_end' => $postData['Exhi_time_end'],
                    'Exhi_location' => $postData['Exhi_location'],
                    'Exhi_exp' => $postData['Exhi_exp'],
                    'Exhi_photo' => json_encode($uploadPhoto['img']),
                    'Folder' => $uploadPhoto['Folder'],
                    'SubFolder' => $uploadPhoto['SubFolder'],
                ];

                return ExhiRepositories::create($insert);
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
     * Exhi add
     */
    public function exhiEdit()
    {
        $postData = Request::all();
        $userId = getUserId();

        if ( isset($postData['Exhi_unit']) && isset($postData['Id']) ) {
            //三張圖片
            $images = [
                'img_1' => isset($postData['img_1']) ? $postData['img_1'] : '',
                'img_2' => isset($postData['img_2']) ? $postData['img_2'] : '',
                'img_3' => isset($postData['img_3']) ? $postData['img_3'] : '',
            ];

            $uploadPhoto = GalleryServices::uploadPhotoAction($images, ExhiRepositories::FOLDER_NAME, $postData['Exhi_unit'], $postData['SubFolder']);

            if ( $uploadPhoto['status'] == 'success' ) {
                $updateData = [
                    'Exhi_unit' => $postData['Exhi_unit'],
                    'Exhi_time_start' => $postData['Exhi_time_start'],
                    'Exhi_time_end' => $postData['Exhi_time_end'],
                    'Exhi_location' => $postData['Exhi_location'],
                    'Exhi_exp' => $postData['Exhi_exp'],
                ];

                //update path name
                GalleryServices::updateAlbumName($postData['SubFolder'], $userId, $postData['Exhi_unit']);

                if ( ! $uploadPhoto['imgEmpty']) {
                    //有編輯圖片
                    $updateData['Exhi_photo'] = GalleryServices::editImg($userId, $postData['Exhi_photo'], $uploadPhoto['img']);
                }

                return ExhiRepositories::updateById($updateData, $postData['Id']);
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
     * Exhi delete
     */
    public function exhiDelete()
    {
        $postData = Request::input();
        $userId = getUserId();

        if ( isset($postData['Id'])  && isset($postData['photo_decode']) && isset($postData['SubFolder']) && isset($postData['Folder']) ) {
            if ( ExhiRepositories::delete($postData['Id']) ) {
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

    /*
     * Show add
     */
    public function showAdd()
    {
        $postData = Request::all();
        $userId = getUserId();

        if ( isset($postData['Show_unit']) ) {
            //三張圖片
            $images = [
                'img_1' => isset($postData['img_1']) ? $postData['img_1'] : '',
                'img_2' => isset($postData['img_2']) ? $postData['img_2'] : '',
                'img_3' => isset($postData['img_3']) ? $postData['img_3'] : '',
            ];

            //非相簿上傳圖片各種邏輯 各種複雜 XDD
            $uploadPhoto = GalleryServices::uploadPhotoAction($images, ShowRepositories::FOLDER_NAME, $postData['Show_unit']);

            if ( $uploadPhoto['status'] == 'success' ) {
                //insert to db
                $insert = [
                    'Stu_Id' => $userId,
                    'Show_unit' => $postData['Show_unit'],
                    'Show_time_start' => $postData['Show_time_start'],
                    'Show_time_end' => $postData['Show_time_end'],
                    'Show_location' => $postData['Show_location'],
                    'Show_exp' => $postData['Show_exp'],
                    'Show_photo' => json_encode($uploadPhoto['img']),
                    'Folder' => $uploadPhoto['Folder'],
                    'SubFolder' => $uploadPhoto['SubFolder'],
                ];

                return ShowRepositories::create($insert);
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
     * Show add
     */
    public function showEdit()
    {
        $postData = Request::all();
        $userId = getUserId();

        if ( isset($postData['Show_unit']) && isset($postData['Id']) ) {
            //三張圖片
            $images = [
                'img_1' => isset($postData['img_1']) ? $postData['img_1'] : '',
                'img_2' => isset($postData['img_2']) ? $postData['img_2'] : '',
                'img_3' => isset($postData['img_3']) ? $postData['img_3'] : '',
            ];

            $uploadPhoto = GalleryServices::uploadPhotoAction($images, ShowRepositories::FOLDER_NAME, $postData['Show_unit'], $postData['SubFolder']);

            if ( $uploadPhoto['status'] == 'success' ) {
                $updateData = [
                    'Show_unit' => $postData['Show_unit'],
                    'Show_time_start' => $postData['Show_time_start'],
                    'Show_time_end' => $postData['Show_time_end'],
                    'Show_location' => $postData['Show_location'],
                    'Show_exp' => $postData['Show_exp'],
                ];

                //update path name
                GalleryServices::updateAlbumName($postData['SubFolder'], $userId, $postData['Show_unit']);

                if ( ! $uploadPhoto['imgEmpty']) {
                    //有編輯圖片
                    $updateData['Show_photo'] = GalleryServices::editImg($userId, $postData['Show_photo'], $uploadPhoto['img']);
                }

                return ShowRepositories::updateById($updateData, $postData['Id']);
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
     * Show delete
     */
    public function showDelete()
    {
        $postData = Request::input();
        $userId = getUserId();

        if ( isset($postData['Id'])  && isset($postData['photo_decode']) && isset($postData['SubFolder']) && isset($postData['Folder']) ) {
            if ( ShowRepositories::delete($postData['Id']) ) {
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

    /*
     * perwork add
     */
    public function perworksAdd()
    {
        $postData = Request::all();
        $userId = getUserId();

        if ( isset($postData['Works_name']) ) {
            //三張圖片
            $images = [
                'img_1' => isset($postData['img_1']) ? $postData['img_1'] : '',
                'img_2' => isset($postData['img_2']) ? $postData['img_2'] : '',
                'img_3' => isset($postData['img_3']) ? $postData['img_3'] : '',
            ];

            //非相簿上傳圖片各種邏輯 各種複雜 XDD
            $uploadPhoto = GalleryServices::uploadPhotoAction($images, PerworksRepositories::FOLDER_NAME, $postData['Works_name']);

            if ( $uploadPhoto['status'] == 'success' ) {
                //insert to db
                $insert = [
                    'Stu_Id' => $userId,
                    'Works_name' => $postData['Works_name'],
                    'Works_introd' => $postData['Works_introd'],
                    'Works_vid' => $postData['Works_vid'],
                    'Works_photo' => json_encode($uploadPhoto['img']),
                    'Folder' => $uploadPhoto['Folder'],
                    'SubFolder' => $uploadPhoto['SubFolder'],
                ];

                return PerworksRepositories::create($insert);
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
     * perwork add
     */
    public function perworksEdit()
    {
        $postData = Request::all();
        $userId = getUserId();

        if ( isset($postData['Works_name']) && isset($postData['Id']) ) {
            //三張圖片
            $images = [
                'img_1' => isset($postData['img_1']) ? $postData['img_1'] : '',
                'img_2' => isset($postData['img_2']) ? $postData['img_2'] : '',
                'img_3' => isset($postData['img_3']) ? $postData['img_3'] : '',
            ];

            $uploadPhoto = GalleryServices::uploadPhotoAction($images, PerworksRepositories::FOLDER_NAME, $postData['Works_name'], $postData['SubFolder']);

            if ( $uploadPhoto['status'] == 'success' ) {
                $updateData = [
                    'Works_name' => $postData['Works_name'],
                    'Works_introd' => $postData['Works_introd'],
                    'Works_vid' => $postData['Works_vid'],
                ];

                //update path name
                GalleryServices::updateAlbumName($postData['SubFolder'], $userId, $postData['Works_name']);

                if ( ! $uploadPhoto['imgEmpty']) {
                    //有編輯圖片
                    $updateData['Works_photo'] = GalleryServices::editImg($userId, $postData['Works_photo'], $uploadPhoto['img']);
                }

                return PerworksRepositories::updateById($updateData, $postData['Id']);
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
     * perwork delete
     */
    public function perworksDelete()
    {
        $postData = Request::input();
        $userId = getUserId();

        if ( isset($postData['Id'])  && isset($postData['photo_decode']) && isset($postData['SubFolder']) && isset($postData['Folder']) ) {
            if ( PerworksRepositories::delete($postData['Id']) ) {
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
