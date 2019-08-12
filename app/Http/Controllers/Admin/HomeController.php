<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\account;
use App\Models\days;
use App\Models\salary;
use App\Models\timesheets;
use App\Models\contract;
use App\Models\Type_contract;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\AddContract;
use App;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;



class HomeController extends Controller
{

    //Lấy thời gian
    public function gettimenow()
    {
        return Carbon::now()->toDateString();
    }

    public function gethome(){
        //Get quyền
        $data['role'] = account::find(Auth::user()->id_role)->getRole;
        // Lấy tháng hiện tại
        $data['month'] = Carbon::now()->month;
        //Lấy loại hợp đồng
        $data['contract'] = DB::table('contract')->where('contract.id_account',Auth::user()->id)->whereMonth('contract.date_start',$data['month'])->get();
        
        return view('Admin/calendar',$data);
    }
    public function posthome(Request $request){

        
    }
    //Danh sách nhân viên
    public function getUser(){
        //Get quyền
        $data['role'] = account::find(Auth::user()->id_role)->getRole;
        $data['all_User'] =DB::table('account')->select('address','account.id','name','name_role','sex','info','username','passport')->leftjoin('role','role.id','account.id_role')->where('id_role','1')->orWhere('id_role','2')->paginate(5);
        return view('Admin/Nhanvien/main',$data);
    }
    //Get add nhân viên
    public function getAddUser(){
        //Get quyền
        $data['role'] = account::find(Auth::user()->id_role)->getRole;
        return view('Admin/Nhanvien/Add',$data);
    }
    //Post Nhân viên
    public function postAddUser(AddUserRequest $request){
        $user = new account;
        $user['name'] = $request->name;
        $user['address'] = $request->address;
        $user['username'] = $request->username;
        $user['password'] = bcrypt($request->password);
        $user['passport'] = $request->passport;
        $user['id_role'] = $request->id_role;
        $user['info'] = $request->info;
        $user['sex'] = $request->sex;
        $user->save();
        return redirect()->intended('admin/user')->with('success','Thêm nhân viên thành công');
    }
    //Get edit nhân viên
    public function getEditUser($id){
         //Get quyền
         $data['role'] = account::find(Auth::user()->id_role)->getRole;
         $data['user'] = account::find($id);
         return view('Admin/Nhanvien/Edit',$data);

    }
    //Post edit nhân viên
    public function postEditUser(EditUserRequest $request,$id){
        $user = account::find($id);
        $user['name'] = $request->name;
        $user['address'] = $request->address;
        $user['username'] = $request->username;
        if(!Hash::check($user['password'],Hash::make($request->password)))
        $user['password'] =  hash::make($request->password);
        $user['passport'] = $request->passport;
        $user['id_role'] = $request->id_role;
        $user['info'] = $request->info;
        $user['sex'] = $request->sex;
        if(!empty($user->getDirty())){
           $user->update();
           return redirect()->intended('admin/user')->with('success','Sửa thông tin thành công');
        }
        else
        return redirect()->intended('admin/user')->with('error','Thông tin không thay đổi');
           
    }
    //Delete Nhân viên
    public function getDeleteUser($id){
        $user = account::find($id);
        $user->Delete();
        return back()->withInput()->with('success','Đã xóa thành công');
    }

    //Loại hợp đồng
    //Get list loại Hợp đồng
    public function getTypeContract(){
        //Get quyền
        $data['role'] = account::find(Auth::user()->id_role)->getRole;
        $data['type_contract'] = Type_contract::all();
        return view('Admin/TypeContract/Main',$data);
    }

    //Hợp đồng
    //Lấy danh sách hợp đồng
    public function getContract(){
        //Get quyền
        $data['role'] = account::find(Auth::user()->id_role)->getRole;
        //Lấy thông tin danh sách hợp đồng có loại hợp đồng và thông tin nhân viên
        $data['contract'] = DB::table('contract')->select('contract.id','name_contract','date_start','date_end','num_work','name','username','name_type')->join('account','account.id','contract.id_account')->join('type_contract','contract.id_type_contract','type_contract.id')->where('account.id_role',2)->orderBy('contract.id')->paginate(5);
        $data['now'] = Carbon::now()->toDateString();
        return view('Admin/Contract/main',$data);
    }
    //Thêm hợp đồng
    public function getAddContract(){
        //Get quyền
        $data['role'] = account::find(Auth::user()->id_role)->getRole;
        //Lấy loại hợp đồng
        $data['type_contract'] = Type_contract::all();
        $data['user'] = account::all()->where('id_role',2);
        return view('Admin/Contract/Add',$data);
    }
    //Post Thêm hợp đồng
    public function postAddContract(AddContract $request){
        $contract = new contract;
        $contract['id_type_contract'] = $request->id_type_contract;
        $contract['id_account']= $request->id_account;
        $contract['name_contract']= $request->name_contract;  
        $contract['date_start']=$request->date_start;
        $contract['date_end']= $request->date_end;
        $contract['num_max']= $request->num_max;
        $contract['coefficients']= $request->coefficients;
        $contract['content']= $request->content;
        $contract['num_work']= (strtotime($request->date_end) - strtotime($request->date_start))/ (60 * 60 * 24)+1;
        $contract->save();
        return redirect()->intended('admin/contract')->with('success','Thêm hợp đồng thành công');
    }
    //Get Edit contract
    public function getEditContract($id){
        //Get quyền
        $data['role'] = account::find(Auth::user()->id_role)->getRole;
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
        //Format lại ngày 
        // $day_start = Carbon::parse($request->date_start)->format('Y/m/d');
        // $day_end = Carbon::parse($request->date_end)->format('Y/m/d');  
        // dd(strtotime($request->date_end));
        $contract['date_start']=$request->date_start;
        $contract['date_end']= $request->date_end;
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

    //Chấm công
    //Get chấm công
    //Còn chỉnh sửa đoạn nghỉ phép và lương
    public function getAttendance($id){
         //Get quyền
         $data['role'] = account::find(Auth::user()->id_role)->getRole;
         $info = contract::find($id);
         //Thông tin attendance có bao nhiêu
         $data['contract'] = $info->checkAttend;
         //Số ngày đã làm
         $data['work'] = count($info->getWorked);
         //Thông tin tài khoản
         $data['acc'] = $info->getAccount($id);
         //Số thứ tự
         $data['num'] = 1;
         //Lấy ngày bắt đầu, kết thúc
         $data['end'] = $data['acc']->date_end;
         $data['start1'] = $data['acc']->date_start;
         //Lấy số lượng công làm trong attendance
         $count = count($info->checkAttend);
         $data['count']= (strtotime($data['end']) - strtotime($data['start1']))/ (60 * 60 * 24) - $count;
         //lấy ngày hiện tại
         $data['now'] = (Carbon::now())->toDateString();
         dd($data);
         return view('Admin/Attendance/main',$data);
    }

    //Lấy đơn xin nghỉ phép
    public function getPermission(){
         //Get quyền ->id của role
         $data['role'] = account::find(Auth::user()->id_role)->getRole;
         //Lấy id của tài khoản nhân viên để truy vấn dữ liệu của hợp đồng hiện có-> (contract) join thên loại hợ đồng
         $contract = contract::find(Auth::user()->id);
         $data['contract_user'] = $contract->getContr($contract->id);
         //rồi truy ván dữ liệu lấy thông tin hợp đồng có được-> (attendance)
         //Sau đó truy vấn lấy chi tiết hợp đồng->(attendane)->1 ngày tương ứng với 1 phép nếu có.
         $data['num'] = 1;
         //Lấy id xong 
         //Lấy thời gian hiện tại
         $data['now'] = $this->gettimenow();
        // dd($data);
         return view('Admin/Permission/main',$data);
    }

   
}
