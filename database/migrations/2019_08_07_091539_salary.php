<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Salary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // CŨ
        // Schema::create('Salary', function (Blueprint $table) {
        //     $table->Increments('id');
        //     $table->integer('id_timesheet');
        //     $table->string('name');
        //     $table->date('salary_day');
        //     $table->integer('num_day');
        //     $table->integer('month');
        //     $table->string('position');
        //     $table->string('reward');
        //     $table->string('allowance');
        //     $table->integer('sum');
        //     $table->date('reviced_date');
        //     $table->timestamps();
        // });


        Schema::create('Salary', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('num_attendance');
            $table->string('position');
            $table->string('reward');
            $table->string('allowance');
            $table->integer('sum_position');//ngày phép
            $table->date('reviced_date');
            $table->integer('num_done');
            $table->integer('id_attent');
            $table->integer('status');
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
        Schema::dropIfExists('Salary');
    }
}
