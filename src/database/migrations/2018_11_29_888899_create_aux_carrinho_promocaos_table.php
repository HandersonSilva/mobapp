<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuxCarrinhoPromocaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aux_carrinho_promocaos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('qtd_promocao');
            $table->decimal('valor_total_prod', 18, 2)->nullable(false);
            $table->integer('promocao'); //1 = é promoçao
            $table->string('obs_pedido');
            $table->string('unique_cart_hash')->nullable();
            $table->unsignedInteger('promocao_id');
            $table->unsignedInteger('carrinho_id');

            $table->foreign('carrinho_id')->references('id')->on('carrinhos')->onDelete('cascade');
            $table->foreign('promocao_id')->references('id')->on('promocoes')->onDelete('cascade');
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
        Schema::dropIfExists('aux_pedido_aux_carrinho_promocaos');
    }
}
