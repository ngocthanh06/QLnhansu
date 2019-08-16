<?php $open = 'contract' ?>
@extends('Admin.layout')
@section('content')
<div class="ibox-title">
        <h5>Hủy hợp đồng <small>Hủy hợp đồng cho nhân viên.</small></h5>
     </div>
     <div class="ibox-content">
        <form method="post" class="form-horizontal">
            {{ csrf_field() }}
            <div class="form-group">
                    <label class="col-sm-2 control-label">Ngày kết thúc</label>
                 <div class="col-sm-6" ><div class="input-group date" >
                 <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="data_2" required name="date_now" class="form-control" value="">
                  </div>
                </div>
           </div>
           <div class="form-group">
                <div class="col-sm-9 col-sm-offset-6">
                        <button class="btn btn-primary" type="submit">Cập nhật</button>
                    </div>
           </div>
        </form>
    </div>
        @stop