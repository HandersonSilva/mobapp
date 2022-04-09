<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusineConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('busine_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status_busine')->default(0);//0 = inativa no app
            $table->integer('status_openCloser')->default(0);//0 = a fechado
            $table->decimal('valor_frete', 18, 2)->nullable(false)->default(0.00);//frete não informado
            $table->decimal('valor_atrr_excedido', 18, 2)->nullable(false)->default(0.00);
            $table->integer('fideliza_cliente')->default(0);//1 = fideliza
            $table->integer('delivery_time');
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
        Schema::dropIfExists('busine_configs');
    }
}
