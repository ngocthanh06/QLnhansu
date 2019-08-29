<?php $open = 'account' ?>
@extends('Admin.layout')
@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5 style="margin-top:10px">Basic Table </h5>
            <a href="{{asset('admin/addUser')}}" style="margin-left: 10px;"class="btn btn-success">Thêm</a>
        </div>
        <div class="ibox-content">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Tên</th>
                    <th>Quyền</th>
                    <th>Địa chỉ</th>
                    <th>Giới tính</th>
                    <th>Thông tin</th>
                    <th>Username</th>
                    <th>BHXH</th>
                    <th>STK</th>
                    <th>Chứng minh thư</th>
                    <th>Thêm</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($all_User as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->name_role}}</td>
                        <td>{{$user->address}}</td>
                        <td>{{$user->sex == 1?'Nam':'Nữ'}}</td>
                        <td>{!!$user->info!!}</td>
                        <td>{{$user->username}}</td>
                        <td>{{$user->num_account}}</td>
                        <td>{{$user->BHXH}}</td>
                        <td>{{$user->passport}}</td>
                        <td>
                            <a href="{{asset('admin/editUser')."/".$user->id}}" class="btn btn-primary">Sửa</a>
                            <a href="{{asset('admin/deleteUser')."/".$user->id}}" class="btn btn-danger">Xóa</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div style="text-align:center">
                {!!$all_User->links()!!}
            </div>
        </div>
    </div>
@stop
