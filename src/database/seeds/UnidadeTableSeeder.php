<?php

use Illuminate\Database\Seeder;

class UnidadeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('unidades')->insert([
            'sigla' => "UND",
            'nome' => "Unidade",
            'busine_id'=>6
        ]);
        DB::table('unidades')->insert([
            'sigla' => "LT",
            'nome' => "Litro",
            'busine_id'=>6
        ]);
        DB::table('unidades')->insert([
            'sigla' => "PAC",
            'nome' => "Pacote",
            'busine_id'=>6
        ]);
      
    }
}
