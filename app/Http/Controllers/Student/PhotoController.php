<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\PhotoUploadServices;
use Request;

class PhotoController extends Controller
{
    /*
     * 學生大頭貼上傳
     */
    public function userUpload()
    {
    	$request = Request::file();

    	if ( isset($request['img']) ) {
            $imgInfo = $request['img'];
            //student login id
            $userId = getUserId();
            //fileName
            $fileName = 'photo.jpg';

            $option = [
                'fit' => true,
                'resize' => true,
                'fitWidth' => 160,
                'fitHeight' => 160,
                'resizeWidth' => null,
                'resizeHeight' => 160,
            ];

            return PhotoUploadServices::doUpload($imgInfo, $userId, $option, $fileName);
    	}
    }
}
