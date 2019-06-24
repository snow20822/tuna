<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Repositories\TeacherIntroductionRepositories;
use App\Repositories\TeacherEducationRepositories;
use App\Repositories\TeacherExpworkRepositories;
use App\Repositories\TeacherHonorRepositories;
use App\Repositories\TeacherRoomRepositories;

use Request, Auth;

class ResumeController extends Controller
{
    /*
     * 個人簡歷
     */
    public function index()
    {
        return view('teacher.resume');
    }

    /*
     * 個人簡歷
     */
    public function resumeInit()
    {
        return [
            //簡介
            'introduction' => TeacherIntroductionRepositories::getByFilters(array())[0],
            //學歷
            'education' => TeacherEducationRepositories::getByFilters(array()),
            //經歷
            'work' => TeacherExpworkRepositories::getByFilters(array()),
            //榮譽獎項
            'honor' => TeacherHonorRepositories::getByFilters(array()),
            //研究室
            'room' => TeacherRoomRepositories::getByFilters(array()),
        ];
    }

    /*
    * edit introduction
    */
    public function introductionEdit()
    {
        $postData = Request::input();
        if (isset($postData['Introduction'])) {
            //id
            $id = $postData['Id'];
            unset($postData['Id']);
            return TeacherIntroductionRepositories::updateById($postData, $id);
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 需填選必填選項'
        ];
    }

    /*
     * education add
     */
    public function educationAdd()
    {
        $postData = Request::input();

        if ( isset($postData['Education_type']) && isset($postData['Sch_name']) && isset($postData['Dept_name']) && isset($postData['Status']) ) {
            //add Stu_id
            $postData['Te_Id'] = getUserId();
            return TeacherEducationRepositories::create($postData);
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

            return TeacherEducationRepositories::updateById($postData, $id);
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
            return TeacherEducationRepositories::delete($postData['Id']);
        }
    }

    /*
     * honor add
     */
    public function honorAdd()
    {
        $postData = Request::input();

        if ( isset($postData['Honor_year']) && isset($postData['Honor_unit']) && isset($postData['Honor_name'])) {
            //add Stu_id
            $postData['Te_Id'] = getUserId();
            return TeacherHonorRepositories::create($postData);
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 需填選必填選項'
        ];
    }

    /*
     * honor add
     */
    public function honorEdit()
    {
        $postData = Request::input();

        if ( isset($postData['Honor_year']) && isset($postData['Honor_unit']) && isset($postData['Honor_name'])) {
            //id
            $id = $postData['Id'];
            unset($postData['Id']);

            return TeacherHonorRepositories::updateById($postData, $id);
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 需填選必填選項'
        ];
    }

    /*
     * honor delete
     */
    public function honorDelete()
    {
        $postData = Request::input();

        if ( isset($postData['Id']) ) {
            return TeacherHonorRepositories::delete($postData['Id']);
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 需填選必填選項'
        ];
    }

    /*
     * room add
     */
    public function roomAdd()
    {
        $postData = Request::input();

        if ( isset($postData['Room_name']) && isset($postData['Room_phone'])) {
            //add Stu_id
            $postData['Te_Id'] = getUserId();
            return TeacherRoomRepositories::create($postData);
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 需填選必填選項'
        ];
    }

    /*
     * room add
     */
    public function roomEdit()
    {
        $postData = Request::input();

        if ( isset($postData['Room_name']) && isset($postData['Room_phone'])) {
            //id
            $id = $postData['Id'];
            unset($postData['Id']);

            return TeacherRoomRepositories::updateById($postData, $id);
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 需填選必填選項'
        ];
    }

    /*
     * room delete
     */
    public function roomDelete()
    {
        $postData = Request::input();

        if ( isset($postData['Id']) ) {
            return TeacherRoomRepositories::delete($postData['Id']);
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 需填選必填選項'
        ];
    }

    /*
     * work add
     */
    public function workAdd()
    {
        $postData = Request::input();

        if ( isset($postData['Work_name']) && isset($postData['Work_location']) && isset($postData['Work_time']) && isset($postData['Work_class']) ) {
            //add Stu_id
            $postData['Te_Id'] = getUserId();
            return TeacherExpworkRepositories::create($postData);
        }

        return [
            'status' => 'error',
            'msg' => '發生錯誤 需填選必填選項'
        ];
    }

    /*
     * work Edit
     */
    public function workEdit()
    {
        $postData = Request::input();
        if ( isset($postData['Work_name']) && isset($postData['Work_location']) && isset($postData['Work_time']) && isset($postData['Work_class']) ) {
            //id
            $id = $postData['Id'];
            unset($postData['Id']);

            return TeacherExpworkRepositories::updateById($postData, $id);
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
            return TeacherExpworkRepositories::delete($postData['Id']);
        }
    }
}
