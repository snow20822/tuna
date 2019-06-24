<?php

namespace App\Repositories;

use App\Models\Introduction;
use Auth;

class IntroductionRepositories
{
    /**
     * get by filters
     *
     * @param array
     */
    public static function getByFilters($filters)
    {
        $user = Introduction::where($filters)->first(['Introduction']);

        if ( ! is_null($user)) {
            return $user->toArray();
        } else {
            //沒有就新增一筆空值
            Introduction::create([
                'Stu_Id' => getUserId()
            ]);
        }

    }

    public static function updateByStudentId($updateData, $id)
    {
        try {
            Introduction::where('Stu_Id', $id)->update($updateData);

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 新增或修改失敗'
            ];
        }
    }
}