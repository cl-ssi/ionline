<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class AddPermissionsInventoryEdit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Permission::create([
            'name' => 'Inventory: edit',
            'description' => 'Permite editar el item de inventario'
        ]);

        Permission::create([
            'name' => 'Inventory: place maintainer',
            'description' => 'Permite acceder al mantenedor de lugares'
        ]);

        //Inventory: place maintainer
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name','Inventory: edit')->delete();
        Permission::where('name','Inventory: place maintainer')->delete();
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
