<?php

namespace App\Http\Controllers\Admin;

use App\Models\attendance;
use App\Models\permission;
use App\Repositories\TodoInterfaceWork\AttendanceReponsitories1;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App;
use DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Exportable;
use mysql_xdevapi\Session;
use FLMess;
use App\Repositories\TodoInterfaceWork\ContractReponsitory;
use App\Repositories\TodoInterfaceWork\AccountReponsitory;
use App\Repositories\TodoInterfaceWork\AttendanceReponsitory;
use App\Repositories\TodoInterfaceWork\SupportInterface;
use App\Repositories\TodoInterfaceWork\JoinModelReponsitory;
use App\Repositories\TodoInterfaceWork\PermissionReponsitory;
class AttendanceManager extends Controller
{
    private $account, $contract, $attendance, $support, $joinModel, $permission;

    public function __construct(AccountReponsitory $account, ContractReponsitory $contract,
                                AttendanceReponsitory $attendance, SupportInterface $support,
                                JoinModelReponsitory $joinModel,PermissionReponsitory $permission )
    {
        $this->account = $account;
        $this->contract = $contract;
        $this->attendance = $attendance;
        $this->support = $support;
        $this->joinModel = $joinModel;
        $this->permission = $permission;
    }

    //check day off of the contract
    protected function checkPerr($id)
    {
        $data = DB::table('permission')->where('id_contract', $id)->get();
        return $data;
    }
    //Number workdays folow the contract id
    protected function getAtt($id)
    {
        return DB::table('attendance')->where('id_contract', $id)->where('status', '1')->where('permission', '0')->orWhere('status', '1')->where('permission', '1')->where('id_contract', $id)->get();
    }

    //Workdays attendance in month
    protected function getMonthWork($id)
    {
        return DB::table('attendance')->where('id_contract', $id)->where('status', '1')->where('permission', '0')->whereMonth('day',Carbon::parse(Carbon::now())->month)->orWhere('status', '1')->where('permission', '1')->where('id_contract', $id)->whereMonth('day',Carbon::parse(Carbon::now())->month)->get();
    }
    //
    //Attendance
    //Get Attendance
    public function getAttendance($id)
    {
        //Get role
        $data['role']     = $this->account->getRole();
        $info             = $this->contract->getByid($id);
        //check number attendance infomation of contract
        $data['contract'] = $this->contract->checkAtten($id);
        //Number workdays in month
        $data['work']     = count($this->getMonthWork($id));
        //Update workdays infomation in salary
        //Account infomation
        $data['acc']      = $info->getAccount($id);
        //number
        $data['num']        = 1;
        //Get day start, end
        $data['end']        = $data['acc']->date_end;
        $data['start1']     = $data['acc']->date_start;
        //Get number workdays in attendance
        $count              = count($info->checkAttend);
        //if count days < 0 then user can't add workday in attendance
        $data['count']      = (strtotime($data['end']) - strtotime($data['start1'])) / (60 * 60 * 24) - $count;
        //Get time now
        $data['now']        = Carbon::now()->toDateString();
        //Get day off of the contract
        $data['check']      = $this->permission->getPerWithIdContract();
        //number day off
        $data['countCheck'] = count($this->checkPerr($id));
        //get list the permission
        $data['permi']      = count(DB::table('permission')->where('id_contract', $id)->get());
        //count the number permission is accepted
        $data['countPer']   = count(DB::table('permission')->where('id_contract', $id)->where('status', '1')->get());
        //get numb permisson
        $data['per']        = count(permission::where('id_contract', $data['acc']->id)->where('status', 1)->get());
        //Unexcused absence(Vắng không phép)
        $data['miss']       = count(attendance::where('id_contract', $data['acc']->id)->where('status', 0)->where('status', 0)->get());
        return view('Admin/Attendance/main', $data);
    }

    //Salary table
    public function GetAtendance()
    {
        //Get all month of Attendance
        $attentPay = $this->attendance->allMonthAttendance();
        //Get role
        $role = $this->account->getRole();
        //get list of the employees when join contract and salary
        $list = DB::table('account')->join('contract', 'contract.id_account', 'account.id')->join('salary', 'salary.id_attent', 'contract.id')->join('role', 'role.id', 'account.id_role')->groupBy(DB::raw("Month(reviced_date)"))->groupBy(DB::raw("Year(reviced_date)"))->get();
        $num  = 1;
        $getValAcceptSal = DB::table('account')->join('accept_salary','account.id','accept_salary.id_AccountAcceptSalary')->get();
        return view('Admin/Attendance/GetAttendance', compact('role', 'list', 'num','getValAcceptSal'));
    }

    //Get Time Attendance
    public function GetTimeAttend(Request $request, $id)
    {
        $attent             = $this->attendance->getById($id);
        $attent['checkin']  = Carbon::parse($request->checkin)->ToTimeString();
        $attent['checkout'] = Carbon::parse($request->checkout)->ToTimeString();
        $attent->save();
        return back()->withInput()->with('success', FLMess::successA());
    }

    //Attendance
    public function Attendance(){
        //Get role
        $data['role']     = $this->account->getRole();
        //get time now
        $data['timeNow'] = $this->support->getTimeNow();
        //Get list permission with id_role = 2 and date_end = null and with attendance isset
        $data['permission']= $this->account->getListAccWithContractIDrole(2);
        //Get list permission with id_role = 2 and date_end = null
        $data['permissTwo'] = $this->account->listAttendanceWithIdContractTwo(2, $data['permission']);
        //get list attendance
        $data['listAccPerr'] = '';
        if(count($data['permission'])==0){
            $data['listAccPerr'] = $this->account->listAttendanceWithHaveNot(2);
        }
//        dd($data['permission']);
        return view('Admin.Attendance.Attendance', $data);
    }

}
