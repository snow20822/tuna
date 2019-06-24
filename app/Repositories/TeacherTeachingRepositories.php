<?php

namespace App\Repositories;

use App\Models\Te_teaching;
use Auth;

class TeacherTeachingRepositories
{
    /**
     * get getTerm by filters
     *
     * @param array
     */
    public static function getTerm($filters)
    {
        $term = array();

        $data = Te_teaching::orderBy('Id', 'desc')->where($filters)->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                if(!in_array($info['Results_term'], $term)){
                    array_push($term, $info['Results_term']);
                }
            }
            sort($term);
            return $term;
        }
    }

    /**
     * get by filters
     *
     * @param array
     */
    public static function getInfoByFilters($filters)
    {
        $data = Te_teaching::orderBy('Id', 'desc')->where($filters)->get();

        if ( ! is_null($data)) {
            $result = $data->toArray();

            foreach ($result as $key => $info) {
                $result[$key]['edit'] = false;
            }

            return $result;
        }
        
    }

    public static function updateById($updateData, $id)
    {
        try {
            Te_teaching::where('id', $id)->update($updateData);

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
        Te_teaching::create($insertData);

        return ['status' => 'success'];
    }

    public static function delete($id)
    {
        try {
            Te_teaching::where('Id', $id)->delete();

            return ['status' => 'success'];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'msg' => '發生錯誤 刪除失敗'
            ];
        }
    }
}