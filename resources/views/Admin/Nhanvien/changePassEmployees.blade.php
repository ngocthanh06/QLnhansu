<?php $open = 'changepass' ?>
@extends('Admin.layout')
@section('content')
    <div class="ibox-title">
        <h5><a href="{{asset('admin/user')}}"> <i> <small> Danh sách nhân viên </small> </i> </a></h5> <h5>&nbsp;/&nbsp;</h5> {!! $open == 'account' ? '<h5>Sửa nhân viên</h5>':''!!}
    </div>
    <div class="ibox-content">
        <form method="POST" action="{{asset('admin/changepass')}}" class="form-horizontal">
            {{ csrf_field() }}
            <div class="form-group">
                <label class="col-sm-2 control-label">Họ và tên</label>
                <div class="col-sm-10">
                    <input type="text" required value="{{$user->name}}" name="name" disabled placeholder="Nhập họ và tên" class="form-control"></div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Username</label>
                <div class="col-sm-10">
                    <input type="text" required value="{{$user->username}}" name="username" disabled placeholder="Nhập username" class="form-control"> </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" required value="{{$user->password}}" placeholder="Nhập password" class="form-control" name="password"></div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Chứng minh nhân dân</label>
                <div class="col-sm-10">
                    <input type="text" re name="passport" class="form-control"  placeholder="Nhập chứng minh nhân dân" value="{{$user->passport}}"></div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Địa chỉ</label>
                <div class="col-sm-10">
                    <input type="text" value="{{$user->address}}" name="address" placeholder="Nhập địa chỉ của bạn" class="form-control"></div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Số tài khoản</label>
                <div class="col-sm-10">
                    {!! Form::text('num_account', $user->num_account, array('placeholder'=>'Nhập thông tin tài khoản ngân hàng', 'class'=>'form-control')) !!}
                </div>
            </div>
                <div class="hr-line-dashed"></div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Tên ngân hàng</label>
                <div class="col-sm-10">
                    {!! Form::text('bank', $user->bank, array('placeholder'=>'Nhập thông tin ngân hàng', 'class'=>'form-control')) !!}
                </div>

            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Bảo hiểm xã hội</label>
                <div class="col-sm-10">
                    {!! Form::text('BHXH', $user->BHXH, array('placeholder'=>'Nhập BHXH của nhân viên', 'class'=>'form-control')) !!}
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



    @endsection
