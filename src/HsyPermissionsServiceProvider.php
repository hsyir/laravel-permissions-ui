<?php


namespace Hsy\Permissions;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class HsyPermissionsServiceProvider extends ServiceProvider
{
    public function boot()
    {

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
        return [
            'namespace' => 'Hsy\Permissions\Http\Controllers',
            'prefix' => "permissions",
            'middleware' => ['web'],
            "as" => "permissions.",
        ];
    }


}