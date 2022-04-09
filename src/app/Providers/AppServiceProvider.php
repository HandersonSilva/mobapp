<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //DESCOMENTE EM AMBIENTE LOCAL PARA FORÇAR HTTP
        // \URL :: forceScheme ('https');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Para chamar PedidoRepository
        $this->app->bind(
            'App\Repositories\Contracts\PedidoRepositoryInterface',
            'App\Repositories\PedidoRepository'
        );

        // Para chamar ClientRepositoryOutroORM
        // $this->app->bind(
        //     'App\Repositories\Contracts\ClientRepositoryInterface',
        //     'App\Repositories\ClientRepositoryOutroORM'
        // );
    }
}
