<?php
namespace App\Http\Controllers\Admin;
use App\Models\contract;
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
    //Lấy quyền truy cấp
    protected function getrole(){
        //Get quyền
        return account::find(Auth::user()->id_role)->getRole;
    }

    //Trang chủ
    public function gethome(){
        //Get quyền
        $data['role'] = $this->getrole();
        // Lấy tháng hiện tại
        $data['month'] = Carbon::now()->month;
        //Lấy hợp đồng còn hạn sử dụng trong danh sách hợp đồng của nhân viên có ngày kết thúc là null
        $data['get'] = DB::table('contract')->join('attendance','contract.id','attendance.id_contract')->whereNull('contract.date_end')->where('contract.id_account',Auth::user()->id)->where('attendance.status',1)->whereMonth('attendance.day',$data['month'])->get();
        //Lấy số ngày làm với hợp đồng có ngày kết thúc là null
        $data['num_day'] = count($data['get']);
        //Lấy số ngày nghỉ phép
        $data['num_per'] = count(DB::table('permission')->join('contract','contract.id','permission.id_contract')->where('contract.id_account',Auth::user()->id)->where('permission.status',1)->whereNull('contract.date_end')->get());
        //Số ngày phép còn lại
        $data['num_per_pass'] = 12 - $data['num_per'];
        //Lấy thông tin hợp đồng
        $data['contract'] = contract::where('id_account',Auth::user()->id)->whereNull('contract.date_end')->first();
        //Kiểm tra lương
        $data['sala'] = DB::table('salary')->join('contract','salary.id_attent','contract.id')->where('contract.id_account',Auth::user()->id)->where('salary.id_attent',$data['contract']->id)->whereMonth('salary.reviced_date',$data['month'])->get();
        //Số ngày vắng không phép
        $data['miss'] = count(DB::table('contract')->join('attendance','contract.id','attendance.id_contract')->whereNull('contract.date_end')->where('contract.id_account',Auth::user()->id)->where('attendance.status',0)->get());
        return view('Admin/calendar',$data);
    }
    public function posthome(Request $request){


    }
    //Gọi xuất excel
    public function export(Request $request){
        // dd($request->all());

        return Excel::download(new ExcelController($request->month), 'LuongQLNSNV.xlsx');

    }

}
