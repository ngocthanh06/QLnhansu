<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\account;


class LoginController extends Controller
{
    //
        //Get Login
        public function getlogin(){
            return view('Admin/login');
        }
        //Post Login
        public function postlogin(Request $request){
            $data = [
                'username' => $request->username,
                'password' => $request->password,
            ];

            if(Auth::attempt($data)){
                $role = account::find(Auth::user()->id_role)->getRole;

                    if($role->id == 2)
                        return redirect()->intended('admin/home');
                    else
                        return redirect()->intended('admin/user');


            }
            else
            return back()->withInput()->with('error','Sai tên đăng nhập hoặc mật khẩu');

        }

        //Logout
        public function getLogout(){
            Auth::logout();
            return redirect()->intended('login');
        }
}
