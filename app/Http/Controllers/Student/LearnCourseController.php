<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Repositories\StudyRepositories;
use App\Repositories\AbsentRepositories;
use App\Repositories\ServiceRepositories;
use Request, Auth;

class LearnCourseController extends Controller
{
    /*
     * 學習歷程
     */
    public function index()
    {
        return view('student.learnCourse');
    }

    /*
     * init
     */
    public function init()
    {
        $userId = getUserId();
        
        //history
        $historyTerm = session()->has('studentLearnCourse.history.historyTerm') ? session('studentLearnCourse.history.historyTerm') : '100';
        $historyTermType = session()->has('studentLearnCourse.history.historyTermType') ? session('studentLearnCourse.history.historyTermType') : '2';
        //absentTerm
        $absentTerm = session()->has('studentLearnCourse.absent.absentTerm') ? session('studentLearnCourse.absent.absentTerm') : '100';
        $absentTermType = session()->has('studentLearnCourse.absent.absentTermType') ? session('studentLearnCourse.absent.absentTermType') : '2';
        //serviceTerm
        $serviceTerm = session()->has('studentLearnCourse.service.serviceTerm') ? session('studentLearnCourse.service.serviceTerm') : '100';
        $serviceTermType = session()->has('studentLearnCourse.service.serviceTermType') ? session('studentLearnCourse.service.serviceTermType') : '2';

        return [
            'infoData' => [
                'history' => StudyRepositories::getByFilters([
                    'Stu_Id' => $userId,
                    'Sch_term' => $historyTerm,
                    'Sch_term_type' => $historyTermType,
                ]),
                'absent' => AbsentRepositories::getByFilters([
                    'Stu_Id' => $userId,
                    'Sch_term' => $absentTerm,
                    'Sch_term_type' => $absentTermType,
                ]),
                'service' => ServiceRepositories::getByFilters([
                    'Stu_Id' => $userId,
                    'Sch_term' => $serviceTerm,
                    'Sch_term_type' => $serviceTermType,
                ]),
            ],
            'searchData' => [
                'historyTerm' => $historyTerm,
                'historyTermType' => $historyTermType,
                'absentTerm' => $absentTerm,
                'absentTermType' => $absentTermType,
                'serviceTerm' => $serviceTerm,
                'serviceTermType' => $serviceTermType,
            ],
        ];
    }

    /*
     * init
     */
    public function initAllTerm()
    {
        return [
            'history' => StudyRepositories::allHistoryTerm(['Stu_Id' => getUserId()]),
            'absent' => AbsentRepositories::allHistoryTerm(['Stu_Id' => getUserId()]),
            'service' => ServiceRepositories::allHistoryTerm(['Stu_Id' => getUserId()]),
        ];
    }

    /*
     * init
     */
    public function setSearchData()
    {
        $requset = Request::input();

        if ( isset($requset['historyTerm']) && isset($requset['historyTermType']) ) {
            Session()->put('studentLearnCourse.history', $requset);
        } elseif ( isset($requset['absentTerm']) && isset($requset['absentTermType']) ) {
            Session()->put('studentLearnCourse.absent', $requset);
        } elseif ( isset($requset['serviceTerm']) && isset($requset['serviceTermType']) ) {
            Session()->put('studentLearnCourse.service', $requset);
        }

        return ['status' => 'success'];
    }
}
