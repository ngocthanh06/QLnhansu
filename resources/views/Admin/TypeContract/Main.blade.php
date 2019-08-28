<?php $open = 'type_contract' ?>
@extends('Admin.layout')
@section('content')
<div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5 style="margin-top:10px">Basic Table </h5>
{{--        <a href="{{asset('admin/addUser')}}" style="margin-left: 10px;"class="btn btn-success">Thêm</a>--}}
        </div>
        <div class="ibox-content">

            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Tên loại hợp đồng</th>
                    <th>Tùy chọn</th>
                </tr>
                </thead>
                <tbody>

                    @foreach ($type_contract as $type)
                    <tr>
                        <td>{{$type->id}}</td>
                        <td>{{$type->name_type}}</td>

                        <td>
{{--                        <a href="{{asset('admin/editTypeContract')."/".$type->id}}" class="btn btn-primary">Sửa</a>--}}
{{--                            <a href="{{asset('admin/deleteTypeContract')."/".$type->id}}" class="btn btn-danger">Xóa</a>--}}
                        </td>
                    </tr>
                    @endforeach



                </tbody>
            </table>

        </div>
    </div>


@stop
