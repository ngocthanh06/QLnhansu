<template>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5 style="margin-top:10px">Danh sách chấm công nhân viên </h5>
        </div>
        <div class="ibox-content">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Tên nhân viên</th>
                    <th>Hợp đồng</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Đi làm</th>
                    <th>Giờ vào</th>
                    <th>Giờ ra</th>
                    <th>Phép</th>
                    <th>Chấm công</th>
                </tr>
                </thead>
                <tbody>
<!--                @foreach($permission as $per)-->
<!--                <tr>-->
<!--                    <td></td>-->
<!--                    <td>{{$per->name}}</td>-->
<!--                    <td>{{$per->name_contract}}</td>-->
<!--                    <td>{{$per->date_start}}</td>-->
<!--                    @if(!$per->date_end)-->
<!--                    <td>Không xác định</td>-->
<!--                    @else-->
<!--                    <td>{{$per->date_end}}</td>-->
<!--                    @endif-->
<!--                    <td>{{$timeNow}}</td>-->
<!--                    <td></td>-->
<!--                    <td></td>-->
<!--                    <td></td>-->
<!--                    <td>-->
<!--                        <input type="checkbox" class="form-check-input" id="{{$per->id}}">-->
<!--                    </td>-->
<!--                </tr>-->
<!--                @endforeach-->
                </tbody>
            </table>
            <div style="text-align:center">

            </div>
        </div>
    </div>

</template>
<script>
    export default {
        data(){
            return{
                permission : []
            }
        }
    }
</script>
