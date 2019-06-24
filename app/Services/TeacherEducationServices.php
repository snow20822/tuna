<?php

namespace App\Services;

use App\Repositories\TeacherEducationRepositories;

class TeacherEducationServices
{
    public static function getInfoByFilters($filters)
    {
        $educations =  TeacherEducationRepositories::getByFilters($filters);

        //補上編輯要判斷的參數
        if ( ! empty($educations)) {
            foreach ($educations as $key => $info) {
                $educations[$key]['edit'] = false;
            }
        }

        return $educations;
    }

    public static function doUpdateById($updateData, $id)
    {
        return TeacherEducationRepositories::updateById($updateData, $id);
    }
}