<?php
$open ='Attendance';
$num = 1;
?>
@extends('Admin.layout') @section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="row">
                <div class="col-lg-3">
                    <h5 style="margin-top:10px">Danh sách chấm công nhân viên </h5>
                    <h5>
                    </h5>
                </div>
                <div class="col-lg-2">
                    <input type="text"  class="form-control" name="birthday" value="">
                </div>
            </div>
        </div>
        <div class="ibox-content">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Tên nhân viên</th>
                    <th>Hợp đồng</th>
                    <th>Ngày làm</th>
                    <th>Giờ vào</th>
                    <th>Giờ ra</th>
                    <th>Phép</th>
                    <th>Trạng thái</th>
                    <th>Chấm công</th>
                    <th>Vào/ra</th>
                </tr>
                </thead>
                <tbody id="listAttendanceWithList">
                {{--                permiss with account all when haven't atten--}}
                @if(count($permission) == 0  && count($permissTwo) == 0)
                    @foreach($listAccPerr as $per)
                        <tr>
                            <td>{{$num}}</td>
                            <td>{{$per->name}}</td>
                            <td>{{$per->name_contract}}</td>
                            <td>{{$timeNow}}</td>
                            <td></td>
                            <td></td>
                            <td>
                                @php
                                    //Check time in date start and date end
                                    $per1 = DB::table('permission')->where('id_contract',$per->id)->get();
                                    $data = ''; $number1 = 1;
                                    foreach($per1 as $pe){
                                    //get the distance 2 day in permission
                                    $data = (strtotime($pe->date_end) - strtotime($timeNow))/ (60 * 60 * 24); if($data >= 0){
                                    //check status is active
                                    if($pe->status == 0) {
                                    echo "<a class='btn btn-warning' data-toggle='modal' data-target='#myModal$pe->id'>Chưa duyệt</a>
                                    <!-- Modal -->
                                    <div id='myModal$pe->id' class='modal fade' role='dialog'>
                                       <div class='modal-dialog'>
                                          <!-- Modal content-->
                                          <div class='modal-content'>
                                             <div class='modal-header'>
                                                <button type='button' onclick='window.location.reload(false)' class='close' data-dismiss='modal'>&times;</button>
                                                <h4 class='modal-title'>Danh sách đơn xin nghỉ phép </h4>
                                                Số lượng: <span class='label label-warning-light'>1</span> - Đã duyệt: <span class='label label-warning-light'>2</span>
                                             </div>
                                             <div class='modal-body'>
                                                <table class='table table-hover'>
                                                   <thead>
                                                      <tr>
                                                         <th>#</th>
                                                         <th>Tên nhân viên</th>
                                                         <th>Nghỉ từ ngày</th>
                                                         <th>Số ngày</th>
                                                         <th>Đến ngày</th>
                                                         <th>lí do</th>
                                                         <th>Trạng thái</th>
                                                      </tr>
                                                   </thead>
                                                   <tbody>
                                                      <tr>
                                                         <td>$number1</td>
                                                         <td>$per->name</td>
                                                         <td>$pe->date_start</td>
                                                         <td>$pe->num_date_end</td>
                                                         <td>$pe->date_end</td>
                                                         <td>$pe->reason</td>
                                                         <td>
                                                            <button onclick='checkPermiss1(this)' value='$pe->id' id='accept1$pe->id' class='btn btn-sm btn-danger'>Chưa xác nhận</button>
                                                         </td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </div>
                                             <div class='modal-footer'>
                                                <button type='button' onclick='window.location.reload(false)' class='btn btn-default' data-dismiss='modal'>Close</button>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    ";
                                    }
                                    else
                                    echo "Có phép";
                                    }
                                    $number1++;
                                    }
                                @endphp
                            </td>
                            <td>
                            </td>
                            <td>
                                <div class="checkbox checkbox-success" style="margin-top: 0px;">
                                    <input name="checkboxPer" type="checkbox" class="form-check-input" id="{{\Carbon\Carbon::parse($timeNow)->format('Y-m-d')}}">
                                    <label for="checkbox3"> </label>
                                </div>
                            </td>
                        </tr>
                        <?php $num++ ?>
                    @endforeach
                @endif
                {{-- Permission isset attendance--}}
                @foreach($permission as $per)
                    <tr>
                        <td>{{$num}}</td>
                        <td>{{$per->name}}</td>
                        <td>{{$per->name_contract}}</td>
                        <td>{{$timeNow}}</td>
                        <td>{{$per->checkin}}</td>
                        <td>{{$per->checkout}}</td>
                        <td>
                            @php
                                //Check time in date start and date end
                                $per1 = DB::table('permission')->where('id_contract',$per->id_contract)->get();
                                $data = ''; $number1 = 1; foreach($per1 as $pe){
                                //get the distance 2 day in permission
                                $data = (strtotime($pe->date_end) - strtotime($timeNow))/ (60 * 60 * 24); if($data >= 0){
                                //check status is active
                                if($pe->status == 0) {
                                echo "<a class='btn btn-warning' data-toggle='modal' data-target='#myModal$pe->id'>Chưa duyệt</a>
                                <!-- Modal -->
                                <div id='myModal$pe->id' class='modal fade' role='dialog'>
                                   <div class='modal-dialog'>
                                      <!-- Modal content-->
                                      <div class='modal-content'>
                                         <div class='modal-header'>
                                            <button type='button' onclick='window.location.reload(false)' class='close' data-dismiss='modal'>&times;</button>
                                            <h4 class='modal-title'>Danh sách đơn xin nghỉ phép </h4>
                                            Số lượng: <span class='label label-warning-light'>1</span> - Đã duyệt: <span class='label label-warning-light'>2</span>
                                         </div>
                                         <div class='modal-body'>
                                            <table class='table table-hover'>
                                               <thead>
                                                  <tr>
                                                     <th>#</th>
                                                     <th>Tên nhân viên</th>
                                                     <th>Nghỉ từ ngày</th>
                                                     <th>Số ngày</th>
                                                     <th>Đến ngày</th>
                                                     <th>lí do</th>
                                                     <th>Trạng thái</th>
                                                  </tr>
                                               </thead>
                                               <tbody>
                                                  <tr>
                                                     <td>$number1</td>
                                                     <td>$per->name</td>
                                                     <td>$pe->date_start</td>
                                                     <td>$pe->num_date_end</td>
                                                     <td>$pe->date_end</td>
                                                     <td>$pe->reason</td>
                                                     <td>
                                                        <button onclick='checkPermissIsset(this)' value='$pe->id' id='accept1$pe->id' class='btn btn-sm btn-danger'>Chưa xác nhận</button>
                                                     </td>
                                                  </tr>
                                               </tbody>
                                            </table>
                                         </div>
                                         <div class='modal-footer'>
                                            <button type='button' onclick='window.location.reload(false)' class='btn btn-default' data-dismiss='modal'>Close</button>
                                         </div>
                                      </div>
                                   </div>
                                </div>
                                ";
                                }
                                else
                            @endphp
                            <i class="fa fa-check"></i>
                            @php
                                }
                                $number1++;
                                }
                            @endphp
                        </td>
                        <td>
                            <?php
                            if($per->status == 1 && $per->permission == 0)
                                echo 'Đi làm';
                            else if($per->status == 1 && $per->permission == 1)
                                echo 'Nghỉ làm có phép';
                            else echo 'nghỉ làm không phép';
                            ?>
                        </td>
                        <td>
                            <div class="checkbox checkbox-success" style="margin-top: 0px;">
                                <input name="checkboxPer" type="checkbox" id="{{$per->id}}" class="form-check-input" onclick="checkonclick(this)" value="{{\Carbon\Carbon::parse($timeNow)->format('Y-m-d')}}"
                                    @php if($per->status == 1 && $per->permission == 0 || $per->status == 1 && $per->permission == 1)
                     echo 'checked';
                                    @endphp >
                                <label for="checkbox3"> </label>
                            </div>
                        </td>
                        <td>
                            <div class="ibox float-e-margins" style="margin-bottom:0">
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal{{$per->id}}">Sửa</button>
                                <div id="myModal{{$per->id}}" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Sửa thời gian</h4>
                                            </div>
                                            <form method="post" action="{{asset('admin/getAttendance').'/'.$per->id}}">
                                                {{csrf_field()}}
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="Checkin">Giờ vào:</label>
                                                        <div class="bootstrap-timepicker">
                                                            <input  class="form-control" id="timepicker{{$per->id}}" name="checkin"  type="text" >
                                                            <i class="icon-time"></i>
                                                        </div>
                                                        <script type="text/javascript">
                                                            $('#timepicker{{$per->id}}').timepicker({
                                                                template: false,
                                                                showInputs: false,
                                                                minuteStep: 5
                                                            });
                                                        </script>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email">Giờ ra:</label>
                                                        <div class="bootstrap-timepicker ">
                                                            <input class="form-control" id="timepic{{$per->id}}" value="17:30" name ="checkout" type="text" >
                                                            <i class="icon-time"></i>
                                                        </div>
                                                        <script type="text/javascript">
                                                            $('#timepic{{$per->id}}').timepicker({
                                                                template: false,
                                                                showInputs: false,
                                                                minuteStep: 5
                                                            });
                                                        </script>
                                                    </div>
                                                    <input type="hidden" value="{{$per->id}}" name = 'id'>
                                                    <div class="form-group pull-right" >
                                                        <input value="Sửa" type="submit" class="btn btn-success">
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="modal-footer"style="margin-top:15px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php $num++ ?>
                @endforeach
                {{--Permission doesn't attendance--}}
                @foreach($permissTwo as $per)
                    <tr>
                        <td>{{$num}}</td>
                        <td>{{$per->name}}</td>
                        <td>{{$per->name_contract}}</td>
                        <td>{{$timeNow}}</td>
                        <td></td>
                        <td></td>
                        <td>
                            @php
                                //Check time in date start and date end
                                $per1 = DB::table('permission')->where('id_contract',$per->id)->get();
                                $data = ''; $number1 = 1; foreach($per1 as $pe){
                                //get the distance 2 day in permission
                                $data = (strtotime($pe->date_end) - strtotime($timeNow))/ (60 * 60 * 24); if($data >= 0){
                                //check status is active
                                if($pe->status == 0) {
                                echo "<a class='btn btn-warning' data-toggle='modal' data-target='#myModal$pe->id'>Chưa duyệt</a>
                                <!-- Modal -->
                                <div id='myModal$pe->id' class='modal fade' role='dialog'>
                                   <div class='modal-dialog'>
                                      <!-- Modal content-->
                                      <div class='modal-content'>
                                         <div class='modal-header'>
                                            <button type='button' onclick='window.location.reload(false)' class='close' data-dismiss='modal'>&times;</button>
                                            <h4 class='modal-title'>Danh sách đơn xin nghỉ phép </h4>
                                            Số lượng: <span class='label label-warning-light'>1</span> - Đã duyệt: <span class='label label-warning-light'>2</span>
                                         </div>
                                         <div class='modal-body'>
                                            <table class='table table-hover'>
                                               <thead>
                                                  <tr>
                                                     <th>#</th>
                                                     <th>Tên nhân viên</th>
                                                     <th>Nghỉ từ ngày</th>
                                                     <th>Số ngày</th>
                                                     <th>Đến ngày</th>
                                                     <th>lí do</th>
                                                     <th>Trạng thái</th>
                                                  </tr>
                                               </thead>
                                               <tbody>
                                                  <tr>
                                                     <td>$number1</td>
                                                     <td>$per->name</td>
                                                     <td>$pe->date_start</td>
                                                     <td>$pe->num_date_end</td>
                                                     <td>$pe->date_end</td>
                                                     <td>$pe->reason</td>
                                                     <td>
                                                        <button onclick='checkPermiss1(this)' value='$pe->id' id='accept1$pe->id' class='btn btn-sm btn-danger'>Chưa xác nhận</button>
                                                     </td>
                                                  </tr>
                                               </tbody>
                                            </table>
                                         </div>
                                         <div class='modal-footer'>
                                            <button type='button' onclick='window.location.reload(false)' class='btn btn-default' data-dismiss='modal'>Close</button>
                                         </div>
                                      </div>
                                   </div>
                                </div>
                                ";
                                }
                                else
                                echo "Có phép";
                                }
                                $number1++;
                                }
                            @endphp
                        </td>
                        <td></td>
                        <td>
                            <div class="checkbox checkbox-success" style="margin-top: 0px;">
                                <input value="{{$per->id}}" name="checkboxPer" type="checkbox" onclick="checkAddAttendance(this)" class="form-check-input" id="{{\Carbon\Carbon::parse($timeNow)->format('Y-m-d')}}">
                                <label for="checkbox3"> </label>
                            </div>
                        </td>
                    </tr>
                    <?php $num++ ?>
                @endforeach
                </tbody>
            </table>
            <div style="text-align:center">
            </div>
        </div>
    </div>
@stop
