<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUnidadeAtributo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidade_atributo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('atributo')->nullable(false)->changed();
            $table->unsignedInteger('fk_atributos');
            $table->foreign('fk_atributos')->references('id')->on('atributos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unidade_atributo');
    }
}
