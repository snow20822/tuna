<?php

namespace App\Repositories;

use App\Models\ProfileWeb;
use Auth;

class ProfileWebRepositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $data = ProfileWeb::where($filters)->first(['Remark', 'URL']);

        if ( ! is_null($data)) {
            return $data->toArray();
        } else {
            //沒有就新增一筆空值
            ProfileWeb::create([
                'Stu_Id' => getUserId()
            ]);
        }
    }

    public static function updateByStudentId($updateData, $id)
    {
        try {
            ProfileWeb::where('Stu_id', $id)->update($updateData);

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 新增或修改失敗'
            ];
        }
    }
}