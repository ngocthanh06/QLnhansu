<?php $open = 'home' ?>
@extends('Admin.layout')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <div class="col-lg-4">
            <h2>Lịch đi làm Tháng</h2>
            </div> 
            <form action="" method="post">
                    {{ csrf_field() }}
            <div class="col-lg-3 m-b" style="margin-top:20px">
            
                
                    <select id="getvalue" name="Month" class="form-control">
                            <?php $num = 1 ?>
                            @for($num = 1; $num<=12;$num++)
                        <option value="{{$num}}" {{$num == $month ? 'selected':''}} >{{$num}}</option>
                            @endfor
                        </select> 
                     
                   
            </div>
            <div class="col-lg-2 " style="margin-top:20px">
                    <input class="btn btn-primary" type="submit" value="Submit"> 
            </div>
            </form> 
                <div class="col-lg-12">
                        <ol class="breadcrumb">
                                <li>
                                    <a href="index.html">Home</a>
                                </li>
                                <li>
                                    Extra pages
                                </li>
                                <li class="active">
                                    <strong>Calendar</strong>
                                </li>
                            </ol>
                </div>
        </div>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row animated fadeInDown">
            <div class="col-lg-3">
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
                        <div id='external-events'>
                            <h4>Tên hợp đồng: 
                                <select name="contract" id="contract">
                                    @foreach($contract as $detai)  
                                <option value="{{$detai->id}}">{{$detai->name_contract}}</option>
                                    @endforeach
                                </select>
                            </h4>
                                <h4 id="show"></h4>
                        </div>       
                    </div>           
                    {{-- End --}}
                </div>

                <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Chi tiết công làm</h5>
                            <div class="ibox-tools">
                                <a id="click1" class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        {{-- ĐIền dữ liệu --}}
                        <div class="ibox-content">
                            <div id='external-events'>
                                    <h4 id="show1"></h4>
                            <h4 id="show1"></h4>
                            
                            </div>
                        </div>
                        {{-- End --}}
                </div>

                    <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Tiền lương</h5>
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
                            <div class="ibox-content">
                                <div id='external-events'>
                                    <h4>Lương tháng: </h4>
                                    <h4>Ngày lãnh: </h4>
                                    <h4>Chức vụ: </h4>
                                    <h4>Thưởng: </h4>
                                    <h4>Phụ cấp: </h4>
                                    <h4>Phạt: </h4>
                                    <h4>Thực lãnh: </h4>

                                </div>
                            </div>
                        </div>
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <h2>FullCalendar</h2> is a jQuery plugin that provides a full-sized, drag & drop calendar like the one below. It uses AJAX to fetch events on-the-fly for each month and is
                        easily configured to use your own feed format (an extension is provided for Google Calendar).
                        <p>
                            <a href="http://arshaw.com/fullcalendar/" target="_blank">FullCalendar documentation</a>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-9">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Striped Table </h5>
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
                    <div class="ibox-content">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop