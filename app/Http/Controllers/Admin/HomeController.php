<?php
namespace App\Http\Controllers\Admin;
use App\Models\contract;
use App\Repositories\TodoInterfaceWork\AccountReponsitory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\account;
use DB;
use Carbon\Carbon;
use App\Models\permission;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Admin\ExcelController;
use Excel;
use App\Models\attendance;


class HomeController extends Controller
{
    private $account;
    public function __construct(AccountReponsitory $account)
    {
        $this->account = $account;
    }

    //Get role
    protected function getrole(){
        return account::find(Auth::user()->id)->getRole;
    }

    //Home
    public function gethome(){

        //Get role
        $data['role'] = $this->getrole();
        $data['ro'] = count(contract::where('id_account',Auth::user()->id)->whereNull('date_end')->get());
        //if employees haven't contract
        if($data['ro'] == 0)
            return redirect()->route('categoryOrder');
        // get month now
        $data['month'] = Carbon::now()->month;
        //get contract is out of date in list contracts of the employees have day end is null
        $data['get'] = DB::table('contract')->join('attendance','contract.id','attendance.id_contract')->whereNull('contract.date_end')->where('contract.id_account',Auth::user()->id)->where('attendance.status',1)->whereMonth('attendance.day',$data['month'])->get();
        //Get num workdays with contract have day end is null
        $data['num_day'] = count($data['get']);
        //get num day off
        $data['num_per'] = count(DB::table('permission')->join('contract','contract.id','permission.id_contract')->where('contract.id_account',Auth::user()->id)->where('permission.status',1)->whereNull('contract.date_end')->get());
        //the num permission remaining (Số ngày phép còn lại)
        $data['num_per_pass'] = 12 - $data['num_per'];
        //Get contract infomation
        $data['contract'] = contract::where('id_account',Auth::user()->id)->whereNull('contract.date_end')->first();
        //check Salary
        $data['sala'] = DB::table('salary')->join('contract','salary.id_attent','contract.id')->where('contract.id_account',Auth::user()->id)->where('salary.id_attent',$data['contract']->id)->whereMonth('salary.reviced_date',$data['month'])->get();
        //The number day off not permission
        $data['miss'] = count(DB::table('contract')->join('attendance','contract.id','attendance.id_contract')->whereNull('contract.date_end')->where('contract.id_account',Auth::user()->id)->where('attendance.status',0)->get());
        return view('Admin/calendar',$data);
    }
    // call export excel
    public function export(Request $request){
        return Excel::download(new ExcelController($request->month), 'LuongQLNSNV.xlsx');
    }

}
