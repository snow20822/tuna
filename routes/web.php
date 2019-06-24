<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'LoginController@index');
Route::post('login/auth', 'LoginController@auth');
Route::post('login/authAuto', 'LoginController@authAuto');

//Route::group(['middleware' => 'auth'], function () {
	//student
	Route::group(['prefix' => 'student'], function () {
	    Route::get('resume/select', function () {
		    return view('student.resumeSelect');
		});
	    Route::get('resume/preview', function () {
		    return view('student.resumePreview');
		});
	    Route::get('work/project', function () {
		    return view('student.workProject');
		});
	    Route::get('earlyWarning', function () {
		    return view('student.earlyWarning');
		});
		Route::get('resume', 'Student\ResumeController@index');
		//get init resume
		Route::get('resumeInit', 'Student\ResumeController@init');
		//post about
		Route::post('aboutEdit', 'Student\ResumeController@aboutEdit');
		//post profileWeb
		Route::post('profileWeb', 'Student\ResumeController@profileWeb');
		//education
		Route::post('educationAdd', 'Student\ResumeController@educationAdd');
		Route::post('educationEdit', 'Student\ResumeController@educationEdit');
		Route::delete('educationDelete', 'Student\ResumeController@educationDelete');
		//work
		Route::post('workAdd', 'Student\ResumeController@workAdd');
		Route::post('workEdit', 'Student\ResumeController@workEdit');
		Route::delete('workDelete', 'Student\ResumeController@workDelete');
		//learnCourse
		Route::get('learn/course', 'Student\LearnCourseController@index');
		Route::get('learnCourseInit', 'Student\LearnCourseController@init');
		Route::get('initAllTerm', 'Student\LearnCourseController@initAllTerm');
		Route::post('setSearchData', 'Student\LearnCourseController@setSearchData');
	    Route::get('learn/course/discuss', function () {
		    return view('student.learnCourseDiscuss');
		});
		//logout
		Route::get('logout', 'LoginController@logout');
		//upload user img
		Route::post('userUpload', 'Student\PhotoController@userUpload');
		//個人相簿
		Route::get('myGallery', 'Student\GalleryController@index');
		Route::get('myGallery/init', 'Student\GalleryController@init');
		Route::post('myGallery/add', 'Student\GalleryController@add');
		Route::post('myGallery/edit', 'Student\GalleryController@edit');
		Route::delete('myGallery/delete', 'Student\GalleryController@delete');
		//個人相簿detail
	    Route::get('myGalleryDetail/init', 'Student\GalleryDetailController@init');
	    Route::get('myGalleryDetail/edit', 'Student\GalleryDetailController@edit');
	    Route::post('myGalleryDetail/add', 'Student\GalleryDetailController@add');
	    Route::post('myGalleryDetail/editPost', 'Student\GalleryDetailController@editPost');
	    Route::delete('myGalleryDetail/delete', 'Student\GalleryDetailController@delete');
	    //活動歷程
	    Route::get('activityCourse/init', 'Student\ActivityCourseController@init');
	    Route::get('activity/course', 'Student\ActivityCourseController@index');
	    Route::post('activityCourse/activityAdd', 'Student\ActivityCourseController@activityAdd');
	    Route::post('activityCourse/activityEdit', 'Student\ActivityCourseController@activityEdit');
	    Route::delete('activityCourse/activityDelete', 'Student\ActivityCourseController@activityDelete');
	    Route::post('activityCourse/communityAdd', 'Student\ActivityCourseController@communityAdd');
	    Route::post('activityCourse/communityEdit', 'Student\ActivityCourseController@communityEdit');
	    Route::delete('activityCourse/communityDelete', 'Student\ActivityCourseController@communityDelete');
	    Route::post('activityCourse/practiceAdd', 'Student\ActivityCourseController@practiceAdd');
	    Route::post('activityCourse/practiceEdit', 'Student\ActivityCourseController@practiceEdit');
	    Route::delete('activityCourse/practiceDelete', 'Student\ActivityCourseController@practiceDelete');
	    //職涯歷程
	    Route::get('work/course', 'Student\WorkCourseController@index');
	    Route::get('workCourse/init', 'Student\WorkCourseController@init');
	    Route::post('workCourse/liceAdd', 'Student\WorkCourseController@liceAdd');
	    Route::post('workCourse/liceEdit', 'Student\WorkCourseController@liceEdit');
	    Route::delete('workCourse/liceDelete', 'Student\WorkCourseController@liceDelete');
	    Route::post('workCourse/parcAdd', 'Student\WorkCourseController@parcAdd');
	    Route::post('workCourse/parcEdit', 'Student\WorkCourseController@parcEdit');
	    Route::delete('workCourse/parcDelete', 'Student\WorkCourseController@parcDelete');
	    Route::post('workCourse/readAdd', 'Student\WorkCourseController@readAdd');
	    Route::post('workCourse/readEdit', 'Student\WorkCourseController@readEdit');
	    Route::delete('workCourse/readDelete', 'Student\WorkCourseController@readDelete');
	    //榮譽紀錄
	    Route::get('honorary/record', 'Student\HonoraryRecordController@index');
	    Route::get('honoraryRecord/init', 'Student\HonoraryRecordController@init');
	    Route::post('honoraryRecord/schshipAdd', 'Student\HonoraryRecordController@schshipAdd');
	    Route::post('honoraryRecord/schshipEdit', 'Student\HonoraryRecordController@schshipEdit');
	    Route::delete('honoraryRecord/schshipDelete', 'Student\HonoraryRecordController@schshipDelete');
	    Route::post('honoraryRecord/raceAdd', 'Student\HonoraryRecordController@raceAdd');
	    Route::post('honoraryRecord/raceEdit', 'Student\HonoraryRecordController@raceEdit');
	    Route::delete('honoraryRecord/raceDelete', 'Student\HonoraryRecordController@raceDelete');
	    //作品專區
	    Route::get('work/project', 'Student\WorkProjectController@index');
	    Route::get('workProject/init', 'Student\WorkProjectController@init');
	    Route::post('workProject/exhiAdd', 'Student\WorkProjectController@exhiAdd');
	    Route::post('workProject/exhiEdit', 'Student\WorkProjectController@exhiEdit');
	    Route::delete('workProject/exhiDelete', 'Student\WorkProjectController@exhiDelete');
	    Route::post('workProject/showAdd', 'Student\WorkProjectController@showAdd');
	    Route::post('workProject/showEdit', 'Student\WorkProjectController@showEdit');
	    Route::delete('workProject/showDelete', 'Student\WorkProjectController@showDelete');
	    Route::post('workProject/perworksAdd', 'Student\WorkProjectController@perworksAdd');
	    Route::post('workProject/perworksEdit', 'Student\WorkProjectController@perworksEdit');
	    Route::delete('workProject/perworksDelete', 'Student\WorkProjectController@perworksDelete');
	    //分享搜尋
	    Route::get('share/search', 'Student\ShareSearchController@index');
	    Route::get('shareSearch/init', 'Student\ShareSearchController@init');
	    Route::post('shareSearch/add', 'Student\ShareSearchController@add');
	    Route::post('shareSearch/edit', 'Student\ShareSearchController@edit');
	    Route::delete('shareSearch/delete', 'Student\ShareSearchController@delete');
	});

	//teacher
	Route::group(['prefix' => 'teacher'], function () {
		//get init resume
		Route::get('resumeInit', 'Teacher\ResumeController@resumeInit');

		Route::get('resume', 'Teacher\ResumeController@index');
		Route::post('introductionEdit', 'Teacher\ResumeController@introductionEdit');
		//education
		Route::post('educationAdd', 'Teacher\ResumeController@educationAdd');
		Route::post('educationEdit', 'Teacher\ResumeController@educationEdit');
		Route::delete('educationDelete', 'Teacher\ResumeController@educationDelete');
		//work
		Route::post('workAdd', 'Teacher\ResumeController@workAdd');
		Route::post('workEdit', 'Teacher\ResumeController@workEdit');
		Route::delete('workDelete', 'Teacher\ResumeController@workDelete');
		//honor
		Route::post('honorAdd', 'Teacher\ResumeController@honorAdd');
		Route::post('honorEdit', 'Teacher\ResumeController@honorEdit');
		Route::delete('honorDelete', 'Teacher\ResumeController@honorDelete');
		//room
		Route::post('roomAdd', 'Teacher\ResumeController@roomAdd');
		Route::post('roomEdit', 'Teacher\ResumeController@roomEdit');
		Route::delete('roomDelete', 'Teacher\ResumeController@roomDelete');

	    Route::get('research', function () {
		    return view('teacher.research');
		});
		Route::get('syllabus', 'Teacher\SyllabusController@index');
		//get init syllabus
		Route::get('syllabusInit', 'Teacher\SyllabusController@syllabusInit');
		//teachingTerm
		Route::post('teachingTerm', 'Teacher\SyllabusController@teachingTerm');
		//teachstuTerm
		Route::post('teachstuTerm', 'Teacher\SyllabusController@teachstuTerm');
		//teachstu
		Route::post('teachstuAdd', 'Teacher\SyllabusController@teachstuAdd');
		Route::post('teachstuEdit', 'Teacher\SyllabusController@teachstuEdit');
		Route::delete('teachstuDelete', 'Teacher\SyllabusController@teachstuDelete');

		//活動與輔導
		Route::get('activityRecord', 'Teacher\ActivityRecordController@index');
		//get init syllabus
		Route::get('activityRecordInit', 'Teacher\ActivityRecordController@activityRecordInit');
		//activityTerm
		Route::post('activityTerm', 'Teacher\ActivityRecordController@activityTerm');
		//talksTerm
		Route::post('talksTerm', 'Teacher\ActivityRecordController@talksTerm');

		//logout
		Route::get('logout', 'LoginController@logout');
	});
//});