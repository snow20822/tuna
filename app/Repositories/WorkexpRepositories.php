<?php

namespace App\Repositories;

use App\Models\Workexp;
use Auth;

class WorkexpRepositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function create($insertData)
    {
        Workexp::create($insertData);

        return ['status' => 'success'];
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = Workexp::orderBy('Work_time_start', 'desc')->where($filters)->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['edit'] = false;
                $result[$key]['info'] = false;
            }

            return $result;
        }
    }

    public static function updateById($updateData, $id)
    {
        try {
            Workexp::where('Id', $id)->update($updateData);

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
            Workexp::where('Id', $id)->delete();

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 刪除失敗'
            ];
        }
    }
}