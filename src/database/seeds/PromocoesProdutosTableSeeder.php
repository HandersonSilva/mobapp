<?php

use Illuminate\Database\Seeder;

class PromocoesProdutosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $ids_promo = [ 1, 1, 1,1,];
        $ids_promo_petisco = [2,2,2 ];
        $ids_promo_acai = [ 3,3, 3, 3, 3];
        
        $ids_produto_promo = [2,3, 3,1];
        $ids_produto_promo_petisco = [4, 5, 6];
        $ids_produto_promo_acai = [8,9, 7, 8, 9];

        //criando promoções

        for($i=0; $i < count($ids_promo); $i++):

                DB::table('promocao_produto')->insert([
                    'promocao_id' => $ids_promo[$i],
                    'produto_id' => $ids_produto_promo[$i],  
                ]);

        endfor;

        for($i=0; $i < count($ids_promo_petisco); $i++):

                DB::table('promocao_produto')->insert([
                    'promocao_id' => $ids_promo_petisco[$i],
                    'produto_id' => $ids_produto_promo_petisco[$i],  
                ]);
            
        endfor;

        for($i=0; $i < count($ids_promo_acai); $i++):

                DB::table('promocao_produto')->insert([
                    'promocao_id' => $ids_promo_acai[$i],
                    'produto_id' => $ids_produto_promo_acai[$i],  
                ]);
            
        endfor;
        
    }
}
