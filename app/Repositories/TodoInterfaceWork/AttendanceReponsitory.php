<?php


namespace App\Repositories\TodoInterfaceWork;


interface AttendanceReponsitory
{
    //get all
    public function getAll();
    //get info with id
    public function getByid($id);
    //create
    public function create(array $attributes);
    //update
    public function update($id,array $atributes);
    //delete
    public function delete($id);
    //list month Attendance
    public function allMonthAttendance();
    //Get list attendance with id_contract with three
    public function listAttendanceWithIdContract($id);


}
