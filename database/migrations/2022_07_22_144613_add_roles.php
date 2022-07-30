<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // roles
        $role = Role::create(['name' => 'Inventory: manager']);
        $role = Role::create(['name' => 'Inventory: viewer']);

        // permisions: store
        $permission = Permission::create(['name' => 'Store', 'description' => 'Permite acceder al menú de bodega']);
        $permission = Permission::create(['name' => 'Store: list receptions']);
        $permission = Permission::create(['name' => 'Store: create reception by purcharse order']);
        $permission = Permission::create(['name' => 'Store: create reception by donation']);
        $permission = Permission::create(['name' => 'Store: list dispatchs']);
        $permission = Permission::create(['name' => 'Store: create dispatch']);
        $permission = Permission::create(['name' => 'Store: add invoice']);
        $permission = Permission::create(['name' => 'Store: bincard report']);
        $permission = Permission::create(['name' => 'Store: maintainers']);
        $permission = Permission::create(['name' => 'Store: warehouse manager']);

        // permisions: inventory
        $permission = Permission::create(['name' => 'Inventory', 'description' => 'Permite acceder al menú de inventario']);
        $permission = Permission::create(['name' => 'Inventory: index']);
        $permission = Permission::create(['name' => 'Inventory: last receptions']);
        $permission = Permission::create(['name' => 'Inventory: pending inventory']);
        $permission = Permission::create(['name' => 'Inventory: mainteners']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
