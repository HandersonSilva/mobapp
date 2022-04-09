<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SlidePromotionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('slide_promotions')->insert([
            'slide_1' => "natal_1.jpeg",
            'slide_2' => "natal_2.jpeg",
            'slide_3' => "natal_3.jpeg",
            'slide_4' => "natal_4.jpeg",
            'cidade' => "NATAL - RN",
        ]);

        DB::table('slide_promotions')->insert([
            'slide_1' => "sga_1.jpeg",
            'slide_2' => "sga_2.jpeg",
            'slide_3' => "sga_3.jpeg",
            'slide_4' => "sga_4.jpeg",
            'cidade' => "SAO GONÇALO DO AMARANTE - RN",
        ]);
    
    }
} 