<?php


namespace App\Repositories\TodoInterfaceWork;


interface SupportInterface
{
    //get time now
    public function getTimeNow();
    //caculate distance the number of 2 day
    public function cal2Day($date_start,$date_end);
}
