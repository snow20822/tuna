<?php

namespace App\Repositories;

use App\Models\Album;

class AlbumRepositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = Album::orderBy('tbStu_Album.Id', 'desc')
            ->where($filters)
            ->leftJoin('tbStu_Album_Class as class', 'tbStu_Album.Album_Class_Id', '=', 'class.Id')
            ->get([
                'tbStu_Album.*',
                'class.Name as Album_Class_Name',
            ]);

        if ( ! is_null($data)) {
            $data = $data->toArray();
            //format
            foreach ($data as $key => $info) {
                $filePath = public_path($info['Album_Photo_Path']);
                $imgPath = url('/') . '/' . $info['Album_Photo_Path'];
                $data[$key]['img_use_photo'] = (is_file($filePath)) ? $imgPath : asset('image/not-use/noimage.jpg');
            }

            return $data;
        }
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function getCount($filters)
    {
        return Album::where($filters)->count();
    }

    /**
     * create
     *
     * @param array
     */
    public static function create($insertData)
    {
        Album::create($insertData);

        return ['status' => 'success'];
    }

    public static function delete($id)
    {
        try {
            Album::where('Id', $id)->delete();

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
            Album::where('Id', $id)->update($updateData);

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 新增或修改失敗'
            ];
        }
    }

    public static function deleteByFilters($filters)
    {
        try {
            Album::where($filters)->delete();

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 刪除失敗'
            ];
        }
    }
}