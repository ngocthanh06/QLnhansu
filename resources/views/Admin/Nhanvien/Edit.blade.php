<?php $open = 'account' ?>
@extends('Admin.layout')
@section('content')
<div class="ibox-title">
        <h5>Thêm nhân viên <small>Thêm nhân viên hoặc Quản lý nhân sự.</small></h5>
     </div>
     <div class="ibox-content">
        <form method="post" class="form-horizontal">
            {{ csrf_field() }}
           <div class="form-group">
              <label class="col-sm-2 control-label">Họ và tên</label>
           <div class="col-sm-10"><input type="text" required value="{{$user->name}}" name="name" placeholder="Nhập họ và tên" class="form-control"></div>
           </div>
           <div class="hr-line-dashed"></div>
           <div class="form-group">
              <label class="col-sm-2 control-label">Username</label>
           <div class="col-sm-10"><input type="text" required value="{{$user->username}}" name="username" placeholder="Nhập username" class="form-control"> </div>
           </div>
           <div class="hr-line-dashed"></div>
           <div class="form-group">
              <label class="col-sm-2 control-label">Password</label>
           <div class="col-sm-10"><input type="password" required value="{{$user->password}}" placeholder="Nhập password" class="form-control" name="password"></div>
           </div>
           <div class="hr-line-dashed"></div>
           <div class="form-group">
              <label class="col-sm-2 control-label">Chứng minh nhân dân</label>
           <div class="col-sm-10"><input type="text" re name="passport" class="form-control" placeholder="Nhập chứng minh nhân dân" value="{{$user->passport}}"></div>
           </div>
           <div class="hr-line-dashed"></div>
           <div class="form-group">
              <label class="col-sm-2 control-label">Địa chỉ</label>
           <div class="col-sm-10"><input type="text" value="{{$user->address}}" name="address" placeholder="Nhập địa chỉ của bạn" class="form-control"></div>
           </div>
           <div class="hr-line-dashed"></div>
           <div class="form-group">
              <label class="col-sm-2 control-label">Thông tin thêm</label>
              <div class="col-sm-10">
              <textarea name="info" id="editor" cols="30" rows="10" placeholder="Nhập nội dung thông tin thêm">{{$user->info}}</textarea>
              </div>
           </div>
           <div class="hr-line-dashed"></div>
           <div class="form-group">
              <label class="col-lg-2 control-label" >Giới tính</label>
              <div class="col-sm-10">
                 <div class="i-checks">
                    <label class="">
                       <div class="iradio_square-green" style="position: relative;">
                       <input type="radio" {{$user->sex == 1 ? 'checked':''}} value="1" name="sex" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                       <i></i> Nam 
                    </label>
                 </div>
                 <div class="i-checks">
                    <label class="">
                       <div class="iradio_square-green " style="position: relative;">
                         <input type="radio"  value="2" name="sex" {{$user->sex == 2 ? 'checked':''}} style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                       <i></i> Nữ 
                    </label>
                 </div>
              </div>
           </div>
           <div class="hr-line-dashed"></div>
           <div class="form-group">
              <label class="col-lg-2 control-label">Quyền</label>
              <div class="col-sm-10">
                 <select class="form-control m-b" name="id_role">
                    <option {{$user->id_role == 1 ? 'selected':''}} value="1">Quản lý nhân sự</option>
                    <option {{$user->id_role == 2 ? 'selected':''}} value="2">Nhân viên</option>
                 </select>
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