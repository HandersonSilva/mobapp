<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorarioBusinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horario_busines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dia')->nullable(false);
            $table->string('inicio')->nullable(false);
            $table->string('fechamento')->nullable(false);
            $table->string('obs')->nullable();
            $table->integer('status')->default(0); //0 = a fechado nesse dia

            $table->unsignedInteger('busines_id');
            $table->foreign('busines_id')->references('id')->on('busines');
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
        Schema::dropIfExists('horario_busines');
    }
}
