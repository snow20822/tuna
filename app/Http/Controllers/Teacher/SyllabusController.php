<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Repositories\TeacherTeachingRepositories;
use App\Repositories\TeacherTeachstuRepositories;

use Request, Auth;

class SyllabusController extends Controller
{
    /*
     * 個人簡歷
     */
    public function index()
    {
        return view('teacher.syllabus');
    }

    /*
     * 個人簡歷
     */
    public function syllabusInit()
    {
        return [
            //學期與歷年課表
            'teaching' => TeacherTeachingRepositories::getInfoByFilters(array()),
            //get學期
            'getTeachingTerm' => TeacherTeachingRepositories::getTerm(array()),
            //get學期
            'getTeachstuTerm' => TeacherTeachingRepositories::getTerm(array()),
            //指導學生
            'teachstu' => TeacherTeachstuRepositories::getInfoByFilters(array()),
        ];
    }

    /*
     * 搜尋學期
     */
    public function teachingTerm(Request $request)
    {
        $search = Request::input();
        return TeacherTeachingRepositories::getInfoByFilters($search);
    }

    /*
     * 搜尋學期
     */
    public function teachstuTerm(Request $request)
    {
        $search = Request::input();
        return TeacherTeachstuRepositories::getInfoByFilters($search);
    }

    /*
     * teachstu add
     */
    public function teachstuAdd()
    {
        $postData = Request::input();

        if (isset($postData['Results_stu']) && isset($postData['Results_term'])) {
            //add Stu_id
            $postData['Te_Id'] = getUserId();
            return TeacherTeachstuRepositories::create($postData);
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 需填選必填選項'
        ];
    }

    /*
     * teachstu add
     */
    public function teachstuEdit()
    {
        $postData = Request::input();

        if (isset($postData['Results_stu']) && isset($postData['Results_paper']) && isset($postData['Results_term'])) {
            //id
            $id = $postData['Id'];
            unset($postData['Id']);

            return TeacherTeachstuRepositories::updateById($postData, $id);
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 需填選必填選項'
        ];
    }

    /*
     * teachstu delete
     */
    public function teachstuDelete()
    {
        $postData = Request::input();

        if ( isset($postData['Id']) ) {
            return TeacherTeachstuRepositories::delete($postData['Id']);
        }
    }
}
