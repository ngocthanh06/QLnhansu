<?php


namespace App\Repositories\Work;

use DB;
use App\Models\attendance;
use App\Repositories\TodoInterfaceWork\AttendanceReponsitory;

class AttendanceEloquent implements AttendanceReponsitory
{

    public function getAll()
    {
        return attendance::all();
    }

    public function getByid($id)
    {
        return attendance::find($id);
    }

    public function create(array $attributes)
    {
        return attendance::create($attributes);
    }

    public function update($id, array $atributes)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }
    //Get all month of Attendance
    public function allMonthAttendance(){
        return attendance::groupBy(DB::raw('Month(day)'))->get();
    }

    //Get list attendance with id_contrac
    public function listAttendanceWithIdContract($id){
        return attendance::where('id_contract',$id)->get();
    }
    //Get list attendance join contract join account with date
    public function getlistAttendaceWithDate($date){

    }

}
