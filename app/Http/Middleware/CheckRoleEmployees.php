<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use App\Models\account;
use Closure;

class CheckRoleEmployees
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
        $data = account::find(Auth::user()->id_role)->getRole;
        if($data->id == 2)
            return redirect()->intended('admin/home');
        else
            return $next($request);
        return $next($request);
    }
}
