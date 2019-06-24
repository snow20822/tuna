<?php

if (! function_exists('getStudentPhotoUrl')) {
    /**
     * 左上角 小圖用 (登入帳號的大頭貼路徑)
     * @return string
     */
    function getStudentPhotoUrl()
    {
        $time = date('YmdHi');
        //1 = auth member id 功能好了要改掉
        $imgPath = asset(env('UPLOAD_FOLDER_NAME') . '/1/photo.jpg') . '?v=' . $time;

        $filePath = public_path(env('UPLOAD_FOLDER_NAME') . '/1/photo.jpg');

        $imgUrl = (is_file($filePath)) ? $imgPath : asset('image/not-use/user.jpg');

        return $imgUrl;
    }
}

if (! function_exists('getTeacherPhotoUrl')) {
    /**
     * 左上角 小圖用 (登入帳號的大頭貼路徑)
     * @return string
     */
    function getTeacherPhotoUrl()
    {
        $time = date('YmdHi');
        //1 = auth member id 功能好了要改掉
        $imgPath = asset(env('UPLOAD_FOLDER_NAME') . '/1/photo.jpg') . '?v=' . $time;
        $filePath = public_path(env('UPLOAD_FOLDER_NAME') . '/1/photo.jpg');

        $imgUrl = (is_file($filePath)) ? $imgPath : asset('image/not-use/teacher.jpg');

        return $imgUrl;
    }
}

if (! function_exists('getUserId')) {
    /**
     * 左上角 小圖用 (登入帳號的大頭貼路徑)
     * @return string
     */
    function getUserId()
    {
        //暫時只用1
        return 1;
    }
}