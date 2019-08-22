<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Permission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('Permission', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('id_contract');
            $table->date('date_start');
            $table->date('date_end');
            $table->string('reason');//lí do
            $table->integer('num_date_end');
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
        Schema::dropIfExists('daPermission');
    }
}
