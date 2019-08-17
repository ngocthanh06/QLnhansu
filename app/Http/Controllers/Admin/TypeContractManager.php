<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Type_contract;
use Illuminate\Support\Facades\Auth;
use App\Models\account;

class TypeContractManager extends Controller
{
    //
    //Lấy quyền truy cấp
    protected function getrole(){
        //Get quyền
        return account::find(Auth::user()->id_role)->getRole;
    }
     //Loại hợp đồng
    //Get list loại Hợp đồng
    public function getTypeContract(){
        //Get quyền
        $data['role'] = $this->getrole();
        $data['type_contract'] = Type_contract::all();
        return view('Admin/TypeContract/Main',$data);
    }
}
