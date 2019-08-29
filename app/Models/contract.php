<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
class contract extends Model
{
    //
    protected $table = 'contract';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['username','date_now'];

    protected $fillable = [];


    public function getPermi()
    {
        return $this->hasOne('App\Models\salary','id','id_salary');
    }
    //Account and attendance first
    public function getAccount($id){
        return DB::table('account')->select('contract.id','account.name','account.id_role','account.address','contract.name_contract','contract.date_start','contract.date_end','contract.content','contract.id_account','contract.num_work','contract.num_max','contract.coefficients','contract.id_salary','role.name_role','type_contract.name_type')->join('contract','account.id','contract.id_account')->join('role','account.id_role','role.id')->join('type_contract','type_contract.id','contract.id_type_contract')->where('contract.id',$id)->first();
    }
    //Get contract
    public function getContr($id){
        return DB::table('account')->select('contract.id','type_contract.name_type','contract.date_end','contract.date_start','contract.name_contract')->join('contract','contract.id_account','account.id')->join('type_contract','type_contract.id','contract.id_type_contract')->where('account.id',$id)->get();
    }
    //Attendance
    public function checkAttend(){
        // $data = DB::table('contract')->join('attendance','attendance.id_contract','contract.id')->where('attendance.id_contract',$id)->get();
        // return $data;
        return $this->hasMany('App\Models\attendance','id_contract','id');
    }
    //Ajax controller
    //Get num day with status =1 and permission =1
    public function getStatus(){
        return $this->hasMany('App\Models\attendance','id_contract','id')->where('status','1')->where('permission','1');
    }
    //Get workdays with status =1 and phép =0
    public function getWorked(){
        return $this->hasMany('App\Models\attendance','id_contract','id')->where('status','1')->where('permission','0');
    }
    //get workdays with status = 0 and phép 0
    public function getAttend(){
        return $this->hasMany('App\Models\attendance','id_contract','id')->where('status','0')->where('permission','0');
    }
    //get workdays with status = 0 and phép 1
    public function getAtt(){
        return $this->hasMany('App\Models\attendance','id_contract','id')->where('status','0')->where('permission','1');
    }
    //Sum day off status = 0
    public function get_pre_pre(){
        return $this->hasMany('App\Models\attendance','id_contract','id')->where('status','0');
    }
    //check the contract infomation is there a deadline
    public function checkContract($id){
        $check = DB::table('contract')->join('account','account.id','contract.id_account')->where('account.id',$id)->get();
        // dd($check);
        $now = Carbon::parse(Carbon::now())->format('Y-m-d');
        $day = '';
        $max = 0;
        foreach($check as $che)
        {
            //check day end is null ?
            if($che->date_end == null)
            return 1;
            else{
        //check get day max
           $value = (strtotime($che->date_end) - strtotime($now))/ (60 * 60 * 24);
           $value > $max ? $day = $che->date_end and $max = $value : $day;
            }
        }

        return $day;
    }



}
