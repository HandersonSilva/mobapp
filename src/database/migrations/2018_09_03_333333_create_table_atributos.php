<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAtributos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atributos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome_atributo')->nullable(false);
            $table->decimal('valor_atributo', 18, 2)->nullable(false);
            $table->integer('disponibilidade')->default(1);
            $table->integer('qtd_max')->default(1);
            $table->unsignedInteger('produto_id');
            $table->foreign('produto_id')->references('id')->on('produtos');
            $table->unsignedInteger('categoria_atributo_id');
            $table->foreign('categoria_atributo_id')->references('id')->on('categoria_atributo');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atributos');
    }
}
