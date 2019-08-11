<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\contract;
use App\Models\account;
use Carbon\Carbon;
use App\Models\attendance;

class ajaxController extends Controller
{
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
        $atten['day'] = Carbon::now()->toDateString();
        $atten['status'] = 1;
        $atten['permission'] = 0;
        $atten['id_contract'] = $id;
        $atten->save();
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
        $attendance = DB::table('attendance')->where('id_contract',$id)->get();
        $num = 1;

       echo "<div class='col-lg-5'>";
       echo " <div class='ibox float-e-margins'>";
       echo "    <div class='ibox-content'>";
       echo "        <table class='table table-hover'>";
       echo "             <thead>";
       echo "            <tr>";
       echo "                 <th>#</th>";
       echo "                 <th>Ngày</th>";
       echo "                 <th>Công</th>";
       echo "                 <th>Vắng</th>";
       echo "                 <th>Đơn xin phép</th>";
       echo "             </tr>";
       echo "             </thead>";
       echo "             <tbody>";
       echo "             @foreach($attendance as $cont1)";
       echo "             <tr>";
       echo "             <td>{{}}</td>";
       echo "             <td>{{$cont->day}}</td>";
       echo "             <td>{{$cont->status}}</td>";
       echo "             <td>{{$cont->permission}}</td>";
       echo "             <td><button id='{{$cont->id}}' class='btn btn-success btn-sm'>Chi tiết</button></td>";
       echo "             </tr>";
       echo "                 @endforeach";
       echo "             </tbody>";
       echo "         </table>";
       echo "     </div>";
       echo "  </div>";
       echo "</div>";
    }
}
