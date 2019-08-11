<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Contract extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('contract', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('id_type_contract');
            $table->string('name');
            $table->date('date_start');
            $table->date('date_end');
            $table->string('content');
            $table->integer('id_account');
            $table->integer('num_work');
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
        Schema::dropIfExists('contract');
    }
}
