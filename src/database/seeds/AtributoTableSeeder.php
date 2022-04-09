<?php

use App\Models\Atributo;
use Illuminate\Database\Seeder;

class AtributoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //criando atributos
        //array com todos os parametros do atributo
        $data = [
            "nome_atributo" =>
            [ //empresa 1
                "Bis Black *NOVO*", "Chocolate Granulado", "Leite em Pó", "Paçoca",
                "Abacaxi", "Kiwi", "Banana", "Manga", "Melão",
                "Confete de chocolate", "M&M", "Confete de morango",
                "Aveia", "Chia", "Girassol", "Farinha láctea",

                "Bis Black *NOVO*", "Chocolate Granulado", "Leite em Pó", "Paçoca",
                "Abacaxi", "Kiwi", "Banana", "Manga", "Melão",
                "Confete de chocolate", "M&M", "Confete de morango",
                "Aveia", "Chia", "Girassol", "Farinha láctea",

                "Bis Black *NOVO*", "Chocolate Granulado", "Leite em Pó", "Paçoca",
                "Abacaxi", "Kiwi", "Banana", "Manga", "Melão",
                "Confete de chocolate", "M&M", "Confete de morango",
                "Aveia", "Chia", "Girassol", "Farinha láctea",

                //empresa 2
                "Bis Black *NOVO*", "Chocolate Granulado", "Leite em Pó", "Paçoca",
                "Abacaxi", "Kiwi", "Banana", "Manga", "Melão",
                "Confete de chocolate", "M&M", "Confete de morango",
                "Aveia", "Chia", "Girassol", "Farinha láctea",

                "Bis Black *NOVO*", "Chocolate Granulado", "Leite em Pó", "Paçoca",
                "Abacaxi", "Kiwi", "Banana", "Manga", "Melão",
                "Confete de chocolate", "M&M", "Confete de morango",
                "Aveia", "Chia", "Girassol", "Farinha láctea",

                "Bis Black *NOVO*", "Chocolate Granulado", "Leite em Pó", "Paçoca",
                "Abacaxi", "Kiwi", "Banana", "Manga", "Melão",
                "Confete de chocolate", "M&M", "Confete de morango",
                "Aveia", "Chia", "Girassol", "Farinha láctea",

                //empresa 3
                "Bis Black *NOVO*", "Chocolate Granulado", "Leite em Pó", "Paçoca",
                "Abacaxi", "Kiwi", "Banana", "Manga", "Melão",
                "Confete de chocolate", "M&M", "Confete de morango",
                "Aveia", "Chia", "Girassol", "Farinha láctea",

                "Bis Black *NOVO*", "Chocolate Granulado", "Leite em Pó", "Paçoca",
                "Abacaxi", "Kiwi", "Banana", "Manga", "Melão",
                "Confete de chocolate", "M&M", "Confete de morango",
                "Aveia", "Chia", "Girassol", "Farinha láctea",

                "Bis Black *NOVO*", "Chocolate Granulado", "Leite em Pó", "Paçoca",
                "Abacaxi", "Kiwi", "Banana", "Manga", "Melão",
                "Confete de chocolate", "M&M", "Confete de morango",
                "Aveia", "Chia", "Girassol", "Farinha láctea",

                //empresa 4
                "Bis Black *NOVO*", "Chocolate Granulado", "Leite em Pó", "Paçoca",
                "Abacaxi", "Kiwi", "Banana", "Manga", "Melão",
                "Confete de chocolate", "M&M", "Confete de morango",
                "Aveia", "Chia", "Girassol", "Farinha láctea",

                "Bis Black *NOVO*", "Chocolate Granulado", "Leite em Pó", "Paçoca",
                "Abacaxi", "Kiwi", "Banana", "Manga", "Melão",
                "Confete de chocolate", "M&M", "Confete de morango",
                "Aveia", "Chia", "Girassol", "Farinha láctea",

                "Bis Black *NOVO*", "Chocolate Granulado", "Leite em Pó", "Paçoca",
                "Abacaxi", "Kiwi", "Banana", "Manga", "Melão",
                "Confete de chocolate", "M&M", "Confete de morango",
                "Aveia", "Chia", "Girassol", "Farinha láctea",

                //empresa 5
                "Bis Black *NOVO*", "Chocolate Granulado", "Leite em Pó", "Paçoca",
                "Abacaxi", "Kiwi", "Banana", "Manga", "Melão",
                "Confete de chocolate", "M&M", "Confete de morango",
                "Aveia", "Chia", "Girassol", "Farinha láctea",

                "Bis Black *NOVO*", "Chocolate Granulado", "Leite em Pó", "Paçoca",
                "Abacaxi", "Kiwi", "Banana", "Manga", "Melão",
                "Confete de chocolate", "M&M", "Confete de morango",
                "Aveia", "Chia", "Girassol", "Farinha láctea",

                "Bis Black *NOVO*", "Chocolate Granulado", "Leite em Pó", "Paçoca",
                "Abacaxi", "Kiwi", "Banana", "Manga", "Melão",
                "Confete de chocolate", "M&M", "Confete de morango",
                "Aveia", "Chia", "Girassol", "Farinha láctea",

                //empresa 6
                "Bis Black *NOVO*", "Chocolate Granulado", "Leite em Pó", "Paçoca",
                "Abacaxi", "Kiwi", "Banana", "Manga", "Melão",
                "Confete de chocolate", "M&M", "Confete de morango",
                "Aveia", "Chia", "Girassol", "Farinha láctea",

                "Bis Black *NOVO*", "Chocolate Granulado", "Leite em Pó", "Paçoca",
                "Abacaxi", "Kiwi", "Banana", "Manga", "Melão",
                "Confete de chocolate", "M&M", "Confete de morango",
                "Aveia", "Chia", "Girassol", "Farinha láctea",

                "Bis Black *NOVO*", "Chocolate Granulado", "Leite em Pó", "Paçoca",
                "Abacaxi", "Kiwi", "Banana", "Manga", "Melão",
                "Confete de chocolate", "M&M", "Confete de morango",
                "Aveia", "Chia", "Girassol", "Farinha láctea",

            ],

            "valor_atributo" =>
            [
                //empresa 1
                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,
                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,

                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,
                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,

                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,
                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,

                //empresa 2
                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,
                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,

                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,
                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,

                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,
                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,

                //empresa 3
                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,
                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,

                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,
                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,

                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,
                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,

                //empresa 4
                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,
                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,

                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,
                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,

                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,
                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,

                //empresa 5
                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,
                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,

                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,
                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,

                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,
                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,

                //empresa 6
                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,
                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,

                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,
                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,

                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,
                1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00,

            ],

            "produto_id" =>
            [ //empresa 1

                7, 7, 7, 7, 7, 7, 7, 7,
                7, 7, 7, 7, 7, 7, 7, 7,

                8, 8, 8, 8, 8, 8, 8, 8,
                8, 8, 8, 8, 8, 8, 8, 8,

                9, 9, 9, 9, 9, 9, 9, 9,
                9, 9, 9, 9, 9, 9, 9, 9,

                //empresa 2
                16, 16, 16, 16, 16, 16, 16, 16,
                16, 16, 16, 16, 16, 16, 16, 16,

                17, 17, 17, 17, 17, 17, 17, 17,
                17, 17, 17, 17, 17, 17, 17, 17,

                18, 18, 18, 18, 18, 18, 18, 18,
                18, 18, 18, 18, 18, 18, 18, 18,

                //empresa 3
                25, 25, 25, 25, 25, 25, 25, 25,
                25, 25, 25, 25, 25, 25, 25, 25,

                26, 26, 26, 26, 26, 26, 26, 26,
                26, 26, 26, 26, 26, 26, 26, 26,

                27, 27, 27, 27, 27, 27, 27, 27,
                27, 27, 27, 27, 27, 27, 27, 27,

                //empresa 4
                34, 34, 34, 34, 34, 34, 34, 34,
                34, 34, 34, 34, 34, 34, 34, 34,

                35, 35, 35, 35, 35, 35, 35, 35,
                35, 35, 35, 35, 35, 35, 35, 35,

                36, 36, 36, 36, 36, 36, 36, 36,
                36, 36, 36, 36, 36, 36, 36, 36,

                //empresa 5
                43, 43, 43, 43, 43, 43, 43, 43,
                43, 43, 43, 43, 43, 43, 43, 43,

                44, 44, 44, 44, 44, 44, 44, 44,
                44, 44, 44, 44, 44, 44, 44, 44,

                45, 45, 45, 45, 45, 45, 45, 45,
                45, 45, 45, 45, 45, 45, 45, 45,

                //empresa 6
                52, 52, 52, 52, 52, 52, 52, 52,
                52, 52, 52, 52, 52, 52, 52, 52,

                53, 53, 53, 53, 53, 53, 53, 53,
                53, 53, 53, 53, 53, 53, 53, 53,

                54, 54, 54, 54, 54, 54, 54, 54,
                54, 54, 54, 54, 54, 54, 54, 54,

            ],
            "categoria_atributo_id" =>
            [
                //empresa 1
                1, 1, 1, 1,
                2, 2, 2, 2, 2,
                3, 3, 3,
                4, 4, 4, 4,

                1, 1, 1, 1,
                2, 2, 2, 2, 2,
                3, 3, 3,
                4, 4, 4, 4,

                1, 1, 1, 1,
                2, 2, 2, 2, 2,
                3, 3, 3,
                4, 4, 4, 4,

                //empresa 2
                1, 1, 1, 1,
                2, 2, 2, 2, 2,
                3, 3, 3,
                4, 4, 4, 4,

                1, 1, 1, 1,
                2, 2, 2, 2, 2,
                3, 3, 3,
                4, 4, 4, 4,

                1, 1, 1, 1,
                2, 2, 2, 2, 2,
                3, 3, 3,
                4, 4, 4, 4,

                //empresa 3
                1, 1, 1, 1,
                2, 2, 2, 2, 2,
                3, 3, 3,
                4, 4, 4, 4,

                1, 1, 1, 1,
                2, 2, 2, 2, 2,
                3, 3, 3,
                4, 4, 4, 4,

                1, 1, 1, 1,
                2, 2, 2, 2, 2,
                3, 3, 3,
                4, 4, 4, 4,

                //empresa 4
                1, 1, 1, 1,
                2, 2, 2, 2, 2,
                3, 3, 3,
                4, 4, 4, 4,

                1, 1, 1, 1,
                2, 2, 2, 2, 2,
                3, 3, 3,
                4, 4, 4, 4,

                1, 1, 1, 1,
                2, 2, 2, 2, 2,
                3, 3, 3,
                4, 4, 4, 4,

                //empresa 5
                1, 1, 1, 1,
                2, 2, 2, 2, 2,
                3, 3, 3,
                4, 4, 4, 4,

                1, 1, 1, 1,
                2, 2, 2, 2, 2,
                3, 3, 3,
                4, 4, 4, 4,

                1, 1, 1, 1,
                2, 2, 2, 2, 2,
                3, 3, 3,
                4, 4, 4, 4,

                //empresa 6
                1, 1, 1, 1,
                2, 2, 2, 2, 2,
                3, 3, 3,
                4, 4, 4, 4,

                1, 1, 1, 1,
                2, 2, 2, 2, 2,
                3, 3, 3,
                4, 4, 4, 4,

                1, 1, 1, 1,
                2, 2, 2, 2, 2,
                3, 3, 3,
                4, 4, 4, 4,
            ],

        ];

        for ($i = 0; $i < count($data["nome_atributo"]); $i++):

            //cria um array para cada atributo
            $create = [
                "nome_atributo" => $data["nome_atributo"][$i],
                "valor_atributo" => $data["valor_atributo"][$i],
                "produto_id" => $data["produto_id"][$i],
                "categoria_atributo_id" => $data["categoria_atributo_id"][$i],
            ];

            //insere atributo no banco
            Atributo::create($create);

        endfor;
    }
}
