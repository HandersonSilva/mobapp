<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormasPagamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('formas_pagamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('total')->default(0.00);
            $table->decimal('desconto')->nullable();
            $table->decimal('liquido')->nullable();
            $table->string('name');
            $table->string('form_payment_code');
            $table->string('number_installments')->nullable();
            $table->integer('installment')->default(0);
            $table->string('card_name')->nullable();
            $table->string('card_number')->nullable();
            $table->string('card_flag')->nullable();
            $table->integer('need_transshipment')->default(0);
            $table->decimal('amount_transshipment', 18, 2)->nullable();
            $table->decimal('get_transshipment', 18, 2)->nullable();
            $table->string('transaction_id')->nullable();
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
        Schema::dropIfExists('formas_pagamentos');
    }
}
