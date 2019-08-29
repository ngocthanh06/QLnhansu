<?php
namespace App\FlashMess;

class FlashMess
{
    public function unsuccessful()
    {
        return "Không thành công!";
    }
    public function AddSuccess()
    {
        return "Thêm thành công!";
    }
    public function EditSuccess()
    {
        return "Sửa thông tin thành công";
    }
    public function constantA()
    {
        return "Thông tin không thay đổi";
    }
    public  function DeleSuccess()
    {
        return "Xóa thành công";
    }
    public function checkday()
    {
        return "Ngày thanh toán không được nhỏ hơn ngày công hiện có";
    }
    public function paySalary()
    {
        return "Thanh toán lương thành công";
    }
    public  function  checklogin()
    {
        return "Sai tên đăng nhập hoặc mật khẩu";
    }
    public  function contractEm()
    {
        return "Nhân viên vẫn còn hợp đồng";
    }
    public function Cancelcontract()
    {
        return "Hợp đồng đã được hủy theo số ngày thành công";
    }
    public  function daymis()
    {
        return "Số ngày kết thúc hợp đồng không được nhỏ hơn ngày bắt đầu";
    }
    public function successA()
    {
        return "Thành công";
    }
}
