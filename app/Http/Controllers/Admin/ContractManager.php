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

class ContractManager extends Controller
{
    //Lấy thời gian
    protected function gettimenow()
    {
        return Carbon::now()->toDateString();
    }
     //Lấy quyền truy cấp
     protected function getrole(){
        //Get quyền
        return account::find(Auth::user()->id_role)->getRole;
    }
    //Tính số ngày
    //Tính khoảng cách của 2 ngày
    public function cal2Day($date_start,$date_end){
        $data = (strtotime($date_end) - strtotime($date_start))/ (60 * 60 * 24);
        return $data;
}
 //Chuyển đổi đinh dạng ngày
 protected function formatDate($day)
 {
    return date("Y-m-d",strtotime($day));
 }

    //Hợp đồng
    //Lấy danh sách hợp đồng
    public function getContract(){
        //Get quyền
        $data['role'] = $this->getrole();
        //Lấy thông tin danh sách hợp đồng có loại hợp đồng và thông tin nhân viên
        $data['contract'] = DB::table('contract')->select('contract.coefficients','contract.id','name_contract','date_start','date_end','num_work','name','username','name_type')->join('account','account.id','contract.id_account')->join('type_contract','contract.id_type_contract','type_contract.id')->where('account.id_role',2)->orderBy('contract.id')->paginate(5);
        $data['now'] = Carbon::now()->toDateString();
        return view('Admin/Contract/main',$data);
    }
    //Thêm hợp đồng
    public function getAddContract(){
        //Get quyền
        $data['role'] = $this->getrole();
        //Lấy loại hợp đồng
        $data['type_contract'] = Type_contract::all();
        $data['user'] = account::all()->where('id_role',2);
        return view('Admin/Contract/Add',$data);
    }
    //Post Thêm hợp đồng
    public function postAddContract(AddContract $request){

        $data = contract::find($request->id_account);
        if($data != null)
        //Lấy ngày làm việc kết thúc sớm nhất của hợp đồng
        $getcontract = $data->checkContract($request->id_account);
        else
            $getcontract = '';
        //Kiểm tra số ngày kết thúc hợp đồng có còn không
        //Bằng $getcontract=1 nghĩa là ngày kết thúc null->hợp đồng chưa kết thúc
        if($getcontract != "" || $getcontract==1)
        return back()->withInput()->with('error','Nhân viên vẫn còn hợp đồng');
        else{
        $contract = new contract;
        $contract['id_type_contract'] = $request->id_type_contract;
        $contract['id_account']= $request->id_account;
        $contract['name_contract']= $request->name_contract;
        $contract['date_start']= date("Y-m-d",strtotime($request->date_now));
        $contract['num_max']= $request->num_max;
        $contract['coefficients']= $request->coefficients;
        $contract['content']= $request->content;
        $contract['num_work']= (strtotime($request->date_end) - strtotime($request->date_start))/ (60 * 60 * 24)+1;
        $contract->save();
        return redirect()->intended('admin/contract')->with('success','Thêm hợp đồng thành công');
        }
    }
    //Get Edit contract
    public function getEditContract($id){
        //Get quyền
        $data['role'] = $this->getrole();
        //Truy vấn hợp đồng
        $data['contract'] = contract::find($id);
        //Lấy loại hợp đồng
        $data['type_contract'] = Type_contract::all();
        $data['user'] = account::all()->where('id_role',2);
        return view('Admin/Contract/Edit',$data);

    }
    //Post Edit contract
    public function postEditContract(Request $request,$id){
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
            return redirect()->intended('admin/contract')->with('success','Sửa thông tin thành công');
         }
         else
         return redirect()->intended('admin/contract')->with('error','Thông tin không thay đổi');

    }

    //Hủy Hợp đồng
    public function DeleteContract($id){
        //Get quyền
        $data['role'] = $this->getrole();
        $data['contract'] = contract::find($id);
        return view ('Admin/Contract/Dele',$data);
    }

    //Post hủy hợp đồng
    public function PostDeleteContract(Request $request,$id){

        $contract = contract::find($id);
        $now = $this->gettimenow();
        $contract['date_end'] =$this->formatDate($request->date_now);
        $check = $this->cal2Day($contract->date_start,$contract['date_end']);
        if($check > 0){
        $contract['num_work'] = $check;
        $contract->update();
            return redirect()->intended('admin/contract')->with('success','Hợp đồng đã được hủy theo số ngày thành công');
        }
        else
        return back()->withInput()->with('error','Số ngày kết thúc hợp đồng không được nhỏ hơn ngày bắt đầu');

    }
}
