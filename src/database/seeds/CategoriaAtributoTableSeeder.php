<?php

use App\Models\CategoriaAtributo;
use Illuminate\Database\Seeder;

class CategoriaAtributoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorias = [
            'nome_categ_atrib' =>
            [
                "ingredientes",
                "Frutas",
                "Confetes",
                "Cereais/Grãos",
            ],
            "permite_duplic" =>
            [
                1, 0, 0, 0,
            ],
            "busine_id" => [
                4, 4, 4, 4,
            ],
        ];

        for ($i = 0; $i < 6; $i++) {
            for ($j = 0; $j < count($categorias['nome_categ_atrib']); $j++):
                $data = [
                    "nome_categ_atrib" => $categorias['nome_categ_atrib'][$j],
                    "permite_duplic" => $categorias['permite_duplic'][$j],
                    "busine_id" => $i + 1,
                ];

                CategoriaAtributo::create($data);

            endfor;

        }

    }
}
