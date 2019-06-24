<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Repositories\ActivityRepositories;
use App\Repositories\AlbumNameRepositories;
use App\Repositories\CommunityRepositories;
use App\Repositories\GadreRepositories;
use App\Services\GalleryServices;
use App\Services\PhotoUploadServices;
use Request;

class ActivityCourseController extends Controller
{

    /*
     * index
     */
    public function index()
    {
        return view('student.activityCourse');
    }

    /*
     * init
     */
    public function init()
    {
        $userId = getUserId();
        
        return [
            'activity' => ActivityRepositories::getByFilters(['Stu_Id' => $userId]),
            'community' => CommunityRepositories::getByFilters(['Stu_Id' => $userId]),
            'practice' => GadreRepositories::getByFilters(['Stu_Id' => $userId]),
        ];
    }

    /*
     * activity add
     */
    public function activityAdd()
    {
        $postData = Request::all();
        $userId = getUserId();

        if ( isset($postData['Activ_term']) && isset($postData['Activ_name']) && isset($postData['Activ_term_type']) ) {
            //選填資料
            $Deeds = isset($postData['Deeds']) ? $postData['Deeds'] : '';
            $resb_work = isset($postData['resb_work']) ? $postData['resb_work'] : '';

            //三張圖片
            $images = [
                'img_1' => isset($postData['img_1']) ? $postData['img_1'] : '',
                'img_2' => isset($postData['img_2']) ? $postData['img_2'] : '',
                'img_3' => isset($postData['img_3']) ? $postData['img_3'] : '',
            ];

            //非相簿上傳圖片各種邏輯 各種複雜 XDD
            $uploadPhoto = GalleryServices::uploadPhotoAction($images, ActivityRepositories::FOLDER_NAME, $postData['Activ_name']);

            if ( $uploadPhoto['status'] == 'success' ) {
                //insert to db
                $insert = [
                    'Stu_Id' => $userId,
                    'Activ_term' => $postData['Activ_term'],
                    'Activ_name' => $postData['Activ_name'],
                    'Activ_photo' => json_encode($uploadPhoto['img']),
                    'Folder' => $uploadPhoto['Folder'],
                    'SubFolder' => $uploadPhoto['SubFolder'],
                    'Deeds' => $Deeds,
                    'resb_work' => $resb_work,
                    'Activ_term_type' => $postData['Activ_term_type'],
                ];

                return ActivityRepositories::create($insert);
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
     * activity add
     */
    public function activityEdit()
    {
        $postData = Request::all();
        $userId = getUserId();

        if ( isset($postData['Activ_term']) && isset($postData['Activ_name']) && isset($postData['Activ_term_type']) && isset($postData['Id']) ) {
            //選填資料
            $Deeds = isset($postData['Deeds']) ? $postData['Deeds'] : '';
            $resb_work = isset($postData['resb_work']) ? $postData['resb_work'] : '';

            //三張圖片
            $images = [
                'img_1' => isset($postData['img_1']) ? $postData['img_1'] : '',
                'img_2' => isset($postData['img_2']) ? $postData['img_2'] : '',
                'img_3' => isset($postData['img_3']) ? $postData['img_3'] : '',
            ];

            $uploadPhoto = GalleryServices::uploadPhotoAction($images, ActivityRepositories::FOLDER_NAME, $postData['Activ_name'], $postData['SubFolder']);

            if ( $uploadPhoto['status'] == 'success' ) {
                $updateData = [
                    'Activ_term' => $postData['Activ_term'],
                    'Activ_name' => $postData['Activ_name'],
                    'Deeds' => $Deeds,
                    'resb_work' => $resb_work,
                    'Activ_term_type' => $postData['Activ_term_type'],
                ];

                //update path name
                GalleryServices::updateAlbumName($postData['SubFolder'], $userId, $postData['Activ_name']);

                if ( ! $uploadPhoto['imgEmpty']) {
                    //有編輯圖片
                    $updateData['Activ_photo'] = GalleryServices::editImg($userId, $postData['Activ_photo'], $uploadPhoto['img']);
                }

                return ActivityRepositories::updateById($updateData, $postData['Id']);
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
     * activity delete
     */
    public function activityDelete()
    {
        $postData = Request::input();
        $userId = getUserId();

        if ( isset($postData['Id'])  && isset($postData['photo_decode']) && isset($postData['SubFolder']) && isset($postData['Folder']) ) {
            if ( ActivityRepositories::delete($postData['Id']) ) {
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
     * community add
     */
    public function communityAdd()
    {
        $postData = Request::all();
        $userId = getUserId();

        if ( isset($postData['League_term']) && isset($postData['League_name']) && isset($postData['League_term_type']) ) {
            //選填資料
            $Deeds = isset($postData['League_Deeds']) ? $postData['League_Deeds'] : '';
            $resb_work = isset($postData['League_work']) ? $postData['League_work'] : '';

            //三張圖片
            $images = [
                'img_1' => isset($postData['img_1']) ? $postData['img_1'] : '',
                'img_2' => isset($postData['img_2']) ? $postData['img_2'] : '',
                'img_3' => isset($postData['img_3']) ? $postData['img_3'] : '',
            ];

            //非相簿上傳圖片各種邏輯 各種複雜 XDD
            $uploadPhoto = GalleryServices::uploadPhotoAction($images, CommunityRepositories::FOLDER_NAME, $postData['League_name']);

            if ( $uploadPhoto['status'] == 'success' ) {
                //insert to db
                $insert = [
                    'Stu_Id' => $userId,
                    'League_term' => $postData['League_term'],
                    'League_name' => $postData['League_name'],
                    'League_photo' => json_encode($uploadPhoto['img']),
                    'Folder' => $uploadPhoto['Folder'],
                    'SubFolder' => $uploadPhoto['SubFolder'],
                    'League_Deeds' => $Deeds,
                    'League_work' => $resb_work,
                    'League_term_type' => $postData['League_term_type'],
                ];

                return CommunityRepositories::create($insert);
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
     * community add
     */
    public function communityEdit()
    {
        $postData = Request::all();
        $userId = getUserId();

        if ( isset($postData['League_term']) && isset($postData['League_name']) && isset($postData['League_term_type']) && isset($postData['Id']) ) {
            //選填資料
            $Deeds = isset($postData['League_Deeds']) ? $postData['League_Deeds'] : '';
            $League_work = isset($postData['League_work']) ? $postData['League_work'] : '';

            //三張圖片
            $images = [
                'img_1' => isset($postData['img_1']) ? $postData['img_1'] : '',
                'img_2' => isset($postData['img_2']) ? $postData['img_2'] : '',
                'img_3' => isset($postData['img_3']) ? $postData['img_3'] : '',
            ];

            $uploadPhoto = GalleryServices::uploadPhotoAction($images, CommunityRepositories::FOLDER_NAME, $postData['League_name'], $postData['SubFolder']);

            if ( $uploadPhoto['status'] == 'success' ) {
                $updateData = [
                    'League_term' => $postData['League_term'],
                    'League_name' => $postData['League_name'],
                    'League_Deeds' => $Deeds,
                    'League_work' => $League_work,
                    'League_term_type' => $postData['League_term_type'],
                ];
                //update path name
                GalleryServices::updateAlbumName($postData['SubFolder'], $userId, $postData['League_name']);

                if ( ! $uploadPhoto['imgEmpty']) {
                    //有編輯圖片
                    $updateData['League_photo'] = GalleryServices::editImg($userId, $postData['League_photo'], $uploadPhoto['img']);
                }

                return CommunityRepositories::updateById($updateData, $postData['Id']);
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
     * activity delete
     */
    public function communityDelete()
    {
        $postData = Request::input();
        $userId = getUserId();

        if ( isset($postData['Id'])  && isset($postData['photo_decode']) && isset($postData['SubFolder']) && isset($postData['Folder']) ) {
            if ( CommunityRepositories::delete($postData['Id']) ) {
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
     * practice add
     */
    public function practiceAdd()
    {
        $postData = Request::all();
        $userId = getUserId();

        if ( isset($postData['Cadre_term']) && isset($postData['Cadre_name']) && isset($postData['Cadre_term_type']) ) {
            //選填資料
            $Deeds = isset($postData['Cadre_Deeds']) ? $postData['Cadre_Deeds'] : '';
            $resb_work = isset($postData['Cadre_work']) ? $postData['Cadre_work'] : '';

            //三張圖片
            $images = [
                'img_1' => isset($postData['img_1']) ? $postData['img_1'] : '',
                'img_2' => isset($postData['img_2']) ? $postData['img_2'] : '',
                'img_3' => isset($postData['img_3']) ? $postData['img_3'] : '',
            ];

            //非相簿上傳圖片各種邏輯 各種複雜 XDD
            $uploadPhoto = GalleryServices::uploadPhotoAction($images, GadreRepositories::FOLDER_NAME, $postData['Cadre_name']);

            if ( $uploadPhoto['status'] == 'success' ) {
                //insert to db
                $insert = [
                    'Stu_Id' => $userId,
                    'Cadre_term' => $postData['Cadre_term'],
                    'Cadre_name' => $postData['Cadre_name'],
                    'Cadre_photo' => json_encode($uploadPhoto['img']),
                    'Folder' => $uploadPhoto['Folder'],
                    'SubFolder' => $uploadPhoto['SubFolder'],
                    'Cadre_Deeds' => $Deeds,
                    'Cadre_work' => $resb_work,
                    'Cadre_term_type' => $postData['Cadre_term_type'],
                ];

                return GadreRepositories::create($insert);
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
     * practice add
     */
    public function practiceEdit()
    {
        $postData = Request::all();
        $userId = getUserId();

        if ( isset($postData['Cadre_term']) && isset($postData['Cadre_name']) && isset($postData['Cadre_term_type']) && isset($postData['Id']) ) {
            //選填資料
            $Deeds = isset($postData['Cadre_Deeds']) ? $postData['Cadre_Deeds'] : '';
            $Cadre_work = isset($postData['Cadre_work']) ? $postData['Cadre_work'] : '';

            //三張圖片
            $images = [
                'img_1' => isset($postData['img_1']) ? $postData['img_1'] : '',
                'img_2' => isset($postData['img_2']) ? $postData['img_2'] : '',
                'img_3' => isset($postData['img_3']) ? $postData['img_3'] : '',
            ];

            $uploadPhoto = GalleryServices::uploadPhotoAction($images, GadreRepositories::FOLDER_NAME, $postData['Cadre_name'], $postData['SubFolder']);

            if ( $uploadPhoto['status'] == 'success' ) {
                $updateData = [
                    'Cadre_term' => $postData['Cadre_term'],
                    'Cadre_name' => $postData['Cadre_name'],
                    'Cadre_Deeds' => $Deeds,
                    'Cadre_work' => $Cadre_work,
                    'Cadre_term_type' => $postData['Cadre_term_type'],
                ];
                //update path name
                GalleryServices::updateAlbumName($postData['SubFolder'], $userId, $postData['Cadre_name']);

                if ( ! $uploadPhoto['imgEmpty']) {
                    //有編輯圖片
                    $updateData['Cadre_photo'] = GalleryServices::editImg($userId, $postData['Cadre_photo'], $uploadPhoto['img']);
                }

                return GadreRepositories::updateById($updateData, $postData['Id']);
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
     * practice delete
     */
    public function practiceDelete()
    {
        $postData = Request::input();
        $userId = getUserId();

        if ( isset($postData['Id'])  && isset($postData['photo_decode']) && isset($postData['SubFolder']) && isset($postData['Folder']) ) {
            if ( GadreRepositories::delete($postData['Id']) ) {
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
