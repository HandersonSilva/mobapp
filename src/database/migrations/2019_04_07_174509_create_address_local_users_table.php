<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressLocalUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('address_local_users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('num')->nullable();
            $table->string('rua_long')->nullable();
            $table->string('rua_short')->nullable();
            $table->string('bairro_long')->nullable();
            $table->string('bairro_short')->nullable();
            $table->string('cidade_long')->nullable();
            $table->string('cidade_short')->nullable();
            $table->string('estado_long')->nullable();
            $table->string('estado_short')->nullable();
            $table->string('pais_long')->nullable();
            $table->string('pais_short')->nullable();
            $table->string('cep_long')->nullable();
            $table->string('endereco_format')->nullable();
            $table->string('lat')->default("0.00");
            $table->string('lng')->default("0.00");

            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); //exclui essa chave caso o id do carrinho seja excluido

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address_local_users');
    }
}
