<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\account;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Admin\ExcelController;
use Excel;


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
        //Lấy loại hợp đồng
        $data['contract'] = DB::table('contract')->where('contract.id_account',Auth::user()->id)->whereMonth('contract.date_start',$data['month'])->get();
        
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
