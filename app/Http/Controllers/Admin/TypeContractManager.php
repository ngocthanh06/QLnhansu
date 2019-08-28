<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Type_contract;
use Illuminate\Support\Facades\Auth;
use App\Models\account;

class TypeContractManager extends Controller
{
    //get role
    protected function getrole(){
        return account::find(Auth::user()->id_role)->getRole;
    }
     //Type contract
    //Get list type contract
    public function getTypeContract(){
        $data['role'] = $this->getrole();
        $data['type_contract'] = Type_contract::all();
        return view('Admin/TypeContract/Main',$data);
    }
}
