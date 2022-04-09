<?php

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //'nome_categ'

        //DB::table('categorias')->truncate();
        //$faker = Faker::create();

        /* foreach(range(1,10) as $i){
        DB::table('categorias')->insert([
        'nome_categ' => $faker->name()
        ]);
        }*/

        $data = [
            "busine_id" => [
                1, 1, 1, 2, 2, 2, 3, 3, 3, 4, 4, 4, 5, 5, 5, 6, 6, 6,
            ],
            "nome_categ" => [
                'Pizza',
                'Petiscos',
                'Açaí',
                'Pizza',
                'Petiscos',
                'Açaí',
                'Pizza',
                'Petiscos',
                'Açaí',
                'Pizza',
                'Petiscos',
                'Açaí',
                'Pizza',
                'Petiscos',
                'Açaí',
                'Pizza',
                'Petiscos',
                'Açaí',
            ],

        ];
        for ($i = 0; $i < count($data["nome_categ"]); $i++):

            //cria um array para cada atributo
            $create = [
                "busine_id" => $data["busine_id"][$i],
                "nome_categ" => $data["nome_categ"][$i],
            ];

            //insere atributo no banco
            Categoria::create($create);

        endfor;
    }
}
