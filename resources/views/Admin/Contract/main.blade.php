<?php $open = 'contract' ?>
@extends('Admin.layout')
@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5 style="margin-top:10px">Danh sách hợp đồng </h5>
            <a href="{{asset('admin/AddContract')}}" style="margin-left: 10px;"class="btn btn-success">Thêm</a>
        </div>
        <div class="ibox-content">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Tên hợp đồng</th>
                    <th>Loại hợp đồng</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Trạng thái</th>
                    <th>Nhân viên</th>
                    <th>Tài khoản</th>
                    <th>Ca làm</th>
                    <th>Tùy chọn</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($contract as $con)
                    <tr>
                        <td>{{$con->id}}</td>
                        <td>{{$con->name_contract}}</td>
                        <td>{{$con->name_type}}</td>
                        <td>{{$con->date_start}}</td>
                        <td>{{$con->date_end}}</td>
                        <td>
                            <?php
                            //Lấy thời gian theo format
                            if(isset($con->date_end) ){
                                $time = Carbon\Carbon::parse($con->date_end)->toDateString();
                                echo (strtotime($time) - strtotime($now))/ (60 * 60 * 24) > 0 ?"<span class='badge badge-warning'>Còn hạn</span>":"<span class='badge badge-danger'>Hết hạn</span>" ;
                            }
                            else
                                echo "<span class='badge badge-warning'>Còn hạn</span>";
                            ?>
                        </td>
                        <td>{{$con->name}}</td>
                        <td>{{$con->username}}</td>
                        <td>
                            <?php

                                switch ($con->coefficients)
                                {
                                    case 1:
                                        echo 'Cả ngày';
                                        break;
                                    case 2:
                                        echo 'Ca sáng';
                                        break;
                                    default:
                                        echo 'Ca chiều';
                                        break;
                                }
                            ?>
                        </td>
                        <td>
                            <a href="{{asset('admin/salary')."/".$con->id}}" class="btn btn-danger btn-sm">Lương</a>
                            <a href="{{asset('admin/getAttendance')."/".$con->id}}" class="btn btn-success btn-sm">Công</a>
                            <a href="{{asset('admin/EditContract')."/".$con->id}}" class="btn btn-primary btn-sm">Sửa</a>
                            <a href="{{asset('admin/DeleteContract')."/".$con->id}}" class="btn btn-danger btn-sm">Hủy</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div style="text-align:center">
                {{$contract->links()}}
            </div>
        </div>
    </div>
@stop
