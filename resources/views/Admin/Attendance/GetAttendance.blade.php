@php
    $open ='GetAttendance';
    $sum = 0;
    $total = 0;
@endphp
@extends('Admin.layout')
@section('content')
<div class="col-lg-12">

<div class="ibox float-e-margins">

<div class="ibox-content">
        <div>
            <form action="{{asset('admin/Export')}}" method="POST">
                {{ csrf_field() }}
            <h3>Lương Tháng
                <select name="month" id="month">
                        <option value="all">Tất cả</option>
                        @for($i=1; $i<=12; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                <button type="submit" style="margin-left: 15px" class="btn btn-success" >Export Excel</button>
            </h3>
            </form>
        </div>
    <div class="ibox-content">
        <table class="display" id="table_id">
            <thead>
            <tr>
                <th>STT</th>
                <th>Tên nhân viên</th>
                <th>CMND</th>
                <th>STK</th>
                <th>Chức vụ</th>
                <th>BHXH</th>
                <th>Công đã thanh toán</th>
                <th>Tiền lương</th>
                <th>Thưởng</th>
                <th>Phụ cấp</th>
                <th>TN trước thuế</th>
                <th>Thuế TNCN 5%</th>
                <th>Thực lĩnh</th>
                <th>Ngày lĩnh</th>
            </tr>
            </thead>
            <tbody id="showMonth">
                @foreach($list as $lt)
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
            <div style="float:right"  ><h4>Tổng cộng : <i id="total">{{number_format($total)}} VND</i></h4></div>

    </div>
</div>
</div>

</div>
@stop
