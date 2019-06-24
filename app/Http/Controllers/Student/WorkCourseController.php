<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Repositories\LiceRepositories;
use App\Repositories\ParcRepositories;
use App\Repositories\AlbumNameRepositories;
use App\Repositories\ReadRepositories;
use App\Services\GalleryServices;
use App\Services\PhotoUploadServices;
use Request;

class WorkCourseController extends Controller
{

    /*
     * index
     */
    public function index()
    {
        return view('student.workCourse');
    }

    /*
     * init
     */
    public function init()
    {
        $userId = getUserId();

        return [
            'lice' => LiceRepositories::getByFilters(['Stu_Id' => $userId]),
            'parc' => ParcRepositories::getByFilters(['Stu_Id' => $userId]),
            'read' => ReadRepositories::getByFilters(['Stu_Id' => $userId]),
        ];
    }

    /*
     * add
     */
    public function liceAdd()
    {
        $postData = Request::input();

        if ( isset($postData['Lice_name']) ) {
            $postData['Stu_Id'] = getUserId();
            return LiceRepositories::create($postData);
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 需填選必填選項'
        ];
    }

    /*
     * edit
     */
    public function liceEdit()
    {
        $postData = Request::input();

        if ( isset($postData['Lice_name']) && isset($postData['Id']) ) {
            //id
            $id = $postData['Id'];
            unset($postData['Id']);

            return LiceRepositories::updateById($postData, $id);
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 需填選必填選項'
        ];
    }

    /*
     * delete
     */
    public function liceDelete()
    {
        $postData = Request::input();

        if ( isset($postData['Id']) ) {
            return LiceRepositories::delete($postData['Id']);
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 刪除失敗'
        ];
    }

    /*
     * parc add
     */
    public function parcAdd()
    {
        $postData = Request::all();
        $userId = getUserId();

        if ( isset($postData['parc_term']) && isset($postData['parc_unit']) && isset($postData['parc_term_type']) ) {
            //選填資料
            $parc_work = isset($postData['parc_work']) ? $postData['parc_work'] : '';
            $parc_exp = isset($postData['parc_exp']) ? $postData['parc_exp'] : '';

            //三張圖片
            $images = [
                'img_1' => isset($postData['img_1']) ? $postData['img_1'] : '',
                'img_2' => isset($postData['img_2']) ? $postData['img_2'] : '',
                'img_3' => isset($postData['img_3']) ? $postData['img_3'] : '',
            ];

            //非相簿上傳圖片各種邏輯 各種複雜 XDD
            $uploadPhoto = GalleryServices::uploadPhotoAction($images, ParcRepositories::FOLDER_NAME, $postData['parc_unit']);

            if ( $uploadPhoto['status'] == 'success' ) {
                //insert to db
                $insert = [
                    'Stu_Id' => $userId,
                    'parc_term' => $postData['parc_term'],
                    'parc_work' => $parc_work,
                    'parc_photo' => json_encode($uploadPhoto['img']),
                    'Folder' => $uploadPhoto['Folder'],
                    'SubFolder' => $uploadPhoto['SubFolder'],
                    'parc_unit' => $postData['parc_unit'],
                    'parc_exp' => $parc_exp,
                    'parc_term_type' => $postData['parc_term_type'],
                ];

                return ParcRepositories::create($insert);
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
     * parc add
     */
    public function parcEdit()
    {
        $postData = Request::all();
        $userId = getUserId();

        if ( isset($postData['parc_term']) && isset($postData['parc_unit']) && isset($postData['parc_term_type']) && isset($postData['Id']) ) {
            //選填資料
            $parc_work = isset($postData['parc_work']) ? $postData['parc_work'] : '';
            $parc_exp = isset($postData['parc_exp']) ? $postData['parc_exp'] : '';

            //三張圖片
            $images = [
                'img_1' => isset($postData['img_1']) ? $postData['img_1'] : '',
                'img_2' => isset($postData['img_2']) ? $postData['img_2'] : '',
                'img_3' => isset($postData['img_3']) ? $postData['img_3'] : '',
            ];

            $uploadPhoto = GalleryServices::uploadPhotoAction($images, ParcRepositories::FOLDER_NAME, $postData['parc_unit'], $postData['SubFolder']);

            if ( $uploadPhoto['status'] == 'success' ) {
                $updateData = [
                    'parc_term' => $postData['parc_term'],
                    'parc_work' => $parc_work,
                    'parc_unit' => $postData['parc_unit'],
                    'parc_exp' => $parc_exp,
                    'parc_term_type' => $postData['parc_term_type'],
                ];

                //update path name
                GalleryServices::updateAlbumName($postData['SubFolder'], $userId, $postData['parc_unit']);

                if ( ! $uploadPhoto['imgEmpty']) {
                    //有編輯圖片
                    $updateData['parc_photo'] = GalleryServices::editImg($userId, $postData['parc_photo'], $uploadPhoto['img']);
                }

                return ParcRepositories::updateById($updateData, $postData['Id']);
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
    public function parcDelete()
    {
        $postData = Request::input();
        $userId = getUserId();

        if ( isset($postData['Id'])  && isset($postData['photo_decode']) && isset($postData['SubFolder']) && isset($postData['Folder']) ) {
            if ( ParcRepositories::delete($postData['Id']) ) {
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
     * add
     */
    public function readAdd()
    {
        $postData = Request::all();
        $userId = getUserId();

        if ( isset($postData['Read_term']) && isset($postData['Read_unit']) && isset($postData['Read_term_type']) ) {
            //選填資料
            $Read_work = isset($postData['Read_work']) ? $postData['Read_work'] : '';
            $Read_exp = isset($postData['Read_exp']) ? $postData['Read_exp'] : '';

            //三張圖片
            $images = [
                'img_1' => isset($postData['img_1']) ? $postData['img_1'] : '',
                'img_2' => isset($postData['img_2']) ? $postData['img_2'] : '',
                'img_3' => isset($postData['img_3']) ? $postData['img_3'] : '',
            ];

            //非相簿上傳圖片各種邏輯 各種複雜 XDD
            $uploadPhoto = GalleryServices::uploadPhotoAction($images, ReadRepositories::FOLDER_NAME, $postData['Read_unit']);

            if ( $uploadPhoto['status'] == 'success' ) {
                //insert to db
                $insert = [
                    'Stu_Id' => $userId,
                    'Read_term' => $postData['Read_term'],
                    'Read_work' => $Read_work,
                    'Read_photo' => json_encode($uploadPhoto['img']),
                    'Folder' => $uploadPhoto['Folder'],
                    'SubFolder' => $uploadPhoto['SubFolder'],
                    'Read_unit' => $postData['Read_unit'],
                    'Read_exp' => $Read_exp,
                    'Read_term_type' => $postData['Read_term_type'],
                ];

                return ReadRepositories::create($insert);
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
     * read add
     */
    public function readEdit()
    {
        $postData = Request::all();
        $userId = getUserId();

        if ( isset($postData['Read_term']) && isset($postData['Read_unit']) && isset($postData['Read_term_type']) && isset($postData['Id']) ) {
            //選填資料
            $Read_work = isset($postData['Read_work']) ? $postData['Read_work'] : '';
            $Read_exp = isset($postData['Read_exp']) ? $postData['Read_exp'] : '';

            //三張圖片
            $images = [
                'img_1' => isset($postData['img_1']) ? $postData['img_1'] : '',
                'img_2' => isset($postData['img_2']) ? $postData['img_2'] : '',
                'img_3' => isset($postData['img_3']) ? $postData['img_3'] : '',
            ];

            $uploadPhoto = GalleryServices::uploadPhotoAction($images, ReadRepositories::FOLDER_NAME, $postData['Read_unit'], $postData['SubFolder']);

            if ( $uploadPhoto['status'] == 'success' ) {
                $updateData = [
                    'Read_term' => $postData['Read_term'],
                    'Read_work' => $Read_work,
                    'Read_unit' => $postData['Read_unit'],
                    'Read_exp' => $Read_exp,
                    'Read_term_type' => $postData['Read_term_type'],
                ];

                //update path name
                GalleryServices::updateAlbumName($postData['SubFolder'], $userId, $postData['Read_unit']);

                if ( ! $uploadPhoto['imgEmpty']) {
                    //有編輯圖片
                    $updateData['Read_photo'] = GalleryServices::editImg($userId, $postData['Read_photo'], $uploadPhoto['img']);
                }

                return ReadRepositories::updateById($updateData, $postData['Id']);
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
    public function readDelete()
    {
        $postData = Request::input();
        $userId = getUserId();

        if ( isset($postData['Id'])  && isset($postData['photo_decode']) && isset($postData['SubFolder']) && isset($postData['Folder']) ) {
            if ( ReadRepositories::delete($postData['Id']) ) {
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
