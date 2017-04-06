<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\Access\Contracts\PermissionRepository','App\Repositories\Access\PermissionRepositoryEloquent');
        $this->app->bind('App\Repositories\Access\Contracts\RoleRepository','App\Repositories\Access\RoleRepositoryEloquent');
        $this->app->bind('App\Repositories\Access\Contracts\UserRepository','App\Repositories\Access\UserRepositoryEloquent');

        $this->app->bind('App\Repositories\Application\Contracts\CasaRepository','App\Repositories\Application\CasaRepositoryEloquent');
        $this->app->bind('App\Repositories\Application\Contracts\UnidadeRepository','App\Repositories\Application\UnidadeRepositoryEloquent');
        $this->app->bind('App\Repositories\Application\Contracts\EmpresaRepository','App\Repositories\Application\EmpresaRepositoryEloquent');
        $this->app->bind('App\Repositories\Application\Contracts\ContratoRepository','App\Repositories\Application\ContratoRepositoryEloquent');
        $this->app->bind('App\Repositories\Application\Contracts\ContratoAditivoRepository','App\Repositories\Application\ContratoAditivoRepositoryEloquent');

    }
}
