<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\account;
use App\Models\salary;
use App\Models\contract;
use App\Models\attendance;
use App\Http\Requests\AddSalaryRequest;
use App;
use DB;
use Carbon\Carbon;
use App\Models\permission;
use Illuminate\Support\Facades\Hash;

class SalaryManager extends Controller
{
    protected function getrole()
    {
        //Get quyền
        return account::find(Auth::user()->id_role)->getRole;
    }
    //Tính khoảng cách của 2 ngày
    public function cal2Day($date_start,$date_end){
        $data = (strtotime($date_end) - strtotime($date_start))/ (60 * 60 * 24);
        return $data;
    }

    //Lấy thời gian
    protected function gettimenow()
    {
        return Carbon::now()->toDateString();
    }
    //Lấy tháng hiện tại
    protected function getMonth()
    {
        $date = Carbon::now();
        return $date->month;
    }
    //Lấy dữ liệu ngày công theo id contrac, per,sta theo tháng
    protected  function  getValMonth($month,$id)
    {
        return attendance::where(function($query) use ($id, $month) {
            $query->whereMonth('day',$month)->where('id_contract',$id)->where('permission',1)->where('status',1);
        })->orWhere(function($request)use ($id, $month){
            $request->whereMonth('day',$month)->where('id_contract',$id)->where('permission',0)->where('status',0);
        })->get();
    }

    //Số ngày công đã làm được theo id contract
    protected function getAtt($id)
    {
        return DB::table('attendance')->where('id_contract', $id)->where('status', '1')->where('permission', '0')->orWhere('status', '1')->where('permission', '1')->where('id_contract', $id)->get();
    }
    //Số ngày đã thanh toán
    protected function getPay($id){
        return DB::table('salary')->select('num_done')->where('id_attent',$id)->get();
    }

    //Chuyển đổi đinh dạng ngày
    protected function formatDate($day)
    {
        return date("Y-m-d", strtotime($day));
    }

    //Chuyển đổi tiền sang số
    protected function formatVNDtoInt($num)
    {
        return preg_replace("/([^0-9\\.])/i", "", $num);
    }

    //Attent work in month
    protected function getMonthWork($id)
    {
        return DB::table('attendance')->where('id_contract', $id)->where('status', '1')->where('permission', '0')->whereMonth('day',Carbon::parse(Carbon::now())->month)->orWhere('status', '1')->where('permission', '1')->where('id_contract', $id)->whereMonth('day',Carbon::parse(Carbon::now())->month)->get();
    }

    //Get lương
    public function getSalary($id)
    {
        //Lấy quyền
        $data['role'] = $this->getrole();
        //Lấy thông tin của hợp đồng
        $info = contract::find($id);
        //Lấy thông tin của nhân viên
        $data['acc'] = $info->getAccount($id);
        //Lấy thời gian hiện tại
        $data['now'] = $this->gettimenow();
        //Lấy thông tin của attend
        $data['info'] = $this->getAtt($id);
        //Lấy số ngày công đã làm trong tháng
        $data['att'] = count($this->getAtt($id));
        //Lấy số ngày công đã thanh toán
        $sumpay = $this->getPay($id);
        $data['pay'] = 0;
        //Lấy số ngày công đã thanh toán
        foreach($sumpay as $sum)
        {
            $data['pay'] = $data['pay'] + $sum->num_done;
        }
        //Lấy danh sách lãnh lương của nhân viên
        $data['salary'] = DB::table('salary')->where('id_attent', $id)->get();
        //Số thứ tự
        $data['num'] = 1;
        $data['now'] = $this->gettimenow();
        $data['id'] = $id;
        //Lấy số ngày phép
        $data['per'] = count(permission::where('id_contract',$data['acc']->id)->where('status',1)->get());
        //Vắng không phép
        $data['miss'] = count(attendance::where('id_contract',$data['acc']->id)->where('status',0)->where('status',0)->get());
        return view('Admin/Salary/main', $data);
    }

    //Post lương
    public function postSalary(AddSalaryRequest $request, $id)
    {
        $salary = salary::find($id);

        //Kiểm tra thanh toán đã tồn tại chưa

        if ($salary == null) {
            $timeSa = Carbon::parse($request->date_now)->toDateString();
            //Kiểm tra số ngày công trong hợp đồng
            $attent = attendance::where('id_contract',$id)->get();

            foreach($attent as $att)
            {
                $time = Carbon::parse($att->day)->toDateString();
            }
            if($this->cal2Day($time,$timeSa) < 0)
            {
                return back()->withInput()->with('error','Ngày thanh toán không được nhỏ hơn ngày công hiện có');
            }
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
        } else {

            $salary['position'] = $request->position + $salary->position;
            $salary['reward'] = $request->reward + $salary->reward;
            //Lương theo ngày
            $salary['sum_position'] = $this->formatVNDtoInt($request->sum_postion) + $salary->sum_position;
            $salary['reviced_date'] = $this->formatDate($request->date_now);
            $salary['num_done'] = $request->num_done + $salary->num_done;
            $salary->update();
        }


        return back()->withInput()->with('success', 'Thanh toán lương thành công');
    }

    //Tính lương theo tháng mới
    public function PostMonth(Request $request)
    {

        $request->validate([
            'num_attendance' => 'not_in:0',
            ],
            [
                'num_attendance.not_in'=>'Nhân viên trong tháng chưa có công'
            ]);
        if(!isset($request->validate))
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
            $salary['id_attent'] = $request->id;
            $salary->save();
            return back()->withInput()->with('success','Thêm thành công');
        }
    }

    //Salary Employs
    public  function SalaryEmploys(){
        //get role user
        $data['role'] = $this->getrole();
        //get value salary when join account through id_contract
        $data['salary'] = DB::table('salary')->join('contract','salary.id_attent','contract.id')->where('contract.id_account',Auth::user()->id)->simplePaginate(5);

        return view('Admin/salary/salaryEmploys',$data);
    }
}
