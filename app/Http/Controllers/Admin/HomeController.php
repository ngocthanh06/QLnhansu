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
use App\Http\Requests\AddSalaryRequest;
use App;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{

    //Chuyển đổi tiền sang số
    protected function formatVNDtoInt($num){
        return preg_replace("/([^0-9\\.])/i", "", $num);
    }
    //kiểm tra ngày nghỉ phép của hợp đồng
    protected function checkPerr($id){
        $data = DB::table('permission')->where('id_contract',$id)->get();
        return $data;
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
    //Lấy quyền truy cấp
    protected function getrole(){
        //Get quyền
        return account::find(Auth::user()->id_role)->getRole;
    }
    //Lấy thời gian
    protected function gettimenow()
    {
        return Carbon::now()->toDateString();
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
    //Danh sách nhân viên
    public function getUser(){
        //Get quyền
        $data['role'] = $this->getrole();
        $data['all_User'] =DB::table('account')->select('address','account.id','name','name_role','sex','info','username','passport')->leftjoin('role','role.id','account.id_role')->where('id_role','1')->orWhere('id_role','2')->paginate(5);
        return view('Admin/Nhanvien/main',$data);
    }
    //Get add nhân viên
    public function getAddUser(){
        //Get quyền
        $data['role'] = $this->getrole();
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
         $data['role'] = $this->getrole();
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
        $data['role'] = $this->getrole();
        $data['type_contract'] = Type_contract::all();
        return view('Admin/TypeContract/Main',$data);
    }

    //Hợp đồng
    //Lấy danh sách hợp đồng
    public function getContract(){
        //Get quyền
        $data['role'] = $this->getrole();
        //Lấy thông tin danh sách hợp đồng có loại hợp đồng và thông tin nhân viên
        $data['contract'] = DB::table('contract')->select('contract.id','name_contract','date_start','date_end','num_work','name','username','name_type')->join('account','account.id','contract.id_account')->join('type_contract','contract.id_type_contract','type_contract.id')->where('account.id_role',2)->orderBy('contract.id')->paginate(5);
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
        //Lấy ngày làm việc kết thúc sớm nhất của hợp đồng
        $getcontract = $data->checkContract($request->id_account);
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
    //Tính số ngày 
    //Tính khoảng cách của 2 ngày
    public function cal2Day($date_start,$date_end){
                 $data = (strtotime($date_end) - strtotime($date_start))/ (60 * 60 * 24);
                 return $data;   
    } 
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

    //Lấy đơn xin nghỉ phép
    public function getPermission(){
         //Get quyền ->id của role
         $data['role'] = $this->getrole();
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
