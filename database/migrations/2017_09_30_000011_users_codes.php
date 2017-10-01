<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersCodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('users_codes', function (Blueprint $table) {
		    $table->increments('id')->unsigned();
		    $table->integer('fk_users')->unsigned();
		    $table->integer('fk_game_codes')->unsigned();

		    $table->index('fk_users');
		    $table->index('fk_game_codes');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::dropIfExists('users_codes');
    }
}
