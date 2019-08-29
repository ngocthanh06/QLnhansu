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
    //Get role
    protected function getrole(){
        return account::find(Auth::user()->id_role)->getRole;
    }
    //Lấy time now
    protected function gettimenow()
    {
        return Carbon::now()->toDateString();
    }
    //get permission
    public function getPermission(){
        //Get role by role id
        $data['role'] = $this->getrole();
        //get account id then query data of the contract existing and contract should join with type contract
        $contract = contract::find(Auth::user()->id);
        $data['contract_user'] = $contract->getContr($contract->id);
        //query data get info contract
        //after query detail contract -> attendance -> 1 is permission if have
        $data['num'] = 1;
        $data['now'] = $this->gettimenow();
        return view('Admin/Permission/main',$data);
   }

}
