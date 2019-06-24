<?php

namespace App\Repositories;

use App\Models\Share;
use Auth;

class ShareRepositories
{
    const FOLDER_NAME = 'share';

    /**
     * get by filters
     *
     * @param array
     */
    public static function create($insertData)
    {
        Share::create($insertData);

        return ['status' => 'success'];
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = Share::orderBy('Id', 'desc')
            ->where($filters)
            ->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['edit'] = false;
                $result[$key]['info'] = false;
                $result[$key]['photo_decode'] = json_decode($result[$key]['Share_photo']);
            }

            return $result;
        }
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function searchTitle($title)
    {
        $data = Share::orderBy('Share_time', 'desc')
            ->where('Share_title', 'like', '%' . $title . '%')
            ->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['edit'] = false;
                $result[$key]['info'] = false;
                $result[$key]['photo_decode'] = json_decode($result[$key]['Share_photo']);
            }

            return $result;
        }

        return [];
    }

    public static function updateById($updateData, $id)
    {
        try {
            Share::where('Id', $id)->update($updateData);

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
            Share::where('Id', $id)->delete();

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 刪除失敗'
            ];
        }
    }
}