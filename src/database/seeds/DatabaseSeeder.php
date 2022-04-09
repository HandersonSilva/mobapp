<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UsersTableSeeder::class);
        $this->call(PlanosTableSeeder::class);
        $this->call(AdminTableSeeder::class);
        $this->call(BusineConfigTableSeeder::class);
        $this->call(BusineEnderecoTableSeeder::class);
        $this->call(BusineTableSeeder::class);
        $this->call(HorarioBusinesTableSeeder::class);
        $this->call(CategoriasTableSeeder::class);
        $this->call(UnidadeTableSeeder::class);
        $this->call(ProdutoTableSeeder::class);
        $this->call(PromocoesTableSeeder::class);
        $this->call(PromocoesProdutosTableSeeder::class);
        $this->call(CategoriaAtributoTableSeeder::class);
        $this->call(AtributoTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(SlidePromotionSeeder::class);
        //$this->call(CarrinhoTableSeeder::class);
        // $this->call(AuxCarrinhoProdutosTableSeeder::class);gti
        // $this->call(AuxCarrinhoPromocaoTableSeeder::class);

    }
}
