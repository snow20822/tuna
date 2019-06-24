<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Repositories\TeacherActivityRepositories;
use App\Repositories\TeacherTalksRepositories;

use Request, Auth;

class ActivityRecordController extends Controller
{
    /*
     * 個人簡歷
     */
    public function index()
    {
        return view('teacher.activityRecord');
    }

    /*
     * 個人簡歷
     */
    public function activityRecordInit()
    {
        return [
            //活動成果表
            'activity' => TeacherActivityRepositories::getInfoByFilters(array()),
            //get學期
            'getActivityTerm' => TeacherActivityRepositories::getTerm(array()),
            //會談記錄表
            'talks' => TeacherTalksRepositories::getInfoByFilters(array()),
            //get學期
            'getTalksTerm' => TeacherTalksRepositories::getTerm(array()),
        ];
    }

    /*
     * 搜尋活動成果表學期
     */
    public function activityTerm(Request $request)
    {
        $search = Request::input();
        return TeacherActivityRepositories::getInfoByFilters($search);
    }

    /*
     * 搜尋會談記錄表學期
     */
    public function talksTerm(Request $request)
    {
        $search = Request::input();
        return TeacherTalksRepositories::getInfoByFilters($search);
    }
}
