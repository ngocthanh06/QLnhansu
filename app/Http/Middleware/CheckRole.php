<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use App\Models\account;
use Closure;

class CheckRole
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
        if($data->id == 1)
            return redirect()->intended('admin/user');
        else
        return $next($request);
    }
}
