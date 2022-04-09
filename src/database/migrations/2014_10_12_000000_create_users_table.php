<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     * 
     *
     * @return void
     */
    public function up()
    {
       Schema::create('users',function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('code_expires')->nullable();
            $table->string('nome');
            $table->string('email')->unique();
            $table->string("cpf")->unique();
            $table->string('password');
            $table->string('url_img_perfil')->nullable();
            $table->string('hash_google')->nullable();
            $table->boolean('activate_account')->default(0);
            $table->string('telefone');
            $table->integer('distancia')->default(9);
            $table->time('saved_code')->nullable();
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
        Schema::dropIfExists('users');
    }
}
