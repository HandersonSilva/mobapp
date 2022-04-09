<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuxPedidoCarrinhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aux_pedido_carrinhos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('carrinho_id');
            $table->unsignedInteger('pedidos_id');

            $table->foreign('carrinho_id')->references('id')->on('carrinhos');
            $table->foreign('pedidos_id')->references('id')->on('pedidos');
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
        Schema::dropIfExists('aux_pedido_carrinhos');
    }
}
