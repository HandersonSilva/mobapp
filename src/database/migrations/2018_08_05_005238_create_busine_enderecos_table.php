<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusineEnderecosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('busine_enderecos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cidade');
            $table->string('bairro');
            $table->string('rua');
            $table->string('cep');
            $table->string('numero');
            $table->string('lat_empresa');
            $table->string('log_empresa');
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
        Schema::dropIfExists('busine_enderecos');
    }
}
