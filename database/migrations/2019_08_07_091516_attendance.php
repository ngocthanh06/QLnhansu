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
        //
        // Schema::create('timesheets', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->string('name');
        //     $table->integer('day');
        //     $table->integer('permission');
        //     $table->string('num_permission');
        //     $table->timestamps();
        // });
            Schema::create('attendance', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_contract');
            $table->date('day');
            $table->boolean('status');
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
