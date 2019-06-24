<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\GalleryServices;
use App\Repositories\AlbumNameRepositories;
use Request;

class GalleryController extends Controller
{
    /*
     * gallery index
     */
    public function index()
    {
        //check default folder
        GalleryServices::checkDefaultPhotoFolder();

        $request = Request::input();
        $folderId = isset($request['folderId']) ? $request['folderId'] : 0;
        $parentName = '';
        $parentFolder = '';

        if ($folderId != 0) {
            $parent = AlbumNameRepositories::getByFilters([
                'Id' => $folderId,
                'Stu_Id' => getUserId(),
            ]);

            if ( empty($parent)) {
                //找不到就是被刪掉了
                return redirect('/student/myGallery');
            }

            $parentName = $parent[0]['Name'];
            $parentFolder = $parent[0]['Path_Name'];
        }

        return view('student.myGallery', [
            'folderId' => $folderId,
            'parentName' => $parentName,
            'parentFolder' => $parentFolder,
        ]);
    }

    /*
     * gallery init
     */
    public function init()
    {
        $request = Request::input();
        $folderId = isset($request['folderId']) ? $request['folderId'] : 0;

        $gallery = AlbumNameRepositories::getJoinAlbumByFilters([
            'tbStu_Album_Name.Stu_Id' => getUserId(),
            'tbStu_Album_Name.P_Id' => $folderId
        ]);

        $gallery = GalleryServices::getPidGroup($gallery);

        //format 3 group
        $gallery = GalleryServices::formatThreeGroup($gallery);

        return $gallery;
    }

    /*
     * gallery add
     */
    public function add()
    {
        $request = Request::input();

        if ( isset($request['folderId']) && $request['folderId'] != 0) {
            return [
                'status' => 'error',
                'message' => '子相簿不可在新增相簿'
            ];
        }

        if ( isset($request['Name']) ) {
            $pathName = strval(time()).str_random(5);
            //create Folder
            if ( GalleryServices::createTargetFolder($pathName) ) {
                AlbumNameRepositories::create([
                    'Stu_Id' => getUserId(),
                    'Name' => $request['Name'],
                    'Path_Name' => $pathName,
                ]);
            }

            return [
                'status' => 'success',
            ];
        }

        return [
            'status' => 'error',
            'message' => '請輸入相簿名稱'
        ];
    }

    /*
     * gallery add
     */
    public function edit()
    {
        $request = Request::input();

        if ( isset($request['Name']) && isset($request['Id']) ) {
            $updateData = [
                'Name' => $request['Name'],
            ];
            return AlbumNameRepositories::updateById($updateData, $request['Id']);
        }
        return [
            'status' => 'error',
            'message' => '請輸入相簿名稱'
        ];
    }

    /*
     * gallery add
     */
    public function delete()
    {
        $postData = Request::input();

        if ( isset($postData['Id']) && isset($postData['folderName']) && isset($postData['parentFolder']) ) {
            if ( array_key_exists($postData['folderName'], config('photoFolderDefault')) ) {
                return [
                    'status' => 'error',
                    'msg' => '發生錯誤 不可刪除預設資料夾'
                ];
            }

            if ( AlbumNameRepositories::delete($postData['Id']) ) {
                //rm folder and file
                $deletePath = empty($postData['parentFolder']) ? $postData['folderName'] : $postData['parentFolder'] . '/' . $postData['folderName'];

                if ( GalleryServices::deleteFolder($deletePath) ) {
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
