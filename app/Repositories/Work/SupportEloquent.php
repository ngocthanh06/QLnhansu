<?php


namespace App\Repositories\Work;


use App\Repositories\TodoInterfaceWork\SupportInterface;
use Carbon\Carbon;

class SupportEloquent implements SupportInterface
{
    public function getTimeNow()
    {
        return date('d-m-Y', strtotime(Carbon::now()->toDateString()));
    }
    //caculate distance the number of 2 day
    public function cal2Day($date_start,$date_end){
        $data = (strtotime($date_end) - strtotime($date_start))/ (60 * 60 * 24);
        return $data;
    }
}
