<?php


namespace Hsy\Permissions\Tests;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use function PHPUnit\Framework\assertTrue;

class PermissionsRepoTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function check_database_migration_permissions()
    {
        Permission::create(["name"=>"permissions one"]);
        $this->assertDatabaseHas("permissions",["name"=>"permissions one"]);
    }


    /** @test */
    public function store_new_permission_with_controller()
    {
        $this->withoutExceptionHandling();
        $this->post(route("permissions.permissions.index"),["permission_name"=>"edit posts"]);
        $this->assertDatabaseHas("permissions",["name"=>"edit posts"]);
    }
}