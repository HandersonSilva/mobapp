<?php

use Illuminate\Database\Seeder;

class PromocoesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('promocoes')->insert([
            'title_promocao' => "Quarta da Pizza",
            'decricao_promocao' => "Pague uma e leve 5 pizza",
            'valor_total' => "67.00",
            'urlImg_promocao' => "pizza.jpg",
        ]);

        DB::table('promocoes')->insert([
            'title_promocao' => "Combo Petisco Feliz",
            'decricao_promocao' => "Pague uma e leve uma coca cola 2l",
            'valor_total' => "35.00",
            'urlImg_promocao' => "petisco.jpg",
        ]);

        DB::table('promocoes')->insert([
            'title_promocao' => "Açai 500ml",
            'decricao_promocao' => "Pague 500ml e leve 1l",
            'valor_total' => "4.50",
            'urlImg_promocao' => "acai.jpg",
        ]);

    }
}
