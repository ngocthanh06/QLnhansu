<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class days extends Model
{
    //
    protected $table = 'days';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function getdays(){
        return $this->hasOne('App\Models\timesheets','id_sheet','id');
    }
}
