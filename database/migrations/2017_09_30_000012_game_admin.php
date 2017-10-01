<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GameAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('game_admin', function (Blueprint $table) {
		    $table->increments('id');
		    $table->dateTime('start_time')->nullable();
		    $table->dateTime('endtime')->nullable();
		    $table->integer('code_numbers');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::dropIfExists('game_admin');
    }
}
