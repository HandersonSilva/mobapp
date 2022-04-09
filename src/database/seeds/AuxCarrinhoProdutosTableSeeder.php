<?php
use App\Models\Aux_carrinho_produto;
use Illuminate\Database\Seeder;

class AuxCarrinhoProdutosTableSeeder extends Seeder
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
            "qtd_produto" =>
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
            "produto_id" => [
                4, 2, 7,
            ],

        ];

        $atributos = [ //lista contendo os ids referente aos atributos do produtos adicionados no carrinho
            "atributos" =>
            [
                1, 2, 3, 4, 5,
            ],
        ];

        for ($i = 0; $i < count($aux_carrinho["qtd_produto"]); $i++) {

            $create = [
                "qtd_produto" => $aux_carrinho["qtd_produto"][$i],
                "valor_total_prod" => $aux_carrinho["valor_total_prod"][$i],
                "produto_id" => $aux_carrinho["produto_id"][$i],
                "carrinho_id" => $aux_carrinho["carrinho_id"][$i],
            ];

            $aux_carrinho_create = Aux_carrinho_produto::create($create);

            if ($aux_carrinho_create) {
                if ($aux_carrinho_create->produto_id == 7) {
                    for ($j = 0; $j < count($atributos["atributos"]); $j++) {
                        DB::table('attr_carrinhos')->insert([
                            "aux_carrinho_id" => $aux_carrinho_create->id,
                            "atributo_id" => $atributos["atributos"][$j],
                        ]);
                    }
                }
            }
        }
    }
}
