    
    $(document).ready(function() {

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });

        /* initialize the external events
         -----------------------------------------------------------------*/


        $('#external-events div.external-event').each(function() {

            // store data so the calendar knows to render an event upon drop
            $(this).data('event', {
                title: $.trim($(this).text()), // use the element's text as the event title
                stick: true // maintain when user navigates (see docs on the renderEvent method)
            });

            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 1111999,
                revert: true, // will cause the event to go back to its
                revertDuration: 0 //  original position after the drag
            });

        });


        /* initialize the calendar
         -----------------------------------------------------------------*/
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar
            drop: function() {
                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }
            },
            events: [{
                    title: 'All Day Event',
                    start: new Date(y, m, 1)
                },
                {
                    title: 'Long Event',
                    start: new Date(y, m, d - 5),
                    end: new Date(y, m, d - 2)
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: new Date(y, m, d - 3, 16, 0),
                    allDay: false
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: new Date(y, m, d + 4, 16, 0),
                    allDay: false
                },
                {
                    title: 'Meeting',
                    start: new Date(y, m, d, 10, 30),
                    allDay: false
                },
                {
                    title: 'Lunch',
                    start: new Date(y, m, d, 12, 0),
                    end: new Date(y, m, d, 14, 0),
                    allDay: false
                },
                {
                    title: 'Birthday Party',
                    start: new Date(y, m, d + 1, 19, 0),
                    end: new Date(y, m, d + 1, 22, 30),
                    allDay: false
                },
                {
                    title: 'Click for Google',
                    start: new Date(y, m, 28),
                    end: new Date(y, m, 29),
                    url: 'http://google.com/'
                }
            ]
        });


    });


  
        //Lịch
        $(function() {
            $('input[name="date_now"]').daterangepicker({
                singleDatePicker: true,
                opens: 'right'
            }, function(start, end, label) {});
        });

    //Lấy hợp đồng
    $(document).ready(function() {
        //alert('Đã chạy được');//Kiểm tra script chạy được chưa
        $("#contract").on('click', function() {
            var idSemester = $(this).val(); //Gọi thể loại để thực hiện thay đổi
            //đang timg bug lỗi
            $.get("{{asset('ajax/getcontract')}}" + '/' + idSemester, function(data) {
                //  
                // console.log(data);
                $('#show').html(data);
                // $('#show1').html(data);
            });
    
            //lấy id của hợp đồng để lấy số ngày làm status 1
            $.get("{{asset('ajax/gethopdong')}}" + '/' + idSemester, function(data) {
    
                $('#show1').html(data);
            });
        });
        
        //Thống kê danh sách chấm công theo tháng
        $('#option3').on('click',function(){
            $.get("{{asset('ajax/getPerMonth')}}", function(data) {
    
                // $('#show1').html(data);
            });
        });

        //Lấy số phép tối đa và hệ số lương
    
        $("#id_type_contract").on('click', function() {
    
            var id = $(this).val();
            if (id == 1) {
                $("#num_max").val(20);
                $('#coefficients').val(3);
                $('#coefficients').attr('disabled', 'disabled');
            } else {
                $("#num_max").val(5);
                $('#coefficients').val(1);
                $('#coefficients').removeAttr('disabled');
            }
    
        });
        //Lấy số công thanh toán còn lại trong salary
        $("#num_done").on('change', function() {
            var num_attend = $('#num_attendance').val();
            var num_done = $('#num_done').val();
            $('#num_aa').val(num_attend - num_done);
            setSalary();
        });
    
        //set lương theo ngày
        $('#salary_day').on('change', function() {
            setSalary();
        });
        //Set thưởng
        $('#reward').on('change', function() {
            setSalary();
        });
        //Set phụ cấp
        $('#position').on('change', function() {
            setSalary();
        });
    
        //Lấy id của tên nhân viên trong modul addContract
        $("#account").on('change', function() {
            var idSemester = $(this).val(); //Gọi thể loại để thực hiện thay đổi
            //đang timg bug lỗi
            $.get("{{asset('ajax/getaddcontract')}}" + '/' + idSemester, function(data) {
                //  
                $('#getAccount').val(data);
                // $('#show1').html(data);
            });
            $.get("{{asset('ajax/getaddDatecontract')}}" + '/' + idSemester, function(data) {
                //  
    
                if (data == 1) {
                    $('#data_2').attr('disabled', 'disabled');
                    $('#data_2').attr('disabled', 'disabled');
                    $('input[name="name_contract"]').attr('disabled', 'disabled');
                    $('#sub').attr('disabled', 'disabled');
                    alert('Hợp đồng nhân viên vẫn còn hạn sử dụng');
                } else {
                    $('#data_2').removeAttr('disabled');
                    $('input[name="name_contract"]').removeAttr('disabled');
                    $('#sub').removeAttr('disabled');
                    $('#start1').val(data);
                }
                // alert('Hợp đồng vẫn còn thời hạn sử dụng');
            });
        });
    
        //   
    
    
    
    
    });
    //Set lương thực lãnh
    function setSalary() {
        var num = $('#num_done').val();
        var sa = $('#salary_day').val();
        var re = $('#reward').val();
        var po = $('#position').val();
        $('#sum_position').val(formatNumber(parseInt(num) * parseInt(sa) + parseInt(re) + parseInt(po), '.', ',') + ' VND');
    }
    
    //Format định dạng tiền VND
    function formatNumber(nStr, decSeperate, groupSeperate) {
        nStr += '';
        x = nStr.split(decSeperate);
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + groupSeperate + '$2');
        }
        return x1 + x2;
    }
    //Thay đổi trạng thái của nút xác nhận
    function checkPermiss1(e) {
        $.get("{{asset('ajax/checkPermiss')}}" + '/' + e.value, function(data) {
            // console.log(data);
            if (data == 1) {
                $('#' + e.id).html("Đã duyệt");
                $('#' + e.id).attr("class", "btn btn-info btn-sm");
            } else {
                $('#' + e.id).html("Chưa xác nhận");
                $('#' + e.id).attr("class", "btn btn-danger btn-sm");
            }
        });
    }
    
    
    function checkedAtt(e) {
        $.get("{{asset('ajax/CreateAddAttend')}}" + "/" + e.value + "/" + e.id, function(data) {
            if (data == 1) {
                $("input[name='check']:checked").prop('checked', false);
                alert('Chưa đến hạn chấm công');
            } else
                window.location.reload(false);
        });
        //    }
    }
    
    function checkonclick(e) {
        if ($("input[type='checkbox']:checked")) {
            $.get("{{asset('ajax/EditAddAttend')}}" + "/" + e.id, function(data) {
                window.location.reload(false); //load lại trang
            });
        } else {
            $.get("{{asset('ajax/EditAddAttend')}}" + "/" + e.id, function(data) {
                window.location.reload(false);
            });
        }
    }
    
    function checkID(e) {
        $.get("{{url(asset('ajax/ShowAttendPermi'))}}" + "/" + e.id, function(data) {
            $('#showw').html(data);
        });
    }
    
    function showPer(e) {
        $.get("{{asset('ajax/ShowAttendContr')}}" + "/" + e.id, function(data) {
            $('#showw').html(data);
        });
    }
    
    
    
    function submitok() {
        var a = $("#lido").val();
        console.log(a);
    }
    
    // CK editor
    if (window.editor) {
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    }
    
    
  
    
    
    
        $(document).ready(function() {
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000
                };
                toastr.success('Responsive Admin Theme', 'Welcome to INSPINIA');
    
            }, 1300);
    
    
            var data1 = [
                [0, 4],
                [1, 8],
                [2, 5],
                [3, 10],
                [4, 4],
                [5, 16],
                [6, 5],
                [7, 11],
                [8, 6],
                [9, 11],
                [10, 30],
                [11, 10],
                [12, 13],
                [13, 4],
                [14, 3],
                [15, 3],
                [16, 6]
            ];
            var data2 = [
                [0, 1],
                [1, 0],
                [2, 2],
                [3, 0],
                [4, 1],
                [5, 3],
                [6, 1],
                [7, 5],
                [8, 2],
                [9, 3],
                [10, 2],
                [11, 1],
                [12, 0],
                [13, 2],
                [14, 8],
                [15, 0],
                [16, 0]
            ];
            $("#flot-dashboard-chart").length && $.plot($("#flot-dashboard-chart"), [
                data1, data2
            ], {
                series: {
                    lines: {
                        show: false,
                        fill: true
                    },
                    splines: {
                        show: true,
                        tension: 0.4,
                        lineWidth: 1,
                        fill: 0.4
                    },
                    points: {
                        radius: 0,
                        show: true
                    },
                    shadowSize: 2
                },
                grid: {
                    hoverable: true,
                    clickable: true,
                    tickColor: "#d5d5d5",
                    borderWidth: 1,
                    color: '#d5d5d5'
                },
                colors: ["#1ab394", "#1C84C6"],
                xaxis: {},
                yaxis: {
                    ticks: 4
                },
                tooltip: false
            });
    
            var doughnutData = [{
                    value: 300,
                    color: "#a3e1d4",
                    highlight: "#1ab394",
                    label: "App"
                },
                {
                    value: 50,
                    color: "#dedede",
                    highlight: "#1ab394",
                    label: "Software"
                },
                {
                    value: 100,
                    color: "#A4CEE8",
                    highlight: "#1ab394",
                    label: "Laptop"
                }
            ];
    
            var doughnutOptions = {
                segmentShowStroke: true,
                segmentStrokeColor: "#fff",
                segmentStrokeWidth: 2,
                percentageInnerCutout: 45, // This is 0 for Pie charts
                animationSteps: 100,
                animationEasing: "easeOutBounce",
                animateRotate: true,
                animateScale: false
            };
    
            // var ctx = document.getElementById("doughnutChart").getContext("2d");
            // var DoughnutChart = new Chart(ctx).Doughnut(doughnutData, doughnutOptions);
    
            var polarData = [{
                    value: 300,
                    color: "#a3e1d4",
                    highlight: "#1ab394",
                    label: "App"
                },
                {
                    value: 140,
                    color: "#dedede",
                    highlight: "#1ab394",
                    label: "Software"
                },
                {
                    value: 200,
                    color: "#A4CEE8",
                    highlight: "#1ab394",
                    label: "Laptop"
                }
            ];
    
            var polarOptions = {
                scaleShowLabelBackdrop: true,
                scaleBackdropColor: "rgba(255,255,255,0.75)",
                scaleBeginAtZero: true,
                scaleBackdropPaddingY: 1,
                scaleBackdropPaddingX: 1,
                scaleShowLine: true,
                segmentShowStroke: true,
                segmentStrokeColor: "#fff",
                segmentStrokeWidth: 2,
                animationSteps: 100,
                animationEasing: "easeOutBounce",
                animateRotate: true,
                animateScale: false
            };
            // var ctx = document.getElementById("polarChart").getContext("2d");
            // var Polarchart = new Chart(ctx).PolarArea(polarData, polarOptions);
    
        }); 
