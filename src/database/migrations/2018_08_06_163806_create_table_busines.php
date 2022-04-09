<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBusines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('busines', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nome');
                $table->string('nome_fantasia')->nullable();
                $table->string('docs');
                $table->string('telefone');
                $table->string('seguimento');
                $table->string('url_img_busine')->nullable();

                $table->unsignedInteger('busine_configs_id');
                $table->foreign('busine_configs_id')->references('id')->on('busine_configs');
                $table->unsignedInteger('busine_enderecos_id');
                $table->foreign('busine_enderecos_id')->references('id')->on('busine_enderecos');
                $table->unsignedInteger('admin_id');
                $table->foreign('admin_id')->references('id')->on('admins');
                
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
        Schema::dropIfExists('busines');
    }
}
