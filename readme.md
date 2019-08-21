<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Quản lý nhân sự

Tool quản lý nhân sự được viết bằng Laravel framework. Gồm các chức năng chính như:

- Phân quyền: Nhân viên và quản lý nhân sự.

- Nhân viên: 
+ Login.
+ Xin nghỉ phép.
+ Kiểm tra số phép đã được duyệt.
+ Kiểm tra số phép còn lại trong năm.
+ Kiểm tra số ngày công đã làm trong tháng.
+ Kiểm tra tiền lương làm trong tháng.

- Quản lý nhân sự:
+ CRUD nhân viên.
+ Thêm loại hợp đồng của nhân viên.
+ CRUD hợp đồng cho nhân viên.
+ Chấm công theo ngày.
+ Tính lương theo tháng.
+ Kiểm tra đơn xin phép của nhân viên chấp nhận hoặc không.
+ Kiểm tra công nhân viên theo tháng.
+ Hệ thống sẽ tính lương dựa theo setup của lương theo tháng của bảng chấm công.
+ Export ra excel bảng tính lương của nhân viên.



