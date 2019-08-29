<?php $open = 'salaryEm' ?>
@extends('Admin.layout')
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading" style="margin-left: 0px;margin-right: 0px;">
        <div class="col-lg-8">
            <div class="col-lg-4">
                <h2>Lương của nhân viên</h2>
            </div>
            <div class="col-lg-12">
                <div class="col-lg-12">
                    <ol class="breadcrumb">
                        <li class="active">
                            <a href="{{asset('admin/home')}}">Home</a>
                        </li>
                        <li>
                            <a href="{{asset('admin/getPermission')}}">Xin nghỉ phép</a>
                        </li>
                        <li >
                            <strong><a href="{{asset('admin/changepass')}}">Lương của nhân viên</a></strong>
                        </li>
                        <li>
                            <a href="{{asset('admin/changepass')}}">Thông tin nhân viên</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row animated fadeInDown">
            <div class="ibox-content">
                <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="8">
                    <thead>
                    <tr>
                        <th data-toggle="true">Lương tháng</th>
                        <th>Số tài khoản</th>
                        <th>Ngân hàng</th>
                        <th data-hide="all">Lương ngày</th>
                        <th data-hide="all">Công</th>
                        <th data-hide="all">Thưởng</th>
                        <th data-hide="all">Phụ cấp</th>
                        <th data-hide="all">TN trước thuế</th>
                        <th data-hide="all">Thuế 5%</th>
                        <th>Thực lãnh</th>
                        <th>Ngày lãnh</th>
                        <th>Trạng thái</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($salary as $sa)
                        <tr>
                            <td>Lương tháng {{Carbon\Carbon::parse($sa->reviced_date)->month}}</td>
                            <td>Bổ sung</td>
                            <td>Bổ sung 2</td>
                            <td>{{number_format($sa->allowance)}} VND</td>
                            <td>{{$sa->num_done}}</td>
                            <td>{{number_format($sa->reward)}} VND</td>
                            <td>{{number_format($sa->position)}} VND</td>
                            @php
                                $num = $sa->sum_position*5/100;
                                $total = $sa->sum_position-$sa->sum_position*5/100
                            @endphp
                            <td>{{number_format($sa->sum_position)}} VND</td>
                            <td>{{number_format($num)}} VND</td>
                            <td>{{number_format($total)}} VND</td>
                            <td>{{$sa->reviced_date}} VND</td>
                            <td><span class="badge {{$sa->status == 1 ?'badge-primary':'badge-danger'}} ">{{$sa->status == 1 ? 'Đã thanh toán' : 'Chưa thanh toán'}}</span></td>
                        </tr>
                    @endforeach
                    <tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="5">
                            <ul style="display:none" class="pagination pull-right"></ul>
                        </td>
                    </tr>
                    </tfoot>
                    <div class="pull-right">{{$salary->links()}}</div>
                </table>
            </div>
        </div>
    </div>
    </div>
@stop
