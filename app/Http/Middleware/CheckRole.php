<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use App\Models\account;
use Closure;

class CheckRole
{

    public function handle($request, Closure $next)
    {

//        $data = account::find(Auth::user()->id_role);

        if(Auth::user()->id_role == 1)
            return redirect()->intended('admin/user');
        else
        return $next($request);
    }
}
