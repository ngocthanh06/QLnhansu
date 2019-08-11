<?php

namespace App\Http\Middleware;

use Closure;
use Auth;


class Logout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Kiểm tra người dùng còn đăng nhập chưa
        //nếu không còn thì chuyển người dùng sang trang login bắt đăng nhập
        if(Auth::guest()){
            return redirect()->intended('login');   
        }
        return $next($request);
    }
}
