@php
    $open ='GetAttendance';
    $sum = 0;
    $total = 0;
@endphp
@extends('Admin.layout')
@section('content')
    <div class = "col-lg-12">
        <table class="table table-striped">
            <thead>
            <tr >
                <th scope="col">Lương tháng</th>
                <th scope="col">Tổng tiền thanh toán</th>
                <th scope="col">Người duyệt</th>
                <th scope="col">Ngày duyệt</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Chi tiết</th>
            </tr>
            </thead>
            <tbody >
            @foreach($list as $li)
                @php
                    $numcount = 0;
                @endphp
                <tr>
                    <td> Tháng {{Carbon\Carbon::parse($li->reviced_date)->month}}/{{Carbon\Carbon::parse($li->reviced_date)->year}}</td>
                    @php
                        $sumPay = DB::table('salary')->whereMonth('reviced_date',Carbon\Carbon::parse($li->reviced_date)->month)->whereYear('reviced_date',Carbon\Carbon::parse($li->reviced_date)->year)->sum('sum_position');
                        $sumMissTax = DB::table('salary')->whereMonth('reviced_date',Carbon\Carbon::parse($li->reviced_date)->month)->whereYear('reviced_date',Carbon\Carbon::parse($li->reviced_date)->year)->sum('sum_position') *5/100;
                        $sumTotal = $sumPay - $sumMissTax;
                    @endphp
                    {{-- check infoUserAccount and Salary_Accept--}}
                    <td>{{number_format($sumTotal)}} VND</td>
                    @foreach($getValAcceptSal as $val)
                        @if($val->month == Carbon\Carbon::parse($li->reviced_date)->month && $val->year == Carbon\Carbon::parse($li->reviced_date)->year)
                            {{-- Get Info--}}
                            <td id='UserAccept'>{{$val->name}}</td>
                            <td id='Day_accept'>{{$val->date_Accept}}</td>
                            @php
                                $numcount = $numcount + 1
                            @endphp
                        @endif
                    @endforeach
                    @if($numcount == 0)
                        <td id='UserAccept'></td>
                        <td id='Day_accept'></td>
                    @endif
                    <td><button class="btn btn-success btn-sm"  id="{{Carbon\Carbon::parse($li->reviced_date)->month}}/{{Carbon\Carbon::parse($li->reviced_date)->year}} " onclick="acceptSalary(this)">Xác nhận</button></td>
                    <td >
                        <div class="ibox-tools pull-left">
                            <button type="button" class="btn btn-info btn-lg btn-sm" onclick="month(this)" id="{{Carbon\Carbon::parse($li->reviced_date)->month}} / {{Carbon\Carbon::parse($li->reviced_date)->year}} " data-toggle="modal" data-target="#myModal{{$li->id}}">Chi tiết</button>
                            <div id="myModal{{$li->id}}" class="modal fade" role="dialog">
                                <div class="modal-dialog modal-lg" style="width:1120px;">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <form action="{{asset('admin/Export')}}" method="POST">
                                                {{ csrf_field() }}
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Lương tháng: <span class="badge badge-primary"><b id="monthA"></b></span>
                                                    <input name="month" id="monthB" value="" type="hidden">
                                                    <button type="submit" style="margin-left: 15px" class="btn btn-success" >Export Excel</button>
                                                </h4>
                                            </form>
                                        </div>
                                        <div class="modal-body">
                                            <table id="table_id" class="display">
                                                <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Tên nhân viên</th>
                                                    <th>CMND</th>
                                                    <th>STK</th>
                                                    <th>Chức vụ</th>
                                                    <th>BHXH</th>
                                                    <th>Công đã thanh toán</th>
                                                    <th>Tiền lương ngày</th>
                                                    <th>Thưởng</th>
                                                    <th>Phụ cấp</th>
                                                    <th>TN trước thuế</th>
                                                    <th>Thuế TNCN 5%</th>
                                                    <th>Thực lĩnh</th>
                                                    <th>Ngày lĩnh</th>
                                                </tr>
                                                </thead>
                                                <tbody id="showMonth">
                                                @php
                                                    $value = DB::table('account')->join('contract', 'contract.id_account', 'account.id')->join('salary', 'salary.id_attent', 'contract.id')->join('role', 'role.id', 'account.id_role')->get();
                                                @endphp
                                                @foreach($value as $lt)
                                                    <tr>
                                                        <td>{{$num++}}</td>
                                                        <td>{{$lt->name}} </td>
                                                        <td>{{$lt->passport}} </td>
                                                        <td>{{$lt->num_account}} </td>
                                                        <td>{{$lt->name_role}} </td>
                                                        <td>{{$lt->BHXH}} </td>
                                                        <td>{{$lt->num_done}}</td>
                                                        <td>{{number_format($lt->allowance * $lt->num_done)}}</td>
                                                        <td>{{number_format($lt->reward)}} </td>
                                                        <td> {{number_format($lt->position)}}</td>
                                                        <td>{{number_format($lt->sum_position)}} </td>
                                                        <td>{{number_format($lt->sum_position*5/100)}}</td>
                                                        <td>{{number_format($lt->sum_position - $lt->sum_position*5/100 )}} </td>
                                                        <td>{{$lt->reviced_date}} </td>
                                                        @php
                                                            $sum = $lt->sum_position - $lt->sum_position*5/100;
                                                            $total = $total + $sum;
                                                        @endphp
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <div style="float:right"  >
                                                <h4>Tổng cộng : <i id="total">{{number_format($total)}} VND</i></h4>
                                            </div>
                                            <div class="modal-footer">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop
