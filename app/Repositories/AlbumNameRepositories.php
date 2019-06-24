<?php

namespace App\Repositories;

use App\Models\AlbumName;

class AlbumNameRepositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = AlbumName::orderBy('Id', 'desc')->where($filters)->get();

        if ( ! is_null($data)) {
            return $data->toArray();
        }
    }

    /**
     * get by join filters
     *
     * @param array
     */
    public static function getJoinAlbumByFilters($filters)
    {
        $result = [];
        $data = AlbumName::orderBy('tbStu_Album_Name.Id', 'desc')
            ->where($filters)
            ->leftJoin('tbStu_Album as album', 'tbStu_Album_Name.Id', '=', 'album.Folder_Name_Id')
            ->get([
                'tbStu_Album_Name.*',
                'album.Album_Photo_Path as Album_Photo_Path',
            ]);

        if ( ! is_null($data)) {
            $data = $data->toArray();
            //format
            foreach ($data as $key => $info) {
                $filePath = public_path($info['Album_Photo_Path']);
                $imgPath = url('/') . '/' . $info['Album_Photo_Path'];
                $info['img_use_photo'] = (is_file($filePath)) ? $imgPath : asset('image/not-use/noimage.jpg');

                $result[$info['Id']] = $info;
            }

            return array_values($result);
        }
    }

    /**
     * 取得是否有對應pid
     *
     * @param array
     */
    public static function checkHasChildren($filters)
    {
        $isEmpty =  AlbumName::where($filters)->get()->isEmpty();

        return $isEmpty ? false : true;
    }

    /**
     * create
     *
     * @param array
     */
    public static function create($insertData)
    {
        //檢查是否存在
        $checkData = [
            'Stu_Id' => $insertData['Stu_Id'],
            'Path_Name' => $insertData['Path_Name'],
            'P_Id' => $insertData['P_Id'],
        ];

        $check = AlbumName::where($checkData)->get(['Id'])->first();

        if ( ! is_null($check) ) {
            return [
                'status' => 'success',
                'id' => $check->Id
            ];
        }

        $id = AlbumName::create($insertData)->id;

        return [
            'status' => 'success',
            'id' => $id
        ];
    }

    public static function delete($id)
    {
        try {
            AlbumName::where('Id', $id)->delete();

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 刪除失敗'
            ];
        }
    }

    public static function deleteByFilters($filters)
    {
        try {
            AlbumName::where($filters)->delete();

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 刪除失敗'
            ];
        }
    }

    public static function updateById($updateData, $id)
    {
        try {
            AlbumName::where('Id', $id)->update($updateData);

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 新增或修改失敗'
            ];
        }
    }

    public static function updateByFilters($updateData, $filters)
    {
        try {
            AlbumName::where($filters)->update($updateData);

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 新增或修改失敗'
            ];
        }
    }
}