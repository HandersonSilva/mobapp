<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePromocoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promocoes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_promocao')->nullable(false)->changed();
            $table->string('decricao_promocao')->nullable(false)->changed();
            $table->decimal('valor_total', 18, 2)->nullable(false)->changed();
            $table->decimal('valor_total_produto', 18, 2)->nullable(true)->changed();
            $table->integer('estoque_promocao')->default(0);
            $table->integer('ativo')->default(0);
            $table->string('urlImg_promocao');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promocoes');
    }
}
