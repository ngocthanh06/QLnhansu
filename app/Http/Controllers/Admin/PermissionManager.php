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
        // $contract = contract::find(Auth::user()->id);
        $data['contract_user'] = DB::table('account')->select('contract.id','type_contract.name_type','contract.date_end','contract.date_start','contract.name_contract')->join('contract','contract.id_account','account.id')->join('type_contract','type_contract.id','contract.id_type_contract')->where('account.id',Auth::user()->id)->get();
        //query data get info contract
        //after query detail contract -> attendance -> 1 is permission if have
        $data['num'] = 1;
        $data['now'] = $this->gettimenow();
        return view('Admin/Permission/main',$data);
   }

}
