<?php


namespace Hsy\Permissions;


use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class HsyPermissionsServiceProvider extends ServiceProvider
{
    public function boot()
    {


        $this->publishes([
            __DIR__ . '/../config/permissions-ui.php' => config_path('permissions-ui.php'),
        ], 'config');
    }

    public function register()
    {
        $this->registerResources();
    }

    /**
     * Register the package resources such as routes, templates, etc.
     *
     * @return void
     */
    protected function registerResources()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'permissions');
        $this->registerConfigs();
        $this->registerRoutes();
    }


    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }

    /**
     * Get the Press route group configuration array.
     *
     * @return array
     */
    protected function routeConfiguration()
    {

        $middlewares = ["web"];

        if(config("permissions-ui.restricted")){
            $middlewares[]="can:manage-permissions";
        }

        return [
            'namespace' => 'Hsy\Permissions\Http\Controllers',
            'prefix' => "permissions",
            'middleware' => $middlewares,
            "as" => "permissions.",
        ];
    }

    private function registerConfigs()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/permissions-ui.php', 'permissions-ui');
    }

}