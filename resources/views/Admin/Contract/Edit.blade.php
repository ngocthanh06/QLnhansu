<?php $open = 'contract' ?>
@extends('Admin.layout')
@section('content')
<div class="ibox-title">
        <h5>Sửa hợp đồng <small>Sửa hợp đồng cho nhân viên.</small></h5>
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
              <label class="col-sm-2 control-label">Ngày bắt đầu - Ngày kết thúc</label>
           <div class="col-sm-10" id="data_2"><div class="input-group date" >
           <?php 
                 $time_start = Carbon\Carbon::parse($contract->date_start)->toDateString();
                 $time_end = Carbon\Carbon::parse($contract->date_end)->toDateString();
            ?>
           <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" required name="date_now" class="form-control" value="{{Carbon\Carbon::parse($time_start)->format('m/d/Y')}} - {{Carbon\Carbon::parse($time_end)->format('m/d/Y')}}">
            </div></div>
           </div>
           {{-- date start and date end --}}
           <div class="col-sm-10" id="data_2"><div class="input-group date" >
                    <input type="hidden" required name="date_end" class="form-control" value="{{$contract->date_end}}">
                    <input type="hidden" required name="date_start" class="form-control" value="{{$contract->date_start}}">
               </div></div>
              

           <div class="hr-line-dashed"></div>
           <div class="form-group">
              <label class="col-sm-2 control-label">Số ngày phép tối đa</label>
           <div class="col-sm-10"><input id="num_max" type="text" readonly name="num_max"  class="form-control" min="5" max="20" value="{{$contract->num_max    }}"></div>
           </div>
           <div class="hr-line-dashed"></div>
           <div class="form-group">
              <label class="col-sm-2 control-label">Hệ số lương</label>
           <div class="col-sm-10"><input type="text" min="2" max="3" id="coefficients" " readonly name="coefficients" class="form-control"  value="{{$contract->coefficients}}"></div>
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