<?php

namespace App\Http\Controllers;

use App\Services\UserAuthServices;
use Request, Auth;

class LoginController extends Controller
{
    /*
     * login index
     */
    public function index()
    {
    	//is login go target index
        return view('login');
    }

    /*
     * login auth
     */
    public function auth()
    {
       	$request = Request::input();

        if ( isset($request['loginType']) && isset($request['loginId']) && isset($request['str_check']) ) {
            $str_check = md5($request['loginType'] . $request['loginId'] . 'base64:O3k9fQETL75AqVlP9ZU29wvnGMQQz87GmNiulPraURE=');
            if ( $str_check != $request['str_check'] ) {
                return [
                    'status' => 'error',
                    'message' => 'str_check 錯誤',
                ];
            }

            return [
                'status' => 'success',
                'message' => '參數確認正確 登入成功',
            ];
        }

        return [
            'status' => 'error',
            'message' => '缺少傳入參數',
        ];
    }

    public function authAuto()
    {
        $request = Request::input();

        return UserAuthServices::autoLogin($request);
    }

    /*
     * logout
     */
    public function logout()
    {
    	Auth::logout();

    	return redirect('/');
    }
}
