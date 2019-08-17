<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\account;
use App\Models\salary;
use App\Models\contract;
use App\Http\Requests\AddSalaryRequest;
use App;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class SalaryManager extends Controller
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
     //Số ngày công đã làm được theo id contract
     protected function getAtt($id)
     {
         return DB::table('attendance')->where('id_contract',$id)->where('status','1')->where('permission','0')->orWhere('status','1')->where('permission','1')->where('id_contract',$id)->get();
     }
     //Chuyển đổi đinh dạng ngày
    protected function formatDate($day)
    {
       return date("Y-m-d",strtotime($day));
    }  
    //Chuyển đổi tiền sang số
    protected function formatVNDtoInt($num){
        return preg_replace("/([^0-9\\.])/i", "", $num);
    }

   //Get lương
   public function getSalary($id){
       $data['role'] = $this->getrole();
       //Lấy thông tin của hợp đồng
       $info = contract::find($id);
       //Lấy thông tin của nhân viên
       $data['acc'] = $info->getAccount($id);
       //Lấy thông tin của attend
       $data['info'] = $this->getAtt($id);
       //Lấy số ngày công đã làm
       // $count = 
       // dd($id);
       $data['att'] = count($this->getAtt($id));
       //Lấy danh sách lãnh lương của nhân viên
       $data['salary'] = DB::table('salary')->where('id_attent',$id)->get();
       //Số thứ tự
       $data['num']= 1;
       
       return view('Admin/Salary/main',$data);  
   }
   
   //Post lương
   public function postSalary(AddSalaryRequest $request,$id){
       //Kiểm tra thanh toán đã tồn tại chưa
       $salary = salary::find($id);
       //Nếu chưa thì tạo mới
       if($salary==null)
       {
           $salary = new salary;
           $salary['num_attendance'] = $request->num_attendance;
           $salary['position'] = $request->position;
           $salary['reward'] = $request->reward;
           //Lương theo ngày
           $salary['allowance'] = $request->salary_date;
           $salary['sum_position'] = $this->formatVNDtoInt($request->sum_postion);
           $salary['reviced_date'] = $this->formatDate($request->date_now);
           $salary['num_done'] = $request->num_done;
           $salary['id_attent'] = $id;
           $salary->save();
       }
       else
       {
           $salary['position'] = $request->position + $salary->position;
           $salary['reward'] = $request->reward + $salary->reward;
           //Lương theo ngày
           $salary['sum_position'] = $this->formatVNDtoInt($request->sum_postion) + $salary->sum_position;
           $salary['reviced_date'] = $this->formatDate($request->date_now);
           $salary['num_done'] = $request->num_done + $salary->num_done;
           $salary->update();
       }

       
       return back()->withInput()->with('success','Thanh toán lương thành công');
   }
}
