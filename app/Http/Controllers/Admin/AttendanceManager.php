<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\account;
use App\Models\contract;
use App;
use DB;
use Carbon\Carbon;


class AttendanceManager extends Controller
{
    //kiểm tra ngày nghỉ phép của hợp đồng
    protected function checkPerr($id){
        $data = DB::table('permission')->where('id_contract',$id)->get();
        return $data;
    }
    //Lấy quyền truy cấp
    protected function getrole(){
        //Get quyền
        return account::find(Auth::user()->id_role)->getRole;
    }
    //Số ngày công đã làm được theo id contract
    protected function getAtt($id)
    {
        return DB::table('attendance')->where('id_contract',$id)->where('status','1')->where('permission','0')->orWhere('status','1')->where('permission','1')->where('id_contract',$id)->get();
    }
    //
    //Chấm công
    //Get chấm công
    //Còn chỉnh sửa đoạn nghỉ phép và lương
    public function getAttendance($id){
        //Get quyền
        $data['role'] = $this->getrole();
        $info = contract::find($id);
        //Thông tin attendance có bao nhiêu
        $data['contract'] = $info->checkAttend;
        //Số ngày đã làm
        $data['work'] =count($this->getAtt($id));
        //Cập nhật thông tin của ngày công trong bảng lương
        $salary = DB::table('salary')->where('id_attent',$id)->update(['num_attendance'=>$data['work']]);
       //  $salary->save();
        //Thông tin tài khoản
        $data['acc'] = $info->getAccount($id);
        //Số thứ tự
        $data['num'] = 1;
        //Lấy ngày bắt đầu, kết thúc
        $data['end'] = $data['acc']->date_end;
        $data['start1'] = $data['acc']->date_start;
        //Lấy số lượng công làm trong attendance
        $count = count($info->checkAttend);
        //Số ngày <0 không được phép thêm điểm danh
        $data['count']= (strtotime($data['end']) - strtotime($data['start1']))/ (60 * 60 * 24) - $count;
        //lấy ngày hiện tại
        $data['now'] = (Carbon::now())->toDateString();
        //Lấy ngày nghỉ phép của hợp đồng
        $data['check'] = $this->checkPerr($id);
        //số ngày nghỉ
        $data['countCheck'] = count( $this->checkPerr($id));
        //lấy danh sách đơn xin phép
       $data['permi'] = count(DB::table('permission')->where('id_contract',$id)->get());
       //Đếm số lượng đơn xin phép được chấp thuận
       $data['countPer'] = count(DB::table('permission')->where('id_contract',$id)->where('status','1')->get());
       //  dd($data);
        return view('Admin/Attendance/main',$data);
   }

   //Bảng công
   public function GetAtendance()
   {
       //Get quyền
       $role = $this->getrole();
       $a = 11;
       return view('Admin/Attendance/GetAttendance',compact('role','a'));
   }
}
