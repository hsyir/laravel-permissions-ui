<?php

namespace Hsy\Permissions\Tests;

use Hsy\AnsweringSystem\Providers\AnsweringSystemServiceProvider;
use Hsy\Permissions\HsyPermissionsServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{

    /** @var \Spatie\Permission\Test\User */
    protected $testUser;


    protected function setUp(): void
    {
        parent::setUp();
//        $this->withFactories(__DIR__ . '/../database/factories');
//        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
     /*   $this->artisan("migrate", [
            "--database" => "testing",
            "--realpath" => realpath(__DIR__ . "../vendor/spatie/laravel-permission/database/migrations/create_permission_tables.php.stub")
        ])->run();*/

        $this->setUpDatabase($this->app);

        $this->testUser = User::first();
    }

    /**
     * Bootstrap any service providers here.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            HsyPermissionsServiceProvider::class,
            PermissionServiceProvider::class
        ];
    }

    /**
     * Bootstrap any aliases here.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
//            'Press' => 'Hsy\\Store\\Facades\\Store',
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('app.locale', 'fa');
        $app['config']->set('app.timezone', 'Asia/tehran');
        $app['config']->set('database.default', 'testdb');
        $app['config']->set('database.connections.testdb', [
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);
    }

    /**
     * Set up the database.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase($app)
    {
        $app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->softDeletes();
        });


        include_once (__DIR__ . "/../vendor/spatie/laravel-permission/database/migrations/create_permission_tables.php.stub");

        (new \CreatePermissionTables())->up();
        User::create(['email' => 'test@user.com']);

    }

}
