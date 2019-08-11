@extends('Admin.layout')
@section('content')
<div class="col-lg-12">
    <div class="ibox float-e-margins">
    <div class="ibox-title">
    <h5 style="margin-top:2px">Bảng chấm công:</h5>  
    <span class="label label-info" style="font-size:15px"> {{$acc->name_contract}}</span>
    </div>
    <div class="ibox-content">
        <div class="row">
                <div class="row">
                        <div class="col-sm-9 m-b-xs">
                            <div data-toggle="buttons" class="btn-group">
                                <label class="btn btn-sm btn-white active"> <input type="radio" id="option1" name="options"> Day </label>
                                <label class="btn btn-sm btn-white"> <input type="radio" id="option2" name="options"> Week </label>
                                <label class="btn btn-sm btn-white"> <input type="radio" id="option3" name="options"> Month </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="input-group"><input type="text" placeholder="Search" class="input-sm form-control"> <span class="input-group-btn">
                                                <button type="button" class="btn btn-sm btn-primary"> Go!</button> </span></div>
                        </div>
                    </div>
        <div class="col-lg-3">
               
                <div class="contact-box center-version">

                        <a href="profile.html">
    
                            <img alt="image" class="img-circle" src="img/a2.jpg">

                            <h3 class="m-b-xs"><strong>{{$acc->name}}</strong></h3>
    
                            <div class="font-bold">{{$acc->name_role}}</div>
                            <address class="m-t-md">
                                <strong>{{$acc->name_type}}</strong><br>
                            Địa chỉ: <strong>{{$acc->address}}</strong><br>
                            Ngày bắt đầu: <strong>{{$acc->date_start}}</strong><br>
                            Ngày kết thúc: <strong>{{$acc->date_end}}</strong><br>
                            Số ngày làm việc trên hợp đồng:<strong> {{$acc->num_work}}</strong><br>
                            Hệ số lương:<strong> {{$acc->coefficients}}</strong><br> 
                            Số ngày nghỉ phép tối đa:<strong> {{$acc->num_max}}</strong><br>
                            Số ngày đã làm: <strong>{{$work}}</strong><br>

                            </address>
    
                        </a>
    
                    </div>
                    
        </div>
        <div class="col-lg-9">
                
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Ngày làm việc dự kiến</th>
                                <th>Ngày làm việc</th>
                                <th>Trạng thái </th>
                                <th>Công</th>
                                <th>Phép</th>
                                <th>Điểm danh </th> 
                            </tr>
                            </thead>
                            <tbody>   
                                    @foreach ($contract as $item)
                                    <?php $id_contract = $item->id_contract ?>
                                <tr>     
                                    <td>{{$num++}}</td>
                                    {{-- Kiểm tra lấy ngày làm việc theo hợp đồng --}}
                                    <td>{{$start1}}</td>
                                    <?php
                                       if((strtotime($end) - strtotime($start1))/ (60 * 60 * 24)>=0)
                                       {
                                           $start1 = Carbon\Carbon::parse($start1)->addDay();
                                           $start1 = Carbon\Carbon::parse($start1)->format('Y-m-d');    
                                        }
                                    ?>
                                    <td>{{$item->day}}</td>
                                    <td>
                                        <?php
                                            if($item->status == 1 && $item->permission == 0){
                                            echo 'Đi làm';
                                            $work++;
                                        }
                                            else if($item->status == 0 && $item->permission == 1) 
                                            echo 'Nghỉ làm có phép';
                                            else echo 'nghỉ làm không phép';
                                        ?>
                                    </td>
                                    <td><?php
                                        if($item->status == 1 && $item->permission == 0)
                                        echo '1';
                                        else echo'0';
                                    ?></td>
                                    <td></td>
                                    <td >
                                            <div class="checkbox checkbox-success" style="margin-top: 0px;" >
                                            <input id="{{$item->id}}" type="checkbox" onclick="checkonclick(this)" <?php echo $item->status == 1 && $item->permission == 0 ? 'checked' : '' ?>>
                                                    <label for="checkbox3"> </label>
                                            </div>
                                           
                                    </td>   
                                </tr>
                            @endforeach
                             @if((strtotime($end) - strtotime($start1))/ (60 * 60 * 24)>=0)            
                                    <tr>
                                    <td id='num'>{{$num++}}</td>
                                    <td>{{$start1}}</td>
                                    <td id="day"><a></a></td>
                                    <td id="status"></td>
                                    <td id="att"></td>
                                    <td id="per"></td>
                                    <td>
                                            <div class="checkbox checkbox-success" style="margin-top: 0px;">
                                            <input value="{{$acc->id}}" id="checkedAtt" type="checkbox">
                                                    <label for="checkbox3"> </label>
                                            </div>
                                    </td>  
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
        </div>
        </div>
    </div>
    </div>
    </div>
@stop