<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Repositories\IntroductionRepositories;
use App\Repositories\ProfileWebRepositories;
use App\Repositories\EducationRepositories;
use App\Repositories\WorkexpRepositories;
use Request, Auth, DB;

class ResumeController extends Controller
{
    /*
     * 個人簡歷
     */
    public function index()
    {
        return view('student.resume');
    }

    /*
     * 個人簡歷
     */
    public function init()
    {
        $userId = getUserId();
        
        return [
            'about' => IntroductionRepositories::getByFilters(['Stu_Id' => $userId]),
            'web' => ProfileWebRepositories::getByFilters(['Stu_Id' => $userId]),
            'education' => EducationRepositories::getByFilters(['Stu_Id' => $userId]),
            'work' => WorkexpRepositories::getByFilters(['Stu_Id' => $userId]),
        ];
    }

    /*
     * edit about
     */
    public function aboutEdit()
    {
        $postData = Request::input();

        if ( isset($postData['Introduction'])) {
            return IntroductionRepositories::updateByStudentId($postData, getUserId());
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 需填選必填選項'
        ];
    }

    /*
     * edit about
     */
    public function profileWeb()
    {
        $postData = Request::input();

        if ( isset($postData['URL']) || isset($postData['Remark'])) {
            return ProfileWebRepositories::updateByStudentId($postData, getUserId());
        }
    }

    /*
     * education add
     */
    public function educationAdd()
    {
        $postData = Request::input();

        if ( isset($postData['Education_type']) && isset($postData['Sch_name']) && isset($postData['Dept_name']) && isset($postData['Status']) ) {
            //add Stu_id
            $postData['Stu_Id'] = getUserId();
            return EducationRepositories::create($postData);
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 需填選必填選項'
        ];
    }

    /*
     * education add
     */
    public function educationEdit()
    {
        $postData = Request::input();

        if ( isset($postData['Education_type']) && isset($postData['Sch_name']) && isset($postData['Dept_name']) && isset($postData['Status'])  && isset($postData['Id'])) {
            //id
            $id = $postData['Id'];
            unset($postData['Id']);

            return EducationRepositories::updateById($postData, $id);
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 需填選必填選項'
        ];
    }

    /*
     * education delete
     */
    public function educationDelete()
    {
        $postData = Request::input();

        if ( isset($postData['Id']) ) {
            return EducationRepositories::delete($postData['Id']);
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 刪除失敗'
        ];
    }

    /*
     * work add
     */
    public function workAdd()
    {
        $postData = Request::input();

        if ( isset($postData['Work_name']) && isset($postData['Work_job_title']) && isset($postData['Work_nature']) ) {
            //add Stu_id
            $postData['Stu_Id'] = getUserId();
            return WorkexpRepositories::create($postData);
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 需填選必填選項'
        ];
    }

    /*
     * work edit
     */
    public function workEdit()
    {
        $postData = Request::input();

        if ( isset($postData['Work_name']) && isset($postData['Work_job_title']) && isset($postData['Work_nature']) && isset($postData['Id'])) {
            //id
            $id = $postData['Id'];
            unset($postData['Id']);

            return WorkexpRepositories::updateById($postData, $id);
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 需填選必填選項'
        ];
    }

    /*
     * work delete
     */
    public function workDelete()
    {
        $postData = Request::input();

        if ( isset($postData['Id']) ) {
            return WorkexpRepositories::delete($postData['Id']);
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 刪除失敗'
        ];
    }
}
