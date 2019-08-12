<?php $open = 'permission' ?>
@extends('Admin.layout')
@section('content')
<div class="col-lg-5">
        <div class="ibox float-e-margins">
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
        </div>
</div>
<div id="showw" class="col-lg-7">
    
</div>
@stop