<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\contract;
use App\Models\account;
use App;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class PermissionManager extends Controller
{
    protected function getrole(){
        //Get quyền
        return account::find(Auth::user()->id_role)->getRole;
    }
    //Lấy thời gian
    protected function gettimenow()
    {
        return Carbon::now()->toDateString();
    }
    //
    //Lấy đơn xin nghỉ phép
    public function getPermission(){
        
        //Get quyền ->id của role
        $data['role'] = $this->getrole();
        //Lấy id của tài khoản nhân viên để truy vấn dữ liệu của hợp đồng hiện có-> (contract) join thên loại hợ đồng
        $contract = contract::find(Auth::user()->id);
        $data['contract_user'] = $contract->getContr($contract->id);
        //rồi truy ván dữ liệu lấy thông tin hợp đồng có được-> (attendance)
        //Sau đó truy vấn lấy chi tiết hợp đồng->(attendane)->1 ngày tương ứng với 1 phép nếu có.
        $data['num'] = 1;
        //Lấy id xong 
        //Lấy thời gian hiện tại
        $data['now'] = $this->gettimenow();
       // dd($data);
        return view('Admin/Permission/main',$data);
   }
   
}
