<?php

use Illuminate\Database\Seeder;

class CategoriaAtributosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('categoria_atributo')->insert([
            'nome_categ_atrib' => "Complementos"
        ]);
        DB::table('categoria_atributo')->insert([
            'nome_categ_atrib' => "Confets"
        ]);
        DB::table('categoria_atributo')->insert([
            'nome_categ_atrib' => "Coberturas"
        ]);
    }
}
