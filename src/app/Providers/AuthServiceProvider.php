<?php

namespace App\Providers;

use App\Models\Admin;
use App\Permission;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Schema;


class AuthServiceProvider extends ServiceProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        Schema::defaultStringLength(191);
        $this->registerPolicies($gate);

        //
        //adiciona routes do passport
        // Passport::routes();
        //Alterando o tempo expiração do token
        // Passport::tokensExpireIn(Carbon::now()->addMinutes(30));//um ano em minutos 525600

        //Definindo tipos de usuario para dar permissão
        // Passport::tokensCan(['usuario'=>'Usuario comum',
        // 'administrador'=>'Administrador do sistema'
        //]);

        //comentar esse trecho do antes de rodar as migration
       /* $permission = Permission::with('roles')->get();

       foreach ($permission as $perm) {
            $gate->define($perm->name, function (Admin $admin) use ($perm) {
            return $admin->hasPermission($perm);
            });

        }*/

    }
}
