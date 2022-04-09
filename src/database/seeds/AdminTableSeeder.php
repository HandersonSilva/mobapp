<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AdminTableSeeder extends Seeder
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
    
     for($i = 1; $i <= 6; $i++ ){
        DB::table('admins')->insert([
            'nome' => $faker->name(),
            'email' =>$faker->email(),
            'password' => bcrypt('1234'),
            'cpf' => "4658563650".$i,
            "telefone" => "842584545"+$i,
            "hash_activate" => bcrypt($faker->name().'_'.$faker->email().'_'."4658563650".$i),
            
        ]);
     }
     
    }
} 