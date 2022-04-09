<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttrCarrinhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attr_carrinhos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('aux_carrinho_id');
            $table->foreign('aux_carrinho_id')->references('id')->on('aux_carrinho_produtos')->onDelete('cascade'); //exclui essa chave caso o id do carrinho seja excluido
            $table->unsignedInteger('atributo_id');
            $table->foreign('atributo_id')->references('id')->on('atributos')->onDelete('cascade');
            $table->integer('atributo_qtd')->default(0);
           
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attr_carrinhos');
    }
}
