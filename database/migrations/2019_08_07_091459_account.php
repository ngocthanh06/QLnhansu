<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Account extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('Account', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('name');
            $table->integer('id_role');
            $table->string('address');
            $table->boolean('sex');
            $table->string('info');
            $table->string('image');
            $table->string('username');
            $table->string('password');
            $table->string('passport');
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
        Schema::dropIfExists('Account');
    }
}
