<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Attendance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

            Schema::create('attendance', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_contract');
            $table->integer('permission');
            $table->date('day');
            $table->boolean('status');
            $table->time('checkin');
            $table->time('checkout');
            $table->timestamps();
         });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('attendance');
    }
}
