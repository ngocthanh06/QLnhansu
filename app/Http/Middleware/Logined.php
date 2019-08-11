<?php

namespace App\Http\Middleware;

use Closure;
use Auth;


class Logined
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
        //kiểm tra người dùng đã đăng nhập chưa
        //Nếu đăng nhập thì chuyển qua trang admin/home
        if(Auth::check()){

            return redirect()->intended('admin/home');
        }
        else
        return $next($request);
    }
}
