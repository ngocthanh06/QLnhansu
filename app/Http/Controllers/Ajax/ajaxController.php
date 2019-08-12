<?php

namespace App\Http\Controllers\Ajax;

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
    //Kiểm tra hạn sử dụng của hợp đồng
    public function checkHSDContract($id){
        //Tìm hợp đồng theo userid
        $contract = contract::find($id);
        $contract->checkContract($id);
        //Láy thời gian hiện tại
        $now = Carbon::now()->toDateString();
        //Kiểm tra thời hạn 
        $day = (strtotime($contract->date_end) - strtotime($now))/(60 * 60 * 24);
        return $day;
    }
    //Lấy ngày kết thúc của hợp đồng
    public function getDayEndContract($id){
        $contract = contract::find($id);
        $contract->checkContract($id);
        return $contract->date_end;
    }
    //
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
        if($getcontract == ""){
            $getcontract = Carbon::now();
        }
        //Format ngày đầu
        $get = Carbon::parse($getcontract)->format('Y-m-d');
        
        //Cộng thêm cho 2 ngày
        $set2 = Carbon::parse($get)->addDays(2);
        //Format ngày 2
        $set = $set2->format('Y-m-d');
        echo $get. " - ". $set;
    }
    //Post AddAttend
    public function CreateAddAttend($id){
        $atten = new attendance;
        $check = DB::table('attendance')->where('id_contract',$id)->get();
        $now =Carbon::now()->toDateString();
        // dd($now);
        // dd($check);
        
        $num = 0;
        foreach($check as $ch)
        {
            //kiểm tra ngày làm có bị trùng với ngày làm hiện tại không
            if($ch->day == $now)
            {
                $num = ++$num;
                break;
            }
        }
        if($num==0)
        {   
            $atten['day'] = $now; 
            $atten['status'] = 1;
            $atten['permission'] = 0;
            $atten['id_contract'] = $id;
            $atten->save();
            return $num;
        }
        else
         return $num;
        //  dd($num);
        // $atten->save();
        // return redirect()->intended('admin/getAttendance/'.$id)->with('success','Chấm công thành công');
        // echo "<td>".$atten['day']."</td>";
       
    }
    public function EditAddAttend($id){
        $atten = attendance::find($id);
        if($atten['status'] == 0)
        $atten['status'] = 1;
        else 
        $atten['status'] = 0;
        $atten->update();
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

        $contract = contract::find($request->id_contract);
        //Ngày kết thúc hợp đồng
        $day_e = $this->getDayEndContract($request->id_contract);
        //Kiểm tra ngày bắt đầu có vượt qua ngày kết thúc không
        $day_st = (strtotime($day_e) - strtotime($request->date_start))/ (60 * 60 * 24);
        //kiểm tra ngày đi làm lại có trùng ngày kết thúc của hợp đồng không
        $dayend = (strtotime($day_e) - strtotime($request->date_end))/ (60 * 60 * 24);

        // dd($dayend);


        $permi = new permission;
        $permi['date_start'] = date("Y-m-d",strtotime($request->date_start));
        $permi['date_end'] = date("Y-m-d",strtotime($request->date_end));
        $permi['reason'] = $request->content;
        $permi['num_date_end'] = (strtotime($request->date_end) - strtotime($request->date_start))/ (60 * 60 * 24)+1;
        $permi['id_contract'] = $request->id_contract;
        $permi['status'] = 0;
      
        //Kiểm tra còn hạn sử dụng của hợp đồng không
        $chec = $this->checkHSDContract($request->id_contract);
        if($chec<0)
        return redirect()->intended('admin/getPermission')->with('error','Hợp đồng đã hết hạn');
        // dd($permi);
        else {
            //Ngày bắt đầu
            if($day_st<0)
            return redirect()->intended('admin/getPermission')->with('error','Ngày bắt đầu đã vượt quá mức phạm vi hợp đồng');
            //Ngày kết thúc
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
                   }
            echo" </table>
            <div style='text-align:right'>
                   <button onclick='showPer(this)'";
                   echo  $acc > 0 ? '':'disabled';   
                   echo" id='".$id."' class='btn btn-success'>Đơn xin phép</button>
            </div>
           </div>
         </div>
         ";
        
    }
}
