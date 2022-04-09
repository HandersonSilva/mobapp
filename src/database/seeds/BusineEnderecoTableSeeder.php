<?php

use Illuminate\Database\Seeder;
use App\Models\Busine_endereco;

class BusineEnderecoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
       $data = [
        "cidade" => 
        [
           "São Gonçalo do Amarante - RN",
           "Natal - RN",
           "Natal - RN",
           "Natal - RN", 
           "Natal - RN",
           "Natal - RN", 
           
        ],
        "bairro"=> 
        [
            "Centro","Alecrim","Candelária","Capim Macio","Felipe Camarão","Dix-Sept Rosado"
        ],
        "rua"=> 
        [
            "Rua João Angelo da Fonseca",
            "Av. 8, 1480-1510 - Alecrim",
            "Av. Prudente de Morais",
            "R. Profª Gipse Montenegro",
            "Av. Capitão-Mor Gouveia",
            "Av. Interventor Mário Câmara",
        ],
        "cep"=> 
        [
         "59290-000","59052-800","59063-200","59080-060","59060-400","59052-700"
        ],
        "numero"=> 
        [
            "78","09","4576","3086","356","4"
        ],
        "lat_empresa"=> 
        [
            "-5.779184","-5.799209","-5.825210", "-5.853184", "-5.819940","-5.810864", 
        ],
        "log_empresa"=> 
        [
           "-35.291926","-35.218691","-35.215535","-35.205879","-35.236379","-35.225864"
        ]
    ];


    for($i=0; $i < count($data["cidade"]); $i++):
                
        //cria um array para cada atributo
        $create = [
                "cidade"  => $data["cidade"][$i],
                "bairro"  => $data["bairro"][$i],
                "rua"  => $data["rua"][$i],
                "cep"  => $data["cep"][$i],
                "numero"  => $data["numero"][$i],
                "lat_empresa"  => $data["lat_empresa"][$i],
                "log_empresa"  => $data["log_empresa"][$i]
        ];
        
        //insere atributo no banco
        Busine_endereco::create( $create );
        
    endfor;
    }
}
