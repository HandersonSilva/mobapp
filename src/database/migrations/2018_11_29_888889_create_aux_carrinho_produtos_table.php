<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuxCarrinhoProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aux_carrinho_produtos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('qtd_produto');
            $table->decimal('valor_total_prod', 18, 2)->nullable(false);
            $table->integer('promocao'); //1 = é promoçao
            $table->string('obs_pedido');
            $table->string('unique_cart_hash');
            $table->unsignedInteger('produto_id');
            $table->unsignedInteger('carrinho_id');
            $table->foreign('carrinho_id')->references('id')->on('carrinhos')->onDelete('cascade');
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');
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
        Schema::dropIfExists('aux_pedido_aux_carrinho_produtos');
    }
}
