<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    //  DB::table('users')->truncate();
    $faker = Faker::create();
    
     foreach(range(3,6) as $i ){
        DB::table('users')->insert([
            'nome' => $faker->name(),
            'email' =>$faker->email(),
            'password' => bcrypt('1234'),
            'cpf' => "4658563650".$i,
            "telefone" => "842584545"+$i
        ]);
     }
     
    }
} 