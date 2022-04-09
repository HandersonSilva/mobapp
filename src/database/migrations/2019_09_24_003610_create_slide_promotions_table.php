<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slide_promotions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slide_1', 100);
            $table->string('slide_2', 100);
            $table->string('slide_3', 100);
            $table->string('slide_4', 100);
            $table->string('cidade')->nullable()->unique();
            $table->string('cep')->default('00000000');
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
        Schema::dropIfExists('slide_promotions');
    }
}
