<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('email')->unique();
            $table->string("cpf")->default(00000000000);
            $table->string("remember_token", 300)->default(000000000000000);
            $table->string('password');
            $table->string('url_img_perfil')->nullable();
            $table->string('hash_google')->nullable();
            $table->boolean('activate_account')->default(0);
            $table->string('hash_activate')->unique();
            $table->string('telefone');
            $table->integer('distancia')->default(9);
            $table->time('saved_code')->nullable();
            $table->bigInteger('code_expires')->nullable();
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
        Schema::dropIfExists('admins');
    }
}
