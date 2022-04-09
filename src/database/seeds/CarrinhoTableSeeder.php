<?php

use App\Models\Carrinho;
use Illuminate\Database\Seeder;

class CarrinhoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //array com todos os parametros do atributo
        $carrinho = [
            "valor_total_prod" =>
            [
                50.00, 35.00, 100, 20.00, 75.50,
            ],

            "faturado" =>
            [
                0, 0, 0, 0, 0,
            ],
            "user_id" => [
                1, 1, 1, 1, 1,
            ],
            "busine_id" => [
                1, 1, 1, 1, 1,
            ],

        ];

        for ($i = 0; $i < count($carrinho["valor_total_prod"]); $i++) {

            $create = [
                "valor_total_prod" => $carrinho["valor_total_prod"][$i],
                "busine_id" => $carrinho["busine_id"][$i],
                "faturado" => $carrinho["faturado"][$i],
                "user_id" => $carrinho["user_id"][$i],
            ];

            //insere atributo no banco
            $carrinho_create = Carrinho::create($create);

        }

    }
}
