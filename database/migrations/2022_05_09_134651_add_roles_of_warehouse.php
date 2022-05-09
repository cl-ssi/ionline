<?php

use App\Models\Warehouse\StoreUser;
use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddRolesOfWarehouse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $roleStoreAdmin = Role::create(['name' => 'Store: admin']);
        $roleStoreUser = Role::create(['name' => 'Store: user']);
        $roleStoreSuperAdmin = Role::create(['name' => 'Store: Super admin']);

        // TODO: Definir mas permisos por rol
        $permission = Permission::create(['name' => 'Store: index']);

        $user = User::find(15287582);
        $user->assignRole($roleStoreSuperAdmin);
        $user->givePermissionTo('Store: index');

        $roleStoreSuperAdmin->givePermissionTo($permission);

        // TODO: Eliminar
        StoreUser::create([
            'user_id' => 16469490,
            'store_id' => 1,
            'role_id' => 18
        ]);
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
