<?php

namespace App\Http\Middleware;

use Closure, Auth, Request;

class AuthWebLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ( ! Auth::guard($guard)->check()) {
            return redirect('/');
        }

        //check type
        $userData = Auth::user();
        $type = $userData->type;

        if ( ! Request::is($type . '/*')) {
            return redirect('/' . $type . '/resume');
        }

        //teacher 不能使用

        return $next($request);
    }
}