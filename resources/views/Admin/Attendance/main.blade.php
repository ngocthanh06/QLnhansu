@php
    $open = 'contract';
  $now = \Carbon\Carbon::now();
@endphp
@extends('Admin.layout')
@section('content')
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><a href="{{asset('admin/contract')}}"> <i> <small> Danh sách hợp đồng </small> </i> </a></h5>
                <h5>&nbsp; / &nbsp;</h5>
                <h5><a href="{{asset("admin/EditContract/".$acc->id)}}"><i><small>Sửa hợp đồng</small></i></a></h5>
                <h5>&nbsp;/&nbsp;</h5>
                {!! $open == 'contract' ? '
                <h5><i>Bảng chấm công '. $acc->name_contract.'</i></h5>
                <h5>&nbsp; /&nbsp; </h5>
                <h5><a href="'.asset("admin/salary/".$acc->id).'"><i><small>Lương</small></i></a></h5>
                <h5>&nbsp; / &nbsp;</h5>
                <h5><a href="'.asset("admin/DeleteContract/".$acc->id).'"><i><small>Hủy hợp đồng</small></i></a></h5>
                ':''!!}
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
                                    Vắng không phép:<strong> {{$miss}}</strong><br>
                                    Vắng có phép:<strong> {{$per}}</strong><br>
                                    Số ngày phép còn lại:<strong> {{12 - $per}}</strong><br>
                                    Tháng:<strong> {{Carbon\Carbon::parse($now)->month}}</strong><br>
                                    Số công làm:  <strong>{{$work}}</strong><br>
                                </address>
                                <div class="col-sm-offset-4">
                                    <a class="btn btn-danger" href="{{asset('admin/salary')."/".$acc->id}}"  >Xem chi tiết lương
                                    </a>
                                </div>
                                <div class="col-lg-offset-2">
                                    @if($countCheck>0)
                                        <a class="btn btn-warning" data-toggle="modal" data-target="#myModal{{$acc->id}}" style="margin-left:50px" >Phép</a>
                                        <!-- Modal -->
                                        <div id="myModal{{$acc->id}}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" onclick='window.location.reload(false)' class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Danh sách đơn xin nghỉ phép </h4>
                                                        Số lượng: <span class="label label-warning-light">{{$permi}}</span> - Đã duyệt: <span class="label label-warning-light">{{$countPer}}</span>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-hover">
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
                                                            @foreach($check as $ch)
                                                                <tr>
                                                                    <td>{{$num++}}</td>
                                                                    <td>{{$acc->name}}</td>
                                                                    <td>{{$ch->date_start}}</td>
                                                                    <td>{{$ch->date_end}}</td>
                                                                    <td>{{$ch->num_date_end}}</td>
                                                                    <td>{!!$ch->reason!!}</td>
                                                                    <td>
                                                                        @if($ch->status == 0)
                                                                            <button onclick='checkPermiss1(this)' value="{{$ch->id}}" id="accept1{{$ch->id}}" class="btn btn-sm btn-danger">Chưa xác nhận</button>
                                                                        @else
                                                                            <button onclick='checkPermiss1(this)' value="{{$ch->id}}" id="accept1{{$ch->id}}" class="btn btn-info btn-sm" >Đã Duyệt</button>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" onclick='window.location.reload(false)' class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ngày làm việc dự kiến</th>
                                    <th>Ngày làm việc</th>
                                    <th>Trạng thái </th>
                                    <th>Công</th>
                                    <th>Phép</th>
                                    <th>Vào làm</th>
                                    <th>Tan làm</th>
                                    <th>Điểm danh </th>
                                    <th>Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $num = 1; ?>
                                @if(count($contract)> 0)
                                    @foreach ($contract as $item)
                                        <?php $id_contract = $item->id_contract ?>
                                        <tr>
                                            <td>{{$num++}}</td>
                                            {{-- Kiểm tra lấy ngày làm việc theo hợp đồng --}}
                                            <td>{{$item->day}}</td>
                                            <td>{{$item->day}}</td>
                                            <?php
                                            if((strtotime($end) - strtotime($item->day))/ (60 * 60 * 24)>=0 || $end == null)
                                            {
                                                $item->day = Carbon\Carbon::parse($item->day)->addDay();
                                                $item->day = Carbon\Carbon::parse($item->day)->format('Y-m-d');
                                                $start1 = Carbon\Carbon::parse($start1)->addDay()->toDateString();
                                            }
                                            ?>
                                            <td>
                                                <?php
                                                if($item->status == 1 && $item->permission == 0){
                                                    echo 'Đi làm';
                                                    $work++;
                                                }
                                                // echo 'Nghỉ làm có phép';
                                                else if($item->status == 1 && $item->permission == 1){
                                                    echo 'Nghỉ làm có phép';
                                                    $work++;
                                                }
                                                else echo 'nghỉ làm không phép';
                                                ?>
                                            </td>
                                            {{-- Xử lý lỗi xin phép, công, --}}
                                            <td><?php
                                                if($item->status == 1 && $item->permission == 0 || $item->status == 1 && $item->permission == 1)
                                                    echo '1';
                                                else echo'0';
                                                ?></td>
                                            <td>
                                                <?php
                                                if($item->status == 1 && $item->permission == 0)
                                                    echo '';
                                                else if($item->status == 1 && $item->permission == 1 || $item->status == 0 && $item->permission == 1)
                                                    echo 'Có phép';
                                                else
                                                    echo 'Không phép';
                                                ?>
                                            </td>
                                            <td>
                                                {{date('h:i A',strtotime($item->checkin))}}
                                            </td>
                                            <td>
                                                {{date('h:i A',strtotime($item->checkout))}}
                                            </td>
                                            <td >
                                                <div class="checkbox checkbox-success" style="margin-top: 0px;" >
                                                    <input  id="{{$item->id}}" type="checkbox" onclick="checkonclick(this)"
                                                        @php
                                                            if($item->status == 1 && $item->permission == 0 || $item->status == 1 && $item->permission == 1)
                                                            echo 'checked';
                                                        @endphp
                                                    >
                                                    <label for="checkbox3"> </label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="ibox float-e-margins">
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal{{$item->id}}">Sửa</button>
                                                    <div id="myModal{{$item->id}}" class="modal fade" role="dialog">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    <h4 class="modal-title">Sửa thời gian</h4>
                                                                </div>
                                                                <form method="post" action="{{asset('admin/getAttendance').'/'.$item->id}}">
                                                                    {{csrf_field()}}
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <label for="Checkin">Giờ vào:</label>
                                                                            <div class="bootstrap-timepicker">
                                                                                <input  class="form-control" id="timepicker{{$item->id}}" name="checkin"  type="text" >
                                                                                <i class="icon-time"></i>
                                                                            </div>
                                                                            <script type="text/javascript">
                                                                                $('#timepicker{{$item->id}}').timepicker({
                                                                                    template: false,
                                                                                    showInputs: false,
                                                                                    minuteStep: 5
                                                                                });
                                                                            </script>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="email">Giờ ra:</label>
                                                                            <div class="bootstrap-timepicker ">
                                                                                <input class="form-control" id="timepic{{$item->id}}" value="17:30" name ="checkout" type="text" >
                                                                                <i class="icon-time"></i>
                                                                            </div>
                                                                            <script type="text/javascript">
                                                                                $('#timepic{{$item->id}}').timepicker({
                                                                                    template: false,
                                                                                    showInputs: false,
                                                                                    minuteStep: 5
                                                                                });
                                                                            </script>
                                                                        </div>
                                                                        <input type="hidden" value="{{$item->id}}" name = 'id'>
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
                                    @endforeach
                                @endif
                                {{-- Không có ngày kết thúc --}}
                                @if(!isset($end) && $num <=10)
                                    <tr>
                                        <td id='num'>{{$num++}}</td>
                                        <td>{{$now->toDateString()}}</td>
                                        <td id="day"><a></a></td>
                                        <td id="status"></td>
                                        <td id="att"></td>
                                        <td id="per"></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="checkbox checkbox-success" style="margin-top: 0px;">
                                                <input value="{{$acc->id}}" name='check' onclick="checkedAtt(this)" id="{{\Carbon\Carbon::now()->toDateString()}}" type="checkbox">
                                                <label for="checkbox3"> </label>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                {{-- Có ngày kết thúc --}}
                                @if((strtotime($end) - strtotime($start1))/ (60 * 60 * 24)>=0)
                                    @if($num <=10)
                                        <tr>
                                            <td id='num'>{{$num++}}</td>
                                            <td>{{$start1}}</td>
                                            <td id="day"><a></a></td>
                                            <td id="status"></td>
                                            <td id="att"></td>
                                            <td id="per"></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <div class="checkbox checkbox-success" style="margin-top: 0px;">
                                                    <input value="{{$acc->id}}" name='check' onclick="checkedAtt(this)" id="{{$start1}}" type="checkbox">
                                                    <label for="checkbox3"> </label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                                </tbody>
                            </table>
                            <div style="text-align:center">
                                {{$contract->links()}}
                            </div>
                            <?php Session($num) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
