<?php $open = 'contract' ?>
@extends('Admin.layout')
@section('content')
    <div class="ibox-title">
        <h5><a href="{{asset('admin/contract')}}"> <i> <small> Danh sách hợp đồng </small> </i> </a></h5>
        <h5>&nbsp;/&nbsp;</h5>
        {!! $open == 'contract' ? '
        <i>
           <h5>Sửa hợp đồng </h5>
        </i>
        <h5>&nbsp; / &nbsp;</h5>
        <h5><a href="'.asset("admin/getAttendance/".$contract->id).'"><i><small>Công</small></i></a></h5>
        <h5>&nbsp; /&nbsp; </h5>
        <h5><a href="'.asset("admin/salary/".$contract->id).'"><i><small>Lương</small></i></a></h5>
        <h5>&nbsp; / &nbsp;</h5>
        <h5><a href="'.asset("admin/DeleteContract/".$contract->id).'"><i><small>Hủy hợp đồng</small></i></a></h5>
        ':''!!}
    </div>
    <div class="ibox-content">
        <form method="post" class="form-horizontal">
            {{ csrf_field() }}
            <div class="form-group">
                <label class="col-sm-2 control-label">Loại hợp đồng</label>
                <div class="col-sm-10">
                    <select class="form-control m-b" id="id_type_contract" name="id_type_contract">
                        @foreach($type_contract as $type)
                            <option {{$contract->id_type_contract == $type->id ? 'selected':''}} value="{{$type->id}}">{{$type->name_type}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Tên nhân viên</label>
                <div class="col-sm-10">
                    <select class="form-control m-b" id='account' name="id_account">
                        @foreach($user as $type)
                            <option {{$contract->id_account == $type->id ? 'selected':''}} value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Tài khoản nhân viên</label>
                <div class="col-sm-10">
                    <input type='text' id="getAccount" value='' readonly name='username' placeholder='Tài khoản nhân viên' class='form-control'>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Tên hợp đồng</label>
                <div class="col-sm-10"><input type="text" required value="{{$contract->name_contract}}" name="name_contract" placeholder="Nhập tên hợp đồng" class="form-control"> </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Ngày bắt đầu</label>
                <div class="col-sm-10" id="data_2">
                    <div class="input-group date" >
                        <?php
                        $time_start = Carbon\Carbon::parse($contract->date_start)->toDateString();
                        ?>
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" required name="date_now" class="form-control" value="{{Carbon\Carbon::parse($time_start)->format('m/d/Y')}}">
                    </div>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Số ngày phép tối đa</label>
                <div class="col-sm-10"><input id="num_max" type="text" readonly name="num_max"  class="form-control" min="5" max="20" value="{{$contract->num_max    }}"></div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Ca làm</label>
                <div class="col-sm-10">
                    <select  id="coefficients" name="coefficients" class="form-control">
                        <option {{$contract->coefficients == 1 ? 'selected':''}} value="1">Ca sáng</option>
                        <option {{$contract->coefficients == 2 ? 'selected':''}} value="2">Ca chiều</option>
                        <option {{$contract->coefficients == 3 ? 'selected':''}} value="3">Cả ngày</option>
                    </select>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Nội dung</label>
                <div class="col-sm-10">
                    <textarea name="content" id="editor" cols="30" rows="10" placeholder="Nhập nội dung thông tin thêm">{{$contract->content}}</textarea>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group" style="text-align:right">
                <div class="col-sm-9 col-sm-offset-2">
                    <a class="btn btn-white" href="{{asset('admin/user')}}">Hủy</a>
                    <button class="btn btn-primary" type="submit">Sửa</button>
                </div>
            </div>
        </form>
    </div>
@stop
