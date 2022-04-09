<?php

use App\Models\Horario_busines;
use Illuminate\Database\Seeder;

class HorarioBusinesTableSeeder extends Seeder
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
            "dia" => [ //dias adaptador para ficar igual ao do android
                "segunda-feira", "quarta-feira", "terça-feira",
                "quinta-feira", "sexta-feira", "sábado", "domingo",

                "segunda-feira", "quarta-feira", "terça-feira",
                "quinta-feira", "sexta-feira", "sábado", "domingo",

                "segunda-feira", "quarta-feira", "terça-feira",
                "quinta-feira", "sexta-feira", "sábado", "domingo",

                "segunda-feira", "quarta-feira", "terça-feira",
                "quinta-feira", "sexta-feira", "sábado", "domingo",

                "segunda-feira", "quarta-feira", "terça-feira",
                "quinta-feira", "sexta-feira", "sábado", "domingo",

                "segunda-feira", "quarta-feira", "terça-feira",
                "quinta-feira", "sexta-feira", "sábado", "domingo",

            ],
            "inicio" =>
            [
                "07:00", "07:00", "07:00", "07:00", "07:00", "07:00", "07:00",
                "19:00", "18:00", "18:00", "18:00", "18:00", "18:00", "18:00",
                "19:00", "18:00", "18:00", "18:00", "18:00", "18:00", "18:00",
                "19:00", "18:00", "18:00", "18:00", "18:00", "18:00", "18:00",
                "19:00", "18:00", "18:00", "18:00", "18:00", "18:00", "18:00",
                "19:00", "18:00", "18:00", "18:00", "18:00", "18:00", "18:00",
            ],
            "fechamento" =>
            [
                "22:00", "23:00", "23:00", "23:00", "23:00", "23:00", "23:00",
                "21:00", "23:00", "23:00", "21:00", "23:00", "23:00", "23:00",
                "22:00", "23:00", "23:00", "23:00", "23:00", "23:00", "23:00",
                "22:00", "23:00", "22:00", "23:00", "23:00", "23:00", "23:00",
                "22:00", "23:00", "23:00", "23:00", "23:00", "23:00", "23:00",
                "22:00", "23:00", "23:00", "23:00", "23:00", "23:00", "23:00",
            ],
            "obs" =>
            [
                "Fechamos as 13hs e retornamos as 14hs", "Fechamos as 13hs e retornamos as 14hs",
                "Fechamos as 13hs e retornamos as 14hs", "Fechamos as 13hs e retornamos as 14hs",
                "Fechamos as 13hs e retornamos as 14hs", "Fechamos as 13hs e retornamos as 14hs",
                "Fechamos as 13hs e retornamos as 14hs",
                "", "", "", "", "", "", "",
                "", "", "", "", "", "", "",
                "", "", "", "", "", "", "",
                "", "", "", "", "", "", "",
                "", "", "", "", "", "", "",
                "", "", "", "", "", "", "",
                "", "", "", "", "", "", "",

            ],
            "busines_id" =>
            [
                1, 1, 1, 1, 1, 1, 1,
                2, 2, 2, 2, 2, 2, 2,
                3, 3, 3, 3, 3, 3, 3,
                4, 4, 4, 4, 4, 4, 4,
                5, 5, 5, 5, 5, 5, 5,
                6, 6, 6, 6, 6, 6, 6,
            ],
            "status" => [ //0 fechado nesse dia , 1 aberto
                0, 1, 1, 1, 1, 1, 1,
                0, 0, 0, 1, 1, 1, 1,
                0, 0, 0, 1, 1, 1, 1,
                0, 0, 0, 1, 1, 1, 1,
                0, 0, 0, 1, 1, 1, 1,
                0, 0, 0, 1, 1, 1, 1,
            ],
        ];

        for ($i = 0; $i < count($data["dia"]); $i++):

            //cria um array para cada atributo
            $create = [
                "dia" => $data["dia"][$i],
                "inicio" => $data["inicio"][$i],
                "fechamento" => $data["fechamento"][$i],
                "obs" => $data["obs"][$i],
                "busines_id" => $data["busines_id"][$i],
                "status" => $data["status"][$i],

            ];

            //insere atributo no banco
            Horario_busines::create($create);

        endfor;

    }
}
