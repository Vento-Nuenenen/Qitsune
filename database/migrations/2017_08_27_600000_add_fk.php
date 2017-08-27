<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
<<<<<<< HEAD:database/migrations/2017_08_27_600000_add_fk.php
	    Schema::table('users_codes',function(Blueprint $table){
		    $table->foreign('fk_users')->references('id')->on('users');
		    $table->foreign('fk_game_codes')->references('id')->on('game_codes');
	    });
=======
        Schema::table('users_codes', function (Blueprint $table) {
            $table->foreign('fk_users')->references('id')->on('users');
            $table->foreign('fk_game_codes')->references('id')->on('game_codes');
        });
    }
>>>>>>> 4198d22b911a4e33da63b0312e71fcb7bb32cb23:database/migrations/2017_08_27_140314_add_fk.php

	    Schema::table('users',function(Blueprint $table){
		    $table->foreign('fk_role')->references('id')->on('role');
	    });
    }
}
