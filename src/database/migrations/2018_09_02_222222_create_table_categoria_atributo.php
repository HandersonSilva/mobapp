<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCategoriaAtributo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria_atributo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome_categ_atrib');
            $table->integer('permite_duplic')->default(0);
            $table->unsignedInteger('busine_id');
            $table->foreign('busine_id')->references('id')->on('busines')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categoria_atributo');
    }
}
