<?php

namespace App\Services;

use App\Repositories\UserRepositories;
use Validator, Hash, Auth;

class UserAuthServices
{
    /**
     * do login
     *
     * @param array userPost
     * @return array
     */
    public static function doLogin($userPost)
    {
        //check
        $rules = ['captcha' => 'required|captcha'];
        $validator = Validator::make($userPost, $rules);

        if ($validator->fails()) {
            return [
                'status' => 'error',
                'msg' => '驗證碼錯誤!'
            ];
        }

        $type = $userPost['type'] == 'true' ? 'teacher' : 'student';

        //check type
        $filters = [
            'username' => $userPost['username'],
        ];
        $user = UserRepositories::getByFilters($filters);

        if (empty($user)) {
            return [
                'status' => 'error',
                'msg' => '帳號錯誤!請重新確認'
            ];
        } else {
            $rightPassword = Hash::check($userPost['password'], $user['password']);

            if ( ! $rightPassword) {
                return [
                    'status' => false,
                    'msg' => '密碼錯誤！請重新確認'
                ];
            }
        }

        $authData = [
            'username' => $userPost['username'],
            'password' => $userPost['password'],
            'type' => $type,
        ];

        if (Auth::attempt($authData, true)) {
            return [
                'status' => 'success',
                'url' => url('/' . $type . '/resume'),
            ];
        };

        return [
            'status' => 'error',
            'msg' => '身分錯誤！請重新確認'
        ];
    }

    /**
     * 直接登入拉 驗證個屁
     *
     * @return array
     */
    public static function autoLogin($userPost)
    {
        $type = $userPost['type'] == 'true' ? 'teacher' : 'student';

        return [
            'status' => 'success',
            'url' => url('/' . $type . '/resume'),
        ];
    }
}