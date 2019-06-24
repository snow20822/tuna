<?php

namespace App\Repositories;

use App\Models\Perworks;
use Auth;

class PerworksRepositories
{
    const FOLDER_NAME = 'personal';

    /**
     * get by filters
     *
     * @param array
     */
    public static function create($insertData)
    {
        Perworks::create($insertData);

        return ['status' => 'success'];
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = Perworks::orderBy('Id', 'desc')
            ->where($filters)
            ->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['edit'] = false;
                $result[$key]['info'] = false;
                $result[$key]['photo_decode'] = json_decode($result[$key]['Works_photo']);
            }

            return $result;
        }
    }

    /**
     * @return array
     */
    public static function getJoinAlbumByFilters($filters)
    {
        $data = Perworks::orderBy('Id', 'desc')
            ->where($filters)
            ->leftJoin('tbStu_Album_Name as name', 'tbStu_Perworks.SubFolder', '=', 'name.Path_Name')
            ->get([
                'tbStu_Perworks.*',
                'name.Id as album_id',
                'name.P_Id as album_p_id',
            ]);

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['edit'] = false;
                $result[$key]['info'] = false;
                $result[$key]['photo_decode'] = json_decode($result[$key]['Works_photo']);
            }

            return $result;
        }
    }

    public static function updateById($updateData, $id)
    {
        try {
            Perworks::where('Id', $id)->update($updateData);

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 新增或修改失敗'
            ];
        }
    }

    public static function delete($id)
    {
        try {
            Perworks::where('Id', $id)->delete();

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 刪除失敗'
            ];
        }
    }
}