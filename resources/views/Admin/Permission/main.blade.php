<?php $open = 'permission' ?>
@extends('Admin.layout')
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading" style="margin-left: 0px;margin-right: 0px;">
        <div class="col-lg-8">
            <div class="col-lg-4">
                <h2>Xin nghỉ phép</h2>
            </div>
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li class="active">
                        <a href="{{asset('admin/home')}}">Home</a>
                    </li>
                    <li>
                        <a href="{{asset('admin/getPermission')}}"><strong>Xin nghỉ phép</strong></a>
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
            <div class="col-lg-5">
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
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Loại hợp đồng</th>
                                <th>Tên hợp đồng</th>
                                <th>Ngày bắt đầu</th>
                                <th>Ngày kết thúc</th>
                                <th>Tình trạng</th>
                                <th>Nghỉ phép</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($contract_user as $cont)
                                <tr>
                                    <td>{{$num ++}}</td>
                                    <td>{{$cont->name_type}}</td>
                                    <td>{{$cont->name_contract}}</td>
                                    <td>{{$cont->date_start}}</td>
                                    <td>{{$cont->date_end}}</td>
                                    <td>
                                        <?php
                                        if($cont->date_end==null)
                                            echo "<span class='badge badge-warning'>Còn hạn</span>";
                                        else
                                            //Lấy thời gian theo format
                                            echo (strtotime($cont->date_end) - strtotime($now))/ (60 * 60 * 24) > 0 ?"<span class='badge badge-warning'>Còn hạn</span>":"<span class='badge badge-danger'>Hết hạn</span>" ;
                                        ?>
                                    </td>
                                    <td><button onclick="checkID(this)" id="{{$cont->id}}" class="btn btn-success btn-sm">Chi tiết</button></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- End --}}
                </div>
            </div>
            <div id="showw" class="col-lg-7">
            </div>
@stop
