<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class account extends Model
{
    //
    protected $table = 'account';
    protected $primaryKey = 'id';
    // public $timestamps = true;
    protected $guarded = [];

    public function getRole(){
        return $this->hasOne('App\Models\role','id','id_role');
    }

   


}
