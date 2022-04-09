<?php

use App\Models\Aux_carrinho_promocao;
use Illuminate\Database\Seeder;

class AuxCarrinhoPromocaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $aux_carrinho = [
            "qtd_promocao" =>
            [
                2, 1, 3,
            ],
            "valor_total_prod" =>
            [
                20.00, 14.50, 3.30,
            ],

            "carrinho_id" =>
            [
                1, 1, 1,
            ],
            "promocao_id" => [
                1, 2, 2,
            ],

        ];

        for ($i = 0; $i < count($aux_carrinho["qtd_promocao"]); $i++) {

            $create = [
                "qtd_promocao" => $aux_carrinho["qtd_promocao"][$i],
                "valor_total_prod" => $aux_carrinho["valor_total_prod"][$i],
                "promocao_id" => $aux_carrinho["promocao_id"][$i],
                "carrinho_id" => $aux_carrinho["carrinho_id"][$i],
            ];

            $aux_carrinho_create = Aux_carrinho_promocao::create($create);
        }
    }
}
