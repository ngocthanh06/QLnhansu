<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\account;
use App\Models\contract;
use App\Models\Type_contract;
use App;
use DB;
use Carbon\Carbon;
use App\Http\Requests\AddContract;
use FLMess;
class ContractManager extends Controller
{
    //Get time now
    protected function gettimenow()
    {
        return Carbon::now()->toDateString();
    }
     //Get role
     protected function getrole(){
        //Get role
        return account::find(Auth::user()->id_role)->getRole;
    }
    //caculate distance the number of 2 day
    public function cal2Day($date_start,$date_end){
        $data = (strtotime($date_end) - strtotime($date_start))/ (60 * 60 * 24);
        return $data;
    }
    //Convert format day
    protected function formatDate($day)
    {
     return date("Y-m-d",strtotime($day));
    }

    //Contract
    //Get list contract
    public function getContract(){
        //Get role
        $data['role'] = $this->getrole();
        //Get infomation list contract have type contract and info employees ?
        $data['contract'] = DB::table('contract')->select('contract.coefficients','contract.id','name_contract','date_start','date_end','num_work','name','username','name_type')->join('account','account.id','contract.id_account')->join('type_contract','contract.id_type_contract','type_contract.id')->where('account.id_role',2)->orderBy('contract.id')->paginate(5);
        $data['now'] = Carbon::now()->toDateString();
        return view('Admin/Contract/main',$data);
    }
    //Add contract
    public function getAddContract(){
        //Get role
        $data['role'] = $this->getrole();
        //Get contract
        $data['type_contract'] = Type_contract::all();
        $data['user'] = account::all()->where('id_role',2);
        return view('Admin/Contract/Add',$data);
    }
    //Post add contract
    public function postAddContract(AddContract $request){

        $data = contract::find($request->id_account);
        if($data != null)
            //Get working the earliest day end of contract
        $getcontract = $data->checkContract($request->id_account);
        else
            $getcontract = '';
        //checking number day ends have exist ?
        // $getcontract=1 have mean day ends = null -> contract hasn't finished
        if($getcontract != "" || $getcontract==1)
        return back()->withInput()->with('error',FLMess::contractEm());
        else{
            $request['date_start'] = date("Y-m-d",strtotime($request->date_now));
            $request['num_work'] = (strtotime($request->date_end) - strtotime($request->date_start))/ (60 * 60 * 24)+1;
            $contract = contract::create($request->all());
            if($contract)
                return redirect()->intended('admin/contract')->with('success',FLMess::AddSuccess());
            else
                return back()->withInput()->with('error',FLMess::unsuccessful());
        }
    }
    //Get Edit contract
    public function getEditContract($id){
        //Get role
        $data['role'] = $this->getrole();
        //query contract
        $data['contract'] = contract::find($id);
        //get type contract
        $data['type_contract'] = Type_contract::all();
        $data['user'] = account::all()->where('id_role',2);
        return view('Admin/Contract/Edit',$data);

    }
    //Post Edit contract
    public function postEditContract(Request $request,$id){
        $request['date_start'] = date("Y-m-d",strtotime($request->date_now));
        $request['num_work'] = (strtotime($request->date_end) - strtotime($request->date_start))/ (60 * 60 * 24)+1;
        $contract = contract::find($id);
        $contract['id_type_contract'] = $request->id_type_contract;
        $contract['id_account']= $request->id_account;
        $contract['name_contract']= $request->name_contract;
        $contract['date_start']=$this->formatDate($request->date_now);
        $contract['num_max']= $request->num_max;
        $contract['coefficients']= $request->coefficients;
        $contract['content']= $request->content;
        $contract['num_work']= (strtotime($request->date_end) - strtotime($request->date_start))/ (60 * 60 * 24)+1;
        if(!empty($contract->getDirty())){
            $contract->update();
            return redirect()->intended('admin/contract')->with('success',FLMess::EditSuccess());
         }
         else
         return redirect()->intended('admin/contract')->with('error',FLMess::unsuccessful());

    }

    //cancel contract
    public function DeleteContract($id){
        //Get quyền
        $data['role'] = $this->getrole();
        $data['contract'] = contract::find($id);
        return view ('Admin/Contract/Dele',$data);
    }

    //Post cancel contract
    public function PostDeleteContract(Request $request,$id){

        $contract = contract::find($id);
        $now = $this->gettimenow();
        $contract['date_end'] =$this->formatDate($request->date_now);
        $check = $this->cal2Day($contract->date_start,$contract['date_end']);
        if($check > 0){
        $contract['num_work'] = $check;
        $contract->update();
            return redirect()->intended('admin/contract')->with('success',FLMess::Cancelcontract());
        }
        else
        return back()->withInput()->with('error',FLMess::daymis());

    }
}
