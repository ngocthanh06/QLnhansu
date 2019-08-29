<?php $open = 'home' ?>
@extends('Admin.layout')
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <div class="col-lg-4">
                <h2>Lịch đi làm Tháng</h2>
            </div>
            <form action="" method="post">
                {{ csrf_field() }}
                <div class="col-lg-3 m-b" style="margin-top:20px">
                    <select id="getvalue" name="Month" class="form-control" disabled>
                        <?php $num = 1 ?>
                        @for($num = 1; $num<=12;$num++)
                            <option value="{{$num}}" {{$num == $month ? 'selected':''}} >{{$num}}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-lg-2 " style="margin-top:20px">
                </div>
            </form>
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li class="active">
                        <a href="{{asset('admin/home')}}"><strong>Home</strong></a>
                    </li>
                    <li>
                        <a href="{{asset('admin/getPermission')}}">Xin nghỉ phép</a>
                    </li>
                    <li >
                        <a href="{{asset('admin/SalaryEmploys')}}" >Lương của nhân viên</a>
                    </li>
                    <li>
                        <a href="{{asset('admin/changepass')}}">Thông tin nhân viên</a>
                    </li>
                </ol>
            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row animated fadeInDown">
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Hợp đồng</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    {{-- ĐIền dữ liệu --}}
                    <div class="ibox-content">
                        <div id='external-events'>
                            <h4>Tên hợp đồng:
                                <span class="badge badge-primary">{{$contract->name_contract}}</span>
                            </h4>
                            <h4>
                                Ngày bắt đầu: <span class="badge badge-primary">{{$contract->date_start}}</span>
                            </h4>
                            <h4>
                                Ngày kết thúc: <span class="badge badge-primary">{{$contract->date_end == null ? 'Không xác định':$contract->date_end}}</span>
                            </h4>
                            <h4>
                                Chức vụ: <span class="badge badge-primary">{{$role->name_role}} </span>
                            </h4>
                        </div>
                    </div>
                    {{-- End --}}
                </div>
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Chi tiết công làm</h5>
                        <div class="ibox-tools">
                            <a id="click1" class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    {{-- ĐIền dữ liệu --}}
                    <div class="ibox-content">
                        <div id='external-events'>
                            <h4>
                                Công tháng: <span class="badge badge-primary">{{$month}}</span>
                            </h4>
                            <h4>
                                Số công: <span class="badge badge-primary">{{$num_day}}</span>
                            </h4>
                            <h4>
                                Số phép tối đa: <span class="badge badge-primary">12</span>
                            </h4>
                            <h4>
                                Vắng không phép: <span class="badge badge-primary">{{$miss}}</span>
                            </h4>
                            <h4>
                                Vắng có phép: <span class="badge badge-primary">{{$num_per}}</span>
                            </h4>
                            <h4>
                                Số phép còn lại: <span class="badge badge-primary">{{$num_per_pass}}</span>
                            </h4>
                            <h4 id="show1"></h4>
                        </div>
                    </div>
                    {{-- End --}}
                </div>
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Tiền lương</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div id='external-events'>
                            @foreach($sala as $sa)
                                <h4>Lương tháng: <span class="badge badge-primary">{{$month}}</span></h4>
                                <h4>Ngày lãnh: <span class="badge badge-primary">{{$sa->reviced_date}}</span></h4>
                                <h4>Lương ngày: <span class="badge badge-primary">{{number_format($sa->allowance)}} VND</span></h4>
                                <h4>Thưởng: <span class="badge badge-primary">{{number_format($sa->reward)}} VND</span></h4>
                                <h4>Phụ cấp: <span class="badge badge-primary">{{number_format($sa->position)}} VND</span></h4>
                                <h4>TN trước thuế: <span class="badge badge-primary">{{number_format($sa->sum_position)}} VND</span></h4>
                                <h4>Thuế 5%: <span class="badge badge-primary">{{number_format($sa->sum_position*5/100)}} VND</span></h4>
                                <h4>Thực lãnh: <span class="badge badge-primary">{{number_format($sa->sum_position - ($sa->sum_position*5/100))}} VND</span></h4>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Striped Table </h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div id="calendar">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
