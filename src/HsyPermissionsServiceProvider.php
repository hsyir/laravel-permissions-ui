<?php


namespace Hsy\Permissions;


use Illuminate\Support\ServiceProvider;

class HsyPermissionsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../config/permissions.php' => config_path('permissions.php'),
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
        $this->registerFacades();
        $this->registerRoutes();
        $this->registerConfigs();
    }


    private function registerFacades()
    {
        $this->app->singleton("Permissions", function () {
            return new Permissions;
        });
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
        return [
            'namespace' => 'Hsy\Permissions\Http\Controllers',
            'prefix' => "permissions",
            'middleware' => ['web'],
            "as"=>"permissions.",
        ];
    }

    private function registerConfigs()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/permissions.php', 'permissions');
    }
}