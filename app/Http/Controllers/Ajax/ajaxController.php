<?php
namespace App\Http\Controllers\Ajax;
use App\Models\salary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\contract;
use App\Models\account;
use Carbon\Carbon;
use App\Models\attendance;
use Illuminate\Support\Facades\Auth;
use App\Models\permission;
use App\Http\Requests\postAjaxPermiss;

class ajaxController extends Controller
{
    //Lấy thời gian hiện tại
    protected function gettimenow()
    {
        return Carbon::now()->toDateString();
    }
    //Tính khoảng cách của 2 ngày
    public function cal2Day($date_start,$date_end){
       return (strtotime($date_end) - strtotime($date_start))/ (60 * 60 * 24)+1;
    }
    //Kiểm tranh danh sách phép có trong hợp đồng
    public function checkPerr($id){
        return DB::table('permission')->where('id_contract',$id)->get();
    }
    //Kiểm tra hạn sử dụng của hợp đồng
    public function checkHSDContract($id){
        //Tìm hợp đồng theo userid
        $contract = contract::find($id);
        $contract->checkContract($id);
        //Láy thời gian hiện tại
        $now = Carbon::now()->toDateString();
        //Kiểm tra thời hạn
        if($contract->date_end != null)
        $day = (strtotime($contract->date_end) - strtotime($now))/(60 * 60 * 24);
        else
        $day = 1;
        return $day;
    }
    //Lấy ngày kết thúc của hợp đồng
    public function getDayEndContract($id){
        $contract = contract::find($id);
        $contract->checkContract($id);
        return $contract->date_end;
    }
    //Lấy ngày bắt đầu hợp đồng
    public function getDaystart($id){
        $contract = contract::find($id);
        $contract->checkContract($id);
        return $contract->date_start;
    }
    //Kiểm tra ngày bắt đầu đơn xin phép có bị trùng không
    public function checkDateStart($id,$date_start,$date_end){
        //Tìm kiếm đơn xin phép theo theo id
        $permission = DB::table('permission')->where('id_contract',$id)->where('status',0)->get();
        //Lấy được ngày nhỏ nhất trong danh sách đơn xin phép
        // dd($permission);
        foreach($permission as $per)
        {
           $end = Carbon::Parse($per->date_end);
           $start = Carbon::Parse($per->date_start);
           //Ngày bắt đầu
           $day_start = Carbon::Parse($date_start)->between($start,$end);
           //Ngày kết thúc
           $day_end = Carbon::Parse($date_end)->between($start,$end);
           if($day_start==true || $day_end == true)
           return 0;
        }
        return 1;
    }
    //Lấy liên hệ
    public function getcontract($id){
        //Lấy ngày bắt đầu, kết thúc, phép tối đa trong bảng contract
        $loai = contract::find($id);

        //Số ngày công theo thông tin
        $day_attendance = $loai->getPermi;
        //Tính tổng ngày làm trong hợp đồng từ ngày bắt đầu đến kết thúc
        $day_workshould = (strtotime($loai->date_end) - strtotime($loai->date_start))/ (60 * 60 * 24);
        //Tống số ngày nghỉ
        $day_pre = count($loai->get_pre_pre);
        //Tổng số ngày công
        $sum_att = $day_attendance->num_attendance;
        //Số ngày còn lại
        $pre = $day_workshould-($sum_att + $day_pre);
        //Hiệu lực của hợp đồng;
        $active = 'Hết hiệu lực';
        if($pre>0)
        $active = 'Còn hiệu lực';
        //Chỉnh sửa lại tất cả ngày công và ngày làm việc
        // numwork là ngày làm việc trên hợp đồng
        // chưa có ngày làm việc cố định



            echo "<h4> Ngày bắt đầu: ".$loai->date_start."</h4>";
            echo "<h4> Ngày kết thúc: ".$loai->date_end."</h4>";
            echo "<h4> Hiệu lực: ".$active."</h4>";
            echo "<h4> Số ngày còn lại: ".$pre." ngày </h4>";
            echo "<h4> Số ngày phép tối đa: ".$loai->num_max." phép</h4>";


    }
    //Lấy hợp đồng
    public function gethopdong($idhopdong){
        //Lấy id của hợp đồng thông qua models contract
        $loai = contract::find($idhopdong);
        //tiingr số công làm được
        $day_attendance = $loai->getPermi;
        //Ngày nghỉ có phép
        $sum_per = Count($loai->getAtt);
        //Ngày nghỉ không phép
        $sum_mis = Count($loai->getAttend);
        //Tổng số ngày nghỉ
        $sum_permiss = count($loai->get_pre_pre);
        //Số ngày phép còn lại
        $pre_pre = $loai->num_max - $sum_permiss;

        // $day_work = $loai->getAttend;
        echo "<h4> Số ngày công: ".$day_attendance->num_attendance."</h4>";
        echo "<h4> Số ngày nghỉ: ".$sum_permiss."</h4>";
        echo "<h4> Có phép: ".$sum_mis."</h4>";
        echo "<h4> Không phép: ".$sum_mis."</h4>";
        echo "<h4> Ngày nghỉ còn lại: ".$pre_pre." phép </h4>";
    }

    //Get Addcontract Homecontroller
    public function getaddcontract($id){

        $data = account::find($id);
        echo $data->username;
    }
    //Get AddnewDate
    public function getaddDatecontract($id){
        //Tìm thông tin hợp đồng theo id
        $data = contract::find($id);
        //Lấy ngày làm việc kết thúc sớm nhất của hợp đồng
        $getcontract = $data->checkContract($id);
        //Kiểm tra số ngày kết thúc hợp đồng có còn không
        //Bằng $getcontract=1 nghĩa là ngày kết thúc null->hợp đồng chưa kết thúc
        if($getcontract != "" || $getcontract==1)
            echo 1;
        else
            echo Carbon::now()->toDateString();

    }
    //Post AddAttend
    public function CreateAddAttend($id,$day){

        $contract = contract::find($id);
        // dd($contract);
        //Lấy thời gian kết thúc
        $end = $contract->date_end;
        //Thời gian hiện tại
        $now =Carbon::now()->toDateString();
        //So sánh thời gian hiện tại và thời gian dự kiến
        $checked = $this->cal2Day($day,$now);


        //kiểm tra
        //Chuyển đổi định dạng
         $day1 = Carbon::parse($day);
        //Duyệt mảng để thêm thời gian đúng với csdl hiện tại
        //Nếu checked lớn hơn 0 nghĩa là thời gian chấm công so với hiện tại bị thiếu
        // dd($checked);
        $re = 1;
        if($checked>0 )
        {
        //    if($end == null)
            for($i=0; $i<$checked; $i++)
             {
                 if($end == null){
                    $re = $re++;
                    $ch = $checked;
                 }
                 else
                 //Chạy cho đến ngày kết thúc của hợp đồng
                 $ch =$this->cal2Day($day1,$contract->date_end);
                //  dd($day1->addDay());
                if($ch > 0)
                {
                    $atten = new attendance;
                    $atten['day'] = $day1;
                    $atten['status'] = 1;
                    $atten['permission'] = 0;
                    $atten['id_contract'] = $id;
                    $atten->save();
                }
                $day1->addDay();

            }
        }

        else
        return $re;
    }
    public function EditAddAttend($id){
        //Truy vấn thông tin của attend theo id
        $atten = attendance::find($id);
        //lấy tất cả salary
        $salary  = salary::all();
        //Chuyển đổi tháng của atten
        $monthAtt = Carbon::parse($atten->day)->month;
        //Phép và công đã được duyệt thì không được thay đổi
        if($atten['status'] == 0 && $atten['permission'] == 1 ||$atten['status'] == 0 && $atten['permission'] == 0 || $atten['status'] == 1 && $atten['permission'] ==0 )
        {
            if($atten['status'] == 0) {
                $atten['status'] = 1;
                foreach($salary as $sa)
                {
                    //Chuyển đổi tháng của salary
                    $monthRe = Carbon::parse($sa->reviced_date)->month;
                    //Check ngày công có nằm trong tháng nào của salary
                    if( $monthAtt == $monthRe )
                    {
                        DB::table('salary')->where('id_attent',$sa->id_attent)->where('id',$sa->id)->update(['num_attendance'=> $sa->num_attendance + 1]);
                    }
                }
            }
            else {
                $atten['status'] = 0;
                foreach($salary as $sa)
                {

                    //Chuyển đổi tháng của salary
                    $monthRe = Carbon::parse($sa->reviced_date)->month;
                    //Check ngày công có nằm trong tháng nào của salary
                    if( $monthAtt == $monthRe )
                    {
                            DB::table('salary')->where('id_attent',$sa->id_attent)->where('id',$sa->id)->update(['num_attendance'=> $sa->num_attendance - 1]);
                    }
                }
            }
            $atten->update();
        }
    }
    //Show Contract and attend
    public function ShowAttendContr($id){
        //lấy số lượng hợp đồng
        $contract = contract::find($id);
        $now = Carbon::now()->toDateString();
        //Lấy số ngày kết thúc của hợp đồng
         echo "   <div class='ibox float-e-margins'>
                          <div class='ibox-title'>
                          <h4>ĐƠN XIN NGHỈ PHÉP</h4>
                       </div>
                      <div class='ibox-content'>
                           <form  id='myForm' action='".asset('ajax/postPer')."' csrf_field() class='form-horizontal'>
                               <p>Hợp đồng: - " .$contract->name_contract."</p>
                                <div class='form-group'><label class='col-lg-2 control-label'>Tên nhân viên</label>
                                   <div class='col-lg-10'><input value='".Auth::user()->name."'type='text' placeholder='Tên nhân viên' class='form-control'>
                                  </div>
                             </div>
                              <div class='form-group'><label class='col-lg-2 control-label'>Nghỉ từ ngày</label>
                                 <div class='col-lg-10'><input class='form-control' value='".old('date_start')."' id='day_start' name='date_start' placeholder='YYY-MM-DD' type='text'/>
                                   </div>
                               </div>
                                <div class='form-group'><label class='col-lg-2 control-label'>Đến ngày</label>
                                   <div class='col-lg-10'><input id='day_end' placeholder='YYY-MM-DD' value='".old('date_end')."' name='date_end' type='text' class='form-control'>
                                   </div>
                                </div>
                              <div class='form-group'><label class='col-lg-2 control-label'>Lí do</label>
                                  <div class='col-lg-10'><textarea name='content' value='".old('content')."' id='editor' cols='30' rows='10' placeholder='Nhập nội dung thông tin thêm' ></textarea></div>
                               </div>
                              <div>
                                <input name='id_contract' type='hidden' value='".$contract->id."' >
                               
                              </div> 
                         <div class='form-group'>
                             <div class='col-lg-offset-9 col-lg-10'>
                                  <button class='btn btn-sm btn-success' type='submit' id='getPostPer' type ='text' >Nộp đơn</button>
                              </div>
                        </div>
                     </form>
                 </div>
             </div>

                <script>
                if(window.editor){
                        ClassicEditor
                        .create( document.querySelector( '#editor' ) )
                        .catch( error => {
                        console.error( error );
                        } );
                    } </script>
                    
    
            <script>
            $(function() {
            
            $('#day_start').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1901,
                maxYear: parseInt(moment().format('YYYY'),10)
            }, function(start, end, label) {
               
            });
            });
            $(function() {
                $('#day_end').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1901,
                maxYear: parseInt(moment().format('YYYY'),10)
                }, function(start, end, label) {
          
                });
            });

            $( '#myForm' ).submit(function( event ) {
              });
            </script>";


    }
    //Post Đơn xin phép
    public function postPer(postAjaxPermiss $request)
    {

        //Lấy ngày hiện tại
        $now = $this->gettimenow();
        //THời gian bắt đầu và thời gian kết thúc
        $day_n_s = (strtotime($request->date_start) - strtotime($now))/ (60 * 60 * 24);
        //Ngày bắt đầu hợp đồng
        $day_s = $this->getDaystart($request->id_contract);
        //Ngày kết thúc hợp đồng
        $day_e = $this->getDayEndContract($request->id_contract);
        //
        //kiểm tra ngày đi làm lại có trùng ngày kết thúc của hợp đồng không
        $dayend = (strtotime($day_e) - strtotime($request->date_end))/ (60 * 60 * 24);
        //Kiểm tra ngày bắt đầu nghỉ có nhỏ hơn ngày bắt đầu hợp đồng không
        $day_ck = (strtotime($day_s) - strtotime($request->date_start))/ (60 * 60 * 24);
        //Nếu day_e ==null nghĩa là hợp đồng còn hiệu lực chưa có ngày kết thúc
        if($day_e==null)
        {
            $day_st = 1;
            $dayend = 1;

        }
        else
        //Kiểm tra ngày bắt đầu có vượt qua ngày kết thúc không
        $day_st = (strtotime($day_e) - strtotime($request->date_start))/ (60 * 60 * 24);


        $permi = new permission;
        $permi['date_start'] = date("Y-m-d",strtotime($request->date_start));
        $permi['date_end'] = date("Y-m-d",strtotime($request->date_end));
        $permi['reason'] = $request->content;
        $permi['num_date_end'] = (strtotime($request->date_end) - strtotime($request->date_start))/ (60 * 60 * 24)+1;
        $permi['id_contract'] = $request->id_contract;
        $permi['status'] = 0;

        //Lấy tất cả ngày bắt đầu trong per để kiểm tra dữ liệu ngày bắt đầu nghỉ đã tồn tại chưa
        $permission = $this->checkDateStart($request->id_contract,$permi['date_start'],$permi['date_end']);
        // dd($permission);
        if($permission <= 0)
        return redirect()->intended('admin/getPermission')->with('error','Ngày nghỉ đã tồn tại hoặc trùng ngày bắt đầu hoặc ngày kết thúc');

        //Kiểm tra còn hạn sử dụng của hợp đồng không
        $chec = $this->checkHSDContract($request->id_contract);
        if($chec<0)
        return redirect()->intended('admin/getPermission')->with('error','Hợp đồng đã hết hạn');
        // dd($permi);
        else {
            //THời gian hiện tại so với thười gian bắt đầu
            if($day_n_s<0)
            return back()->withInput()->with('error','Thời gian bắt đầu nghỉ không được dưới thời gian hiện tại');
            //
            if($day_ck>0)
            return redirect()->intended('admin/getPermission')->with('error','Ngày bắt đầu thấp hơn mức phạm vi hợp đồng');
            //Ngày bắt đầu nghỉ
            if($day_st<0)
            return redirect()->intended('admin/getPermission')->with('error','Ngày bắt đầu đã vượt quá mức phạm vi hợp đồng');
            //Ngày kết thúc nghỉ
            else if($dayend<0)
            return redirect()->intended('admin/getPermission')->with('error','Ngày kết thúc đã vượt quá phạm vi hợp đồng');

            //Tổng số ngày nghỉ không quá 3
            else if($permi['num_date_end'] > 3)

                return redirect()->intended('admin/getPermission')->with('error','Số ngày nghỉ không được quá 3 ngày');
            else{
                $permi->save();
            return redirect()->intended('admin/getPermission')->with('success','Bạn đã nộp đơn thành công, Quản lý nhân sự sẽ kiểm tra và trả lời sớm cho bạn');
            }
        }
        // echo ;
    }
    //Lấy danh sách đơn xin phép
    public function ShowAttendPermi($id){
        //Kiểm tra hợp đồng còn hạ sử dụng không
        $acc = $this->checkHSDContract($id);
        //lấy danh sách đơn xin phép
        $permi = DB::table('permission')->where('id_contract',$id)->get();
        //Đếm số lượng đơn xin phép được chấp thuận
        $count = count(DB::table('permission')->where('id_contract',$id)->where('status','1')->get());
        $num = 1;
       echo " <div class='ibox float-e-margins'>
          <div class='ibox-content'>
            <table class='table table-hover'>
                    <thead>
                  <tr>
                        <th>#</th>
                       <th>Từ ngày</th>
                       <th>Đến ngày</th>
                       <th>Lí do</th>
                      <th>Số ngày nghỉ</th>
                       <th>Trạng thái</th>
                       <th>Hủy đơn</th>
                   </tr>
                  </thead>
                    <tbody>";
                   foreach($permi as $co) {
                  echo " <tr>
                    <td>".$num++."</td>
                   <td>$co->date_start</td>
                    <td>$co->date_end</td>
                    <td>$co->reason</td>
                   <td>$co->num_date_end</td>
                   <td>";
                  echo $co->status == 1? 'Được duyệt':'Chưa được duyệt';
                  echo "</td>";
                  echo"<td><button onclick='cancel(this)'";
                  echo $co->status == 1? 'disabled':'';
                  echo "  id='$co->id' class='btn btn-success'>Hủy</button></td>";
                   }
            echo" </table>
            <div style='text-align:right'>
                   <button onclick='showPer(this)'";
                 if($acc > 0 && $count < 20) echo "";
                    else echo "disabled";
                   echo" id='".$id."' class='btn btn-success'>Đơn xin phép</button>
            </div>
           </div>
         </div>
         <script>
                  function cancel(e){
                    $.get('".asset('ajax/cancelPerr')."'+'/'+e.id,function(data){
                        window.location.reload(false);
                    });
                }
         </script>
         ";
    }
    //hủy đơn
    public function cancelPerr($id){
        $can = permission::find($id);
        $can->Delete();
    }
    //Lấy đơn xin phép
    public function checkPermiss($id){
        $permi = permission::find($id);
        if($permi['status'] == 1)
        $permi['status'] = 0;
        else
        $permi['status']=1;
        $permi->update();
        $att = DB::table('attendance')->where('id_contract',$permi->id_contract)->get();
        //Lấy ngày bắt đầu và kết thúc của đơn xin phép
        $start = Carbon::parse($permi['date_start']);
        // dd($att);
        $end = Carbon::parse($permi['date_end']);
        //So sánh với lại ngày công có trong hợp đồng

        foreach($att as $at)
        {
            $day = Carbon::parse($at->day)->between($start,$end);
            if($day == true){
            if($permi['status'] == 0)
            DB::table('attendance')->where('id',$at->id)->update(['permission'=>'0','status'=>'0']);
            else
            DB::table('attendance')->where('id',$at->id)->update(['permission'=>'1','status'=>'1']);
            }
        }
        return $permi['status'];


    }

    //Thống kê công theo tháng
    public function getPerMonth(){

    }

    //Lấy lương theo tháng
    public function getMonthSalary($id){
        if($id == "all")
        $data = DB::table('account')->join('contract','contract.id_account','account.id')->join('salary','salary.id_attent','contract.id')->join('role','role.id','account.id_role')->get();
        else
        $data = DB::table('account')->join('contract','contract.id_account','account.id')->join('salary','salary.id_attent','contract.id')->join('role','role.id','account.id_role')->whereMonth('reviced_date',$id)->get();
        // dd($data);
        $num = 1;
        $total = 0;
        $sum = 0;

        foreach($data as $lt){
            echo"
            <tr>
            <td>".$num++."</td>
            <td>".$lt->name." </td>
            <td>".$lt->passport." </td>
            <td>".$lt->num_account." </td>
            <td>".$lt->name_role." </td>
            <td>".$lt->BHXH." </td>
            <td>".number_format($lt->num_attendance)." </td>
            <td>".number_format($lt->reward) ."</td>
            <td>".number_format($lt->allowance)."</td>
            <td>".number_format($lt->sum_position)." </td>
            <td>".number_format($lt->sum_position*5/100)."</td>
            <td>".number_format($lt->sum_position - $lt->sum_position*5/100 )." </td>
            <td>".$lt->reviced_date." </td>
            </tr> ";

        }



    }



}
