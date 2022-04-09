<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProdutos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome_prod',60)->nullable(false);
            $table->string('desc_prod')->default(null);
            $table->string('img_prod_url')->nullable(false);
            $table->string('status_promo', 3)->nullable(false);
            $table->decimal('valor_custo', 18, 2)->nullable(false);
            // $table->decimal('valor_promocao', 18, 2)->nullable(true)->default(0);
            $table->decimal('valor_prod', 18, 2)->nullable(false);
            $table->integer('disponibilidade')->default(0);
            $table->string('codigo_barra', 20)->nullable(true);
            $table->integer('estoque')->default(0);
            $table->unsignedInteger('busine_id');
            $table->foreign('busine_id')->references('id')->on('busines');
            $table->unsignedInteger('unidade_id');
            $table->foreign('unidade_id')->references('id')->on('unidades');
            $table->unsignedInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categorias');
            $table->integer('possui_attr');
            $table->integer('qtd_complementos')->default(0);
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
        Schema::dropIfExists('produtos');
    }
}
