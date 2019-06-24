<?php

namespace App\Repositories;

use App\Models\Parc;
use Auth;

class ParcRepositories
{
    const FOLDER_NAME = 'parc';

    /**
     * get by filters
     *
     * @param array
     */
    public static function create($insertData)
    {
        Parc::create($insertData);

        return ['status' => 'success'];
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = Parc::orderBy('parc_term', 'desc')
            ->orderBy('parc_term_type', 'desc')
            ->orderBy('Id', 'desc')
            ->where($filters)
            ->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['edit'] = false;
                $result[$key]['info'] = false;
                $result[$key]['photo_decode'] = json_decode($result[$key]['parc_photo']);
            }

            return $result;
        }
    }

    public static function updateById($updateData, $id)
    {
        try {
            Parc::where('Id', $id)->update($updateData);

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
            Parc::where('Id', $id)->delete();

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 刪除失敗'
            ];
        }
    }
}