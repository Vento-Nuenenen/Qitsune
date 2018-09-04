<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsCo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('us2co', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('FK_CODES')->unsigned()->index();
            $table->integer('FK_USERS')->unsigned()->index();
            $table->timestamps();

            $table->foreign('FK_CODES')->references('id')->on('codes')->onDelete('cascade');
            $table->foreign('FK_USERS')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('us2co');
    }
}
