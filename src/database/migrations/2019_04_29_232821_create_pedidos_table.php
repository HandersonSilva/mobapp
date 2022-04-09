<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('pedidos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo')->default("00000");
            $table->string('name_empresa');
            $table->date('date_inicio');
            $table->date('date_fim')->nullable();
            $table->time('hora_inicio');
            $table->time('hora_fim')->nullable();
            $table->string('status')->default("Aguardando o aceite");
            $table->string('status_cancelado')->default('N'); //N ou S
            $table->time('hora_cancelamento')->nullable();
            $table->string('motivo_cancelamento')->nullable();
            $table->string('endereco');
            $table->unsignedInteger('busines_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('formas_id');

            $table->foreign('busines_id')->references('id')->on('busines')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('formas_id')->references('id')->on('formas_pagamentos')->onDelete('cascade');
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
        Schema::dropIfExists('pedidos');
    }
}
