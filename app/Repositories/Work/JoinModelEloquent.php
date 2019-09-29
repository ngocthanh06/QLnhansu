<?php


namespace App\Repositories\Work;
use App\Models\attendance;
use Carbon\Carbon;
use DB;

use App\Repositories\TodoInterfaceWork\JoinModelReponsitory;

class JoinModelEloquent implements JoinModelReponsitory
{

    public function getlistAttendaceWithDate($date)
    {
//        return DB::table('attendance')->join('contract', 'attendance.id_contract','contract.id')
//            ->join('account','account.id', 'contract.id_account')
//            ->where('account.id_role',2)
//            ->whereNull('contract.date_end')->where('attendance.day', $date)->get();
        return \Illuminate\Support\Facades\DB::table('account')
            ->leftJoin('contract','contract.id_account','account.id')
            ->where('account.id_role',2)
            ->leftJoin('attendance','attendance.id_contract','contract.id')
            ->where('attendance.day',$date)
            ->whereNull('contract.date_end')->paginate(10);
    }

    public function getlistAttendaceWithDateTwo($date){
        //Get list account with contract
        $value = \Illuminate\Support\Facades\DB::table('account')
            ->Join('contract', 'contract.id_account', 'account.id')
            ->where('account.id_role', 2)
            ->whereNull('contract.date_end')
            ->groupBy('account.id')
            ->get();
        //Check value data id account isset day attendance now
        foreach($date as $da){
            foreach($value as $val=>$key){
                if($da->id_account == $key->id_account ){
                    //Delete value in array
                    unset($value[$val]);
                }
            }
        }
        return $value;
    }


}
