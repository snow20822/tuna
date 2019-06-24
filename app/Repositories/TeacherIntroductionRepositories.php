<?php

namespace App\Repositories;

use App\Models\Te_Introduction;
use Auth;

class TeacherIntroductionRepositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = Te_Introduction::where($filters)->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['edit'] = false;
                $result[$key]['info'] = true;
            }

            return $result;
        }
    }

    public static function updateById($updateData, $id)
    {
        try {
            Te_Introduction::where('id', $id)->update($updateData);

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 新增或修改失敗'
            ];
        }
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function create($insertData)
    {
        Te_Introduction::create($insertData);

        return ['status' => 'success'];
    }

    public static function delete($id)
    {
        try {
            Te_Introduction::where('Id', $id)->delete();

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 刪除失敗'
            ];
        }
    }
}