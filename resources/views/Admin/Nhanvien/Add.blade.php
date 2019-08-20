<?php $open = 'account' ?>
@extends('Admin.layout')
@section('content')
<div class="ibox-title">
<h5><a href="{{asset('admin/user')}}"> <i> <small> Danh sách nhân viên </small> </i> </a></h5> <h5>&nbsp;/&nbsp;</h5> {!! $open == 'account' ? '<h5>Thêm nhân viên</h5>':''!!} 
</div>
<div class="ibox-content">
   <form method="post" class="form-horizontal">
       {{ csrf_field() }}
      <div class="form-group">
         
         <label class="col-sm-2 control-label">Họ và tên</label>
      <div class="col-sm-10">
            {{ Form::text('name', old('name'), array('required','placeholder'=>'Nhập họ và tên','class'=>'form-control')) }}
      </div>
      </div>
      <div class="hr-line-dashed"></div>
      <div class="form-group">
         <label class="col-sm-2 control-label">Username</label>
      <div class="col-sm-10">
         {{Form::text('username',old('username'),array('required','placeholder'=>'Nhập username', 'class'=>'form-control'))}}
      </div>
      </div>
      <div class="hr-line-dashed"></div>
      <div class="form-group">
         <label class="col-sm-2 control-label">Password</label>
      <div class="col-sm-10">
         {!! Form::password('password', array('required','placeholder'=>'Nhập password','class'=>'form-control')) !!}
      </div>
      </div>
      <div class="hr-line-dashed"></div>
      <div class="form-group">
         <label class="col-sm-2 control-label">Chứng minh nhân dân</label>
      <div class="col-sm-10">
         {!! Form::text('passport', old('passport'), array('class'=>'form-control', 'placeholder'=>'Nhập chứng minh nhân dân')) !!}
      </div>
      </div>
      <div class="hr-line-dashed"></div>
      <div class="form-group">
         <label class="col-sm-2 control-label">Địa chỉ</label>
      <div class="col-sm-10">
         {!! Form::text('address', old('address'), array('placeholder'=>'Nhập địa chỉ của nhân viên', 'class'=>'form-control')) !!}
      </div>
      
      </div>
      <div class="hr-line-dashed"></div>
      <div class="form-group">
         <label class="col-sm-2 control-label">Số tài khoản</label>
      <div class="col-sm-10">
         {!! Form::text('num_account', old('num_account'), array('placeholder'=>'Nhập thông tin tài khoản ngân hàng', 'class'=>'form-control')) !!}
      </div>
      
      </div>
      <div class="hr-line-dashed"></div>
      <div class="form-group">
         <label class="col-sm-2 control-label">Bảo hiểm xã hội</label>
      <div class="col-sm-10">
         {!! Form::text('BHXH', old('BHXH'), array('placeholder'=>'Nhập BHXH của nhân viên', 'class'=>'form-control')) !!}
      </div>
      
      </div>
      <div class="hr-line-dashed"></div>
      <div class="form-group">
         <label class="col-sm-2 control-label">Thông tin thêm</label>
         <div class="col-sm-10">
         {!! Form::textarea('info',old('info'), array('id'=>'editor', 'cols'=>'30', 'rows'=>'10', 'placeholder'=>'Nhập nội dung thông tin thêm')) !!}
         </div>
      </div>
      <div class="hr-line-dashed"></div>
      <div class="form-group">
         <label class="col-lg-2 control-label" >Giới tính</label>
         <div class="col-sm-10">
            <div class="i-checks">
               <label class="">
                  <div class="iradio_square-green" style="position: relative;">
                  {!! Form::radio('sex', 1, 'checked', array('style'=>'position: absolute; opacity: 0;')) !!}
                  <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                  <i></i> Nam 
               </label>
            </div>
            <div class="i-checks">
               <label class="">
                  <div class="iradio_square-green " style="position: relative;">
                  {!! Form::radio('sex', 2, old('sex') == 2 ? 'checked':'', array('style'=>'position: absolute; opacity: 0;')) !!}
                  <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
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
               <option {{old('id_role') == 1 ? 'selected':''}} value="1">Quản lý nhân sự</option>
               <option {{old('id_role') == 2 ? 'selected':''}} value="2">Nhân viên</option>
            </select>
         </div>
      </div>
<div class="hr-line-dashed"></div>
<div class="form-group" style="text-align:right">
<div class="col-sm-9 col-sm-offset-2">
<a class="btn btn-white" href="{{asset('admin/user')}}">Hủy</a>
{!! Form::submit('Thêm mới', array('class'=>'btn btn-primary')) !!}
</div>
</div>
</form>
</div>
@stop