<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('scoutname');
            $table->string('prename');
            $table->string('surname');
            $table->string('name_gen')->unique();
	        $table->integer('fk_role')->unsigned();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->index('fk_role');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
