<?php

use Illuminate\Database\Seeder;
use App\Models\Plano;

class PlanosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plano::create(['descricao'=> 'MobAPP', 'valor'=> 1000, 'valor_percentual'=> 0, 'mensal'=> 0]);
        Plano::create(['descricao'=> 'MENSALIDADE', 'valor'=> 79.99, 'valor_percentual'=> 0, 'mensal'=> 1]);
        Plano::create(['descricao'=> 'PORCENTAGEM', 'valor'=> 5, 'valor_percentual'=> 1, 'mensal'=> 1]);
    }
}

