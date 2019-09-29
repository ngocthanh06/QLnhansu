<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Quản lý nhân sự | Dashboard</title>
    <base href="{{asset('qlns')}}/">
    {{--    vuejs--}}

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- FooTable -->
    <link href="css/plugins/footable/footable.core.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- FooTable -->
    <link href="css/plugins/footable/footable.core.css" rel="stylesheet">
    {{-- DataTable --}}
    <link rel="stylesheet" type="text/css" href="{{asset('qlns/DataTables/datatables.min.css')}}"/>
    {{-- Lịch --}}
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/plugins/fullcalendar/fullcalendar.css" rel="stylesheet">
    <link href="css/plugins/fullcalendar/fullcalendar.print.css" rel='stylesheet' media='print'>
    <!-- Toastr style -->
    <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <!-- Gritter -->
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/ckeditor5/12.3.1/classic/ckeditor.js"></script>
    <link type="text/css" href="{{asset('qlns/timepicker/css/bootstrap.min.css')}}" />
    <link type="text/css" href="{{asset('qlns/timepicker/css/bootstrap-timepicker.min.css')}}" />
    <script type="text/javascript" src="{{asset('qlns/js/jquery-2.1.1.js')}}"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{asset('qlns/timepicker/js/bootstrap-timepicker.min.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                        <img alt="image" class="img-circle" src="img/profile_small.jpg" />
                        </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{Auth::user()->name}}</strong>
                        </span> <span class="text-muted text-xs block">{{$role->name_role}}</span> </span> </a>
                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>
                @if($role->id == 1)
                    <li class="<?php echo isset($open) && $open == 'account' ?'active':'' ?>">
                        <a href="{{asset('admin/user')}}"><i class="fa fa-diamond"></i> <span class="nav-label">Danh sách nhân viên</span></a>
                    </li>
                    <li class="<?php echo isset($open) && $open == 'type_contract' ?'active':'' ?>">
                        <a href="{{asset('admin/type_contract')}}"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Loại hợp đồng</span></span></a>
                    </li>
                    <li class="<?php echo isset($open) && $open == 'contract' ?'active':'' ?>">
                        <a  href="{{asset('admin/contract')}}"><i class="fa fa-envelope"></i> <span class="nav-label">Hợp đồng </span></a>
                    </li>
                    <li>
                        <a class="<?php echo isset($open) && $open == 'GetAttendance' ?'active':'' ?>" href="{{asset('admin/GetAtendance')}}"><i class="fa fa-flask"></i> <span class="nav-label">Bảng lương</span></a>
                    </li>
                    <li class="<?php echo isset($open) && $open == 'Attendance' ?'active':'' ?>">
                        <a href="{{asset('admin/Attendance')}}"><i class="fa fa-pie-chart"></i> <span class="nav-label">Chấm công</span>  </a>
                    </li>
                @else
                    <li class="<?php echo isset($open) && $open == 'home' ?'active':'' ?>">
                        <a href="{{asset('admin/home')}}"><i class="fa fa-th-large"></i> <span class="nav-label">Thông tin</span></span></a>
                    </li>
                    <li class="<?php echo isset($open) && $open == 'permission' ?'active':'' ?>">
                        <a href="{{asset('admin/getPermission')}}"><i class="fa fa-pie-chart"></i> <span class="nav-label">Xin nghỉ phép</span>  </a>
                    </li>
                    <li class="<?php echo isset($open) && $open == 'salaryEm' ?'active':'' ?>">
                        <a href="{{asset('admin/SalaryEmploys')}}"><i class="fa fa-pie-chart"></i> <span class="nav-label">Lương nhân viên</span>  </a>
                    </li>
                    <li class="<?php echo isset($open) && $open == 'changepass' ?'active':'' ?>">
                        <a href="{{asset('admin/changepass')}}"><i class="fa fa-pie-chart"></i> <span class="nav-label">Đổi mật khẩu</span>  </a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    <form role="search" class="navbar-form-custom" action="search_results.html">
                        <div class="form-group">
                            <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                        </div>
                    </form>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <span class="m-r-sm text-muted welcome-message">Quản lý nhân sự.</span>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                        </a>
                        <ul class="dropdown-menu dropdown-messages">
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">
                                        <img alt="image" class="img-circle" src="img/a7.jpg">
                                    </a>
                                    <div class="media-body">
                                        <small class="pull-right">46h ago</small>
                                        <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                        <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">
                                        <img alt="image" class="img-circle" src="img/a4.jpg">
                                    </a>
                                    <div class="media-body ">
                                        <small class="pull-right text-navy">5h ago</small>
                                        <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                        <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">
                                        <img alt="image" class="img-circle" src="img/profile.jpg">
                                    </a>
                                    <div class="media-body ">
                                        <small class="pull-right">23h ago</small>
                                        <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                        <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="text-center link-block">
                                    <a href="mailbox.html">
                                        <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <li>
                                <a href="mailbox.html">
                                    <div>
                                        <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="profile.html">
                                    <div>
                                        <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                        <span class="pull-right text-muted small">12 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="grid_options.html">
                                    <div>
                                        <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="text-center link-block">
                                    <a href="notifications.html">
                                        <strong>See All Alerts</strong>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{asset('logout')}}">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                    <li>
                        <a class="right-sidebar-toggle">
                            <i class="fa fa-tasks"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content">
                    @include('Admin.errors.note')
                    <div class="row">

                        @yield('content')

                    </div>
                </div>
                <div class="footer">
                    <div class="pull-right">
                        10GB of <strong>250GB</strong> Free.
                    </div>
                    <div>
                        <strong>Copyright</strong> Example Company &copy; 2014-2015
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Mainly scripts -->
<script src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- FooTable -->
<script src="js/plugins/footable/footable.all.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<!-- Flot -->
<script src="js/plugins/flot/jquery.flot.js"></script>
<script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="js/plugins/flot/jquery.flot.spline.js"></script>
<script src="js/plugins/flot/jquery.flot.resize.js"></script>
<script src="js/plugins/flot/jquery.flot.pie.js"></script>
<!-- Peity -->
<script src="js/plugins/peity/jquery.peity.min.js"></script>
<script src="js/demo/peity-demo.js"></script>
<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>
<!-- jQuery UI -->
<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- GITTER -->
<script src="js/plugins/gritter/jquery.gritter.min.js"></script>
<!-- Sparkline -->
<script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- Sparkline demo data  -->
<script src="js/demo/sparkline-demo.js"></script>
<!-- ChartJS-->
<script src="js/plugins/chartJs/Chart.min.js"></script>
<!-- Toastr -->
<script src="js/plugins/toastr/toastr.min.js"></script>
{{-- Lịch --}}
<script src="js/plugins/fullcalendar/moment.min.js"></script>
<!-- jQuery UI custom -->
<script src="js/jquery-ui.custom.min.js"></script>
<!-- iCheck -->
<script src="js/plugins/iCheck/icheck.min.js"></script>
<!-- Full Calendar -->
<script src="js/plugins/fullcalendar/fullcalendar.min.js"></script>
<!-- Date range picker -->
<script src="js/plugins/daterangepicker/daterangepicker.js"></script>
{{-- Lịch --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
{{-- DataTable --}}
<script type="text/javascript" src="{{asset('qlns/DataTables/datatables.min.js')}}"></script>
<!-- FooTable -->
<script src="js/plugins/footable/footable.all.min.js"></script>

@include('Admin.ScriptEvent');
</body>
</html>
