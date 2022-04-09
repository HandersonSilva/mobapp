<?php

use Illuminate\Database\Seeder;
use App\Models\Busine;

class BusineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        

        //criando busine
        //array com todos os parametros
        $data = [
            "nome"=> 
            [
               "Paulo Empresa","João Empresa","Pedro Empresa","Maria Empresa","Lucas Empresa","Leonardo Empresa"
            ],
            "nome_fantasia"=> 
            [
                "Esquina do Lanche","Disk Água Natal","Pastel Chef","Mama Mia","Night Dog","Açaí da Chefe"
            ],
            "docs"=> 
            [
                77777777777,22222222222222,33333333333333,44444444444444,55555555555555,66666666666666
            ],
            "telefone"=> 
            [
                "32002300","32002300","32002300","32002300","32002300","32002300"
         
            ],
            "seguimento"=> 
            [
                "Lanches em geral","Agua mineral/conveniência","O melhores Pasteis","Pizzaria","Lanches em geral","Açai"
        
            ],
            "url_img_busine"=> 
            [
               "logo1.jpeg",
               "logo2.jpeg",
               "logo3.jpeg",
               "logo4.jpeg",
               "logo5.jpeg",
               "logo6.jpeg",
            ],
            "busine_configs_id"=> 
            [
               1,2,3,4,5,6
            ],
            "busine_enderecos_id"=> 
            [
               1,2,3,4,5,6
            ],
            "admin_id"=> 
            [
               1,2,3,4,5,6
            ]

        ];

        for($i=0; $i < count($data["nome"]); $i++):
            
                //cria um array para cada atributo
                $create = [
                        "nome"  => $data["nome"][$i],
                        "nome_fantasia"  => $data["nome_fantasia"][$i],
                        "docs"  => $data["docs"][$i],
                        "telefone"  => $data["telefone"][$i],
                        "seguimento"  => $data["seguimento"][$i],
                        "url_img_busine"  => $data["url_img_busine"][$i],
                        "busine_configs_id"  => $data["busine_configs_id"][$i],
                        "busine_enderecos_id"  => $data["busine_enderecos_id"][$i],
                        "admin_id"  => $data["admin_id"][$i]
                ];
                
                //insere atributo no banco
                Busine::create( $create );
                
        endfor;
    }
}
