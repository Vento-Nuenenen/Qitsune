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
        Schema::table('users_codes', function (Blueprint $table) {
            $table->foreign('fk_users')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('fk_game_codes')->references('id')->on('game_codes')->onDelete('cascade');
        });
    }
}
