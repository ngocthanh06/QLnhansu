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
use FLMess;

class SalaryManager extends Controller
{
    //get role
    protected function getrole()
    {
        return account::find(Auth::user()->id_role)->getRole;
    }
    //calendal distance 2 days
    public function cal2Day($date_start,$date_end){
        $data = (strtotime($date_end) - strtotime($date_start))/ (60 * 60 * 24);
        return $data;
    }
    //Get time now
    protected function gettimenow()
    {
        return Carbon::now()->toDateString();
    }
    //Get Month now
    protected function getMonth()
    {
        $date = Carbon::now();
        return $date->month;
    }
    //get val workdays by contract, per, sta with month
    protected  function  getValMonth($month,$id)
    {
        return attendance::where(function($query) use ($id, $month) {
            $query->whereMonth('day',$month)->where('id_contract',$id)->where('permission',1)->where('status',1);
        })->orWhere(function($request)use ($id, $month){
            $request->whereMonth('day',$month)->where('id_contract',$id)->where('permission',0)->where('status',0);
        })->get();
    }
    //num workdays done with contract id
    protected function getAtt($id)
    {
        return DB::table('attendance')->where('id_contract', $id)->where('status', '1')->where('permission', '0')->orWhere('status', '1')->where('permission', '1')->where('id_contract', $id)->get();
    }
    //Num pay days
    protected function getPay($id){
        return DB::table('salary')->select('num_done')->where('id_attent',$id)->get();
    }
    //Convert format day
    protected function formatDate($day)
    {
        return date("Y-m-d", strtotime($day));
    }
    //convert money -> num
    protected function formatVNDtoInt($num)
    {
        return preg_replace("/([^0-9\\.])/i", "", $num);
    }
    //Attent work in month
    protected function getMonthWork($id)
    {
        return DB::table('attendance')->where('id_contract', $id)->where('status', '1')->where('permission', '0')->whereMonth('day',Carbon::parse(Carbon::now())->month)->orWhere('status', '1')->where('permission', '1')->where('id_contract', $id)->whereMonth('day',Carbon::parse(Carbon::now())->month)->get();
    }
    //Get salary
    public function getSalary($id)
    {
        $data['role'] = $this->getrole();
        //get contract info
        $info = contract::find($id);
        //Get employees info
        $data['acc'] = $info->getAccount($id);
        //Get time now
        $data['now'] = $this->gettimenow();
        //get attend info
        $data['info'] = $this->getAtt($id);
        //get workdays num done in month
        $data['att'] = count($this->getAtt($id));
        //get workdays num paid
        $sumpay = $this->getPay($id);
        $data['pay'] = 0;
        foreach($sumpay as $sum)
        {
            $data['pay'] = $data['pay'] + $sum->num_done;
        }
        //get list salary of the employees
        $data['salary'] = DB::table('salary')->where('id_attent', $id)->get();
        //num
        $data['num'] = 1;
        $data['now'] = $this->gettimenow();
        $data['id'] = $id;
        //get permission
        $data['per'] = count(permission::where('id_contract',$data['acc']->id)->where('status',1)->get());
        //Unexcused absence
        $data['miss'] = count(attendance::where('id_contract',$data['acc']->id)->where('status',0)->where('status',0)->get());
        return view('Admin/Salary/main', $data);
    }

    //Post salary
    public function postSalary(AddSalaryRequest $request, $id)
    {
        $salary = salary::find($id);
        //check pay exits
        if ($salary == null) {
            $timeSa = Carbon::parse($request->date_now)->toDateString();
            //chekc day number in the contract
            $attent = attendance::where('id_contract',$id)->get();
            foreach($attent as $att)
            {
                $time = Carbon::parse($att->day)->toDateString();
            }
            if($this->cal2Day($time,$timeSa) < 0)
            {
                return back()->withInput()->with('error',FLMess::checkday());
            }
            $salary = new salary;
            $salary['num_attendance'] = $request->num_attendance;
            $salary['position'] = $request->position;
            $salary['reward'] = $request->reward;
            $salary['allowance'] = $request->salary_date;
            $salary['sum_position'] = $this->formatVNDtoInt($request->sum_postion);
            $salary['reviced_date'] = $this->formatDate($request->date_now);
            $salary['num_done'] = $request->num_done;
            $salary['id_attent'] = $id;
            $salary->save();
        } else {
            $salary['position'] = $request->position + $salary->position;
            $salary['reward'] = $request->reward + $salary->reward;
            $salary['sum_position'] = $this->formatVNDtoInt($request->sum_postion) + $salary->sum_position;
            $salary['reviced_date'] = $this->formatDate($request->date_now);
            $salary['num_done'] = $request->num_done + $salary->num_done;
            $salary->update();
        }
        return back()->withInput()->with('success', FLMess::paySalary());
    }

    //new monthly salary
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
            $salary['allowance'] = $request->salary_date;
            $salary['sum_position'] = $this->formatVNDtoInt($request->sum_postion);
            $salary['reviced_date'] = $this->formatDate($request->date_now);
            $salary['num_done'] = $request->num_done;
            $salary['id_attent'] = $request->id;
            $salary->save();
            return back()->withInput()->with('success',FLMess::AddSuccess());
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
