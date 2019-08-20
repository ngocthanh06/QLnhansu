
<?php $open = 'contract'; ?>
@extends('Admin.layout')
@section('content')
<div class="col-lg-12">
        <div class="ibox float-e-margins">
           <div class="ibox-title">
            <h5><a href="{{asset('admin/contract')}}"> <i> <small> Danh sách hợp đồng </small> </i> </a></h5> <h5>&nbsp;/&nbsp;</h5> {!! $open == 'contract' ? '<h5>Lương nhân viên '. $acc->name.'</h5> <h5>&nbsp; /&nbsp; </h5> <h5><a href="'.asset("admin/getAttendance/".$acc->id).'"><i><small>Công</small></i></a></h5> <h5>&nbsp; / &nbsp;</h5> <h5><a href="'.asset("admin/EditContract/".$acc->id).'"><i><small>Sửa hợp đồng</small></i></a></h5><h5>&nbsp; / &nbsp;</h5> <h5><a href="'.asset("admin/DeleteContract/".$acc->id).'"><i><small>Hủy hợp đồng</small></i></a></h5>':''!!}   
           </div>
           <div class="ibox-content">
              <div class="row">
                
                 <div class="col-lg-3">
                    <div class="contact-box center-version">
                       <a href="profile.html">
                          <img alt="image" class="img-circle" src="img/a2.jpg">
                          <h3 class="m-b-xs"><strong>{{$acc->name}}</strong></h3>
                          <div class="font-bold">{{$acc->name_role}}</div>
                          <address class="m-t-md">
                             <strong>{{$acc->name_type}}</strong><br>
                             Địa chỉ: <strong>{{$acc->address}}</strong><br>
                             Ngày bắt đầu: <strong>{{$acc->date_start}}</strong><br>
                             Ngày kết thúc: <strong>
                             <?php
                                if(!isset($acc->date_end))
                                echo "Không xác định";
                                else echo $acc->date_end
                                ?>    
                             </strong><br>
                             Số ngày làm việc trên hợp đồng:<strong> 
                                 <?php
                                 if($acc->date_end == null)
                                 echo 'Không xác định';
                                 else 
                                 echo $acc->num_work; 
                                    ?></strong><br>
                             Hệ số lương:<strong> {{$acc->coefficients}}</strong><br> 
                             Số ngày nghỉ phép tối đa:<strong> {{$acc->num_max}}</strong><br>
                             Số ngày đã làm: <strong>{{$att}}</strong><br>
                          </address>
                          <div >
                                <a class="btn btn-success" href="{{asset('admin/getAttendance')."/".$acc->id}}" style="margin-left:50px" >Xem chi tiết công</a>  
                          </div>
                    </div>  
                 </div>
                 
                 <div class="col-lg-9">
                        <div class="ibox-content">
                           @if(count($salary)!=0)
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Số công</th>
                                        <th>Công thanh toán</th>
                                        <th>Còn lại</th>
                                        <th>Lương còn</th>
                                        <th>Đã thanh toán</th>
                                        <th>Thưởng</th>
                                        <th>Phụ cấp</th>
                                        <th>Thực lãnh</th>
                                        <th>Ngày lãnh</th>
                                        <th>Thanh toán</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    
                                        @foreach($salary as $sa)
                                    <tr>
                                        <td>{{$num++}}</td>
                                        <td>{{$sa->num_attendance}}</td>
                                        <td>{{$sa->num_done}} công</td>
                                    <td>{{$sa->num_attendance - $sa->num_done}} công</td>
                                    <td>{{number_format($sa->allowance * ($sa->num_attendance - $sa->num_done))}} VND</td>
                                    <td>{{number_format($sa->allowance *$sa->num_done )}} VND</td>
                                    <td>{{number_format($sa->reward)}} VND</td>
                                    <td>{{number_format($sa->position)}} VND</td>
                                    <td>{{number_format($sa->sum_position)}} VND</td>
                                    <td>{{$sa->reviced_date}}</td>                                  
                                    
                                    @if($sa->num_attendance - $sa->num_done != 0)
                                    <td><button class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal{{$sa->id}}" value="{{$sa->id}}">Thanh toán</button></td>
                                        <!-- Modal -->
                                        <div id="myModal{{$sa->id}}" class="modal fade" role="dialog">
                                                <div class="modal-dialog">
                                            
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Thanh Toán Lương</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                    <form action="{{asset('admin/salary').'/'.$sa->id}}" method="POST">
                                                                {{ csrf_field() }}
                                                                    <div class="form-group">
                                                                            <label>Công còn lại:</label>
                                                                            <input type="text" id='num_attendance' name="num_attendance" value="{{$sa->num_attendance - $sa->num_done}}" readonly placeholder="Số ngày công của nhân viên"  class="form-control">
                                                                    </div>
                                                                    <div class="form-group">
                                                                            <label >Công muốn thanh toán:</label>
                                                                    <input type="number" id="num_done" name="num_done"  value="{{$sa->num_attendance - $sa->num_done}}" max="{{$sa->num_attendance - $sa->num_done}}" min="1" class="form-control">
                                                                    </div>
                                                                    <div class="form-group">
                                                                            <label>Lương ngày:</label>
                                                                    <input type="number" id="salary_day" name="salary_date" step="100000" value="{{$sa->allowance}}" placeholder="Lương của công nhân" class="form-control">
                                                                    </div>
                                                                    <div class="form-group">
                                                                            <label>Thưởng:</label>
                                                                            <input type="number" name="reward" value="0" step="100000" id="reward" placeholder="Thưởng" class="form-control">
                                                                    </div>
                                                                    <div class="form-group">
                                                                            <label>Phụ cấp:</label>
                                                                            <input type="number" id="position" value="0" step="100000" name="position" placeholder="Phụ cấp" class="form-control">
                                                                    </div>
                                                                    <div class="form-group">
                                                                            <label>Thực lãnh:</label>
                                                                            <input type="text" id="sum_position" value="{{number_format($sa->allowance * ($sa->num_attendance - $sa->num_done))}} VND" name="sum_postion" readonly placeholder="Thực lãnh" class="form-control" >
                                                                    </div>
                                                                    <div class="form-group">
                                                                            <label">Ngày lãnh:</label>
                                                                            <input type="text" id='data_2' name="date_now" placeholder="Ngày lãnh" class="form-control">
                                                                    </div>
                                                                    <div class="form-group col-lg-offset-9" >
                                                                            <button type="submit" class="btn btn-success btn-sm" >Thanh toán</button>
                                                                    </div>
                                                            </form>
                                                    </div>
                                                   
                                                </div>
                                            
                                                </div>
                                            </div>
                                    @else
                                        <td><span class="label label-danger">Hoàn Tất Thanh Toán</span></td>
                                    @endif

                                    </tr>
                                    @endforeach      
                                    </tbody>                                  
                                </table>
                            @else
                            <form class="form-horizontal" method="POST"  >
                                    {{ csrf_field() }}
                                    <h4> Bảng tính lương của nhân viên</h4>
                                    <div class="form-group"><label class="col-lg-2 control-label">Số ngày công</label>
    
                                    <div class="col-lg-10"><input type="text" id='num_attendance' name="num_attendance" value="{{$att}}" readonly placeholder="Số ngày công của nhân viên" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-lg-2 control-label">Số công thanh toán</label>
    
                                    <div class="col-lg-10"><input id="num_done" name="num_done" type="number" min="0" max="{{$att}}" value="{{$att}}" placeholder="Số công thanh toán" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-lg-2 control-label">Số công còn lại</label>
    
                                        <div class="col-lg-10"><input id='num_aa' name="num_aa" type="number" readonly placeholder="Số công còn lại" class="form-control"> 
                                        </div>
                                    </div>
                                   
                                    
                                    <div class="form-group"><label class="col-lg-2 control-label">Lương theo ngày</label>
    
                                        <div class="col-lg-10"><input id="salary_day" required name="salary_date" step="100000" type="number" placeholder="Lương của công nhân" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-lg-2 control-label">Thưởng</label>
    
                                        <div class="col-lg-10"><input type="number" name="reward" value="0" step="100000" id="reward" placeholder="Thưởng" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-lg-2 control-label">Phụ cấp</label>
    
                                        <div class="col-lg-10"><input type="number" id="position" value="0" step="100000" name="position" placeholder="Phụ cấp" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-lg-2 control-label">Thực lãnh</label>
    
                                        <div class="col-lg-10"><input type="text" id="sum_position" name="sum_postion" readonly placeholder="Thực lãnh" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-lg-2 control-label">Ngày lãnh</label>
    
                                    <div class="col-lg-10"><input type="text" id='data_2' name="date_now" placeholder="Ngày lãnh" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-10 col-lg-10">
                                            <button {{$att == 0?'disabled':''}}  class="btn btn-danger" type="submit">Lưu</button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>
                 </div>
                
              </div>
              
           </div>
           
        </div>
        
     </div> 

@stop