<?php

use Illuminate\Database\Seeder;
use App\Models\Busine_config;

class BusineConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         //array com todos os parametros
         $data = [
             "status_busine"=>[
                1,1,1,1,1,1
                ],
                "status_openCloser"=>
                [
                  1,1,1,0,1,0
                ],
                "valor_frete"=>
                [
                  4.60,0, 5.70, 3.50, 5.45, 7
                ],
                "valor_atrr_excedido"=>[
                  3, 2.50, 2, 5, 4.50, 1.50
                ],
                "delivery_time" => [
                    30, 30, 30, 30, 30, 30
                ]
            ];

            for($i=0; $i < count($data["status_openCloser"]); $i++):

                //cria um array para cada atributo
                $create = [
                        "status_openCloser"  => $data["status_openCloser"][$i],
                        "valor_frete"  => $data["valor_frete"][$i],
                        "status_busine"=> $data["status_busine"][$i],
                        "valor_atrr_excedido"=> $data["valor_atrr_excedido"][$i],
                        "delivery_time" => $data["delivery_time"][$i]
                ];

                //insere atributo no banco
                Busine_config::create( $create );

        endfor;
    }
}
