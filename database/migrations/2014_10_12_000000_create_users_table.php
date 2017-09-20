<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
<<<<<<< HEAD
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
=======
            $table->increments('id')->unsigned();
            $table->integer('total_points')->nullable();
            $table->integer('rank')->nullable();
            $table->string('scoutname');
            $table->string('prename');
            $table->string('surname');
            $table->string('name_gen')->unique();
            $table->integer('fk_role')->unsigned()->default(1);
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->index('fk_role');
>>>>>>> 7438213845ceba112fcc6f2cc51850bb38b0d39b
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
