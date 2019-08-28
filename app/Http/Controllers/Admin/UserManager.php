<?php

namespace App\Http\Controllers\Admin;

use App\Models\attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Models\account;
use Illuminate\Support\Facades\Hash;
use DB;

class UserManager extends Controller
{
    //Get role
    protected function getrole(){
        return account::find(Auth::user()->id_role)->getRole;
    }
     //List employees
     public function getUser(){
        //Get role
        $data['role'] = $this->getrole();
        $data['all_User'] =DB::table('account')->select('account.address','account.id','name','name_role','sex','info','username','passport','account.num_account','account.BHXH')->leftjoin('role','role.id','account.id_role')->where('id_role','1')->orWhere('id_role','2')->paginate(5);

        return view('Admin/Nhanvien/main',$data);
    }
    //Get add employees
    public function getAddUser(){
        //Get role
        $data['role'] = $this->getrole();
        return view('Admin/Nhanvien/Add',$data);
    }
    //Post employees
    public function postAddUser(AddUserRequest $request){
        $user = new account;
        $user['bank'] = $request->bank;
        $user['name'] = $request->name;
        $user['address'] = $request->address;
        $user['username'] = $request->username;
        $user['password'] = bcrypt($request->password);
        $user['passport'] = $request->passport;
        $user['id_role'] = $request->id_role;
        $user['info'] = $request->info;
        $user['sex'] = $request->sex;
        $user['num_account']=$request->num_account;
        $user['BHXH'] = $request->BHXH;
        $user->save();
        return redirect()->intended('admin/user')->with('success', 'Thêm nhân viên thành công');
    }
    //Get edit employees
    public function getEditUser($id){
         //Get role
         $data['role'] = $this->getrole();
         $data['user'] = account::find($id);
         return view('Admin/Nhanvien/Edit',$data);

    }
    //Post edit employees
    public function postEditUser(EditUserRequest $request,$id){
        $user = account::find($id);
        $user['bank'] = $request->bank;
        $user['name'] = $request->name;
        $user['address'] = $request->address;
        $user['username'] = $request->username;
        if(!Hash::check($user['password'],Hash::make($request->password)))
        $user['password'] =  hash::make($request->password);
        $user['passport'] = $request->passport;
        $user['id_role'] = $request->id_role;
        $user['info'] = $request->info;
        $user['sex'] = $request->sex;
        $user['num_account']= $request->num_account;
        $user['BHXH'] = $request->BHXH;
        if(!empty($user->getDirty())){
           $user->update();
           return redirect()->intended('admin/user')->with('success','Sửa thông tin thành công');
        }
        else
        return redirect()->intended('admin/user')->with('error','Thông tin không thay đổi');

    }
    //Delete employees
    public function getDeleteUser($id){
        $user = account::find($id);
        $user->Delete();
        return back()->withInput()->with('success','Đã xóa thành công');
    }
}
