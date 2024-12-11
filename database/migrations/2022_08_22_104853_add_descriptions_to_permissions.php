<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* TODO: agregar al seeder de permisos y eliminar */
        /* permissions: warehouse */
        // $permission = Permission::where('name', 'Store: list receptions')->first();
        // $permission->description = 'Permite visualizar la lista de los ingresos';
        // $permission->save();

        // $permission = Permission::where('name', 'Store: create reception by purcharse order')->first();
        // $permission->description = 'Permite crear ingreso por orden de compra';
        // $permission->save();

        // $permission = Permission::where('name', 'Store: create reception by donation')->first();
        // $permission->description = 'Permite crear ingreso normal o por donación';
        // $permission->save();

        // $permission = Permission::where('name', 'Store: list dispatchs')->first();
        // $permission->description = 'Permite visualizar la lista de los egresos';
        // $permission->save();

        // $permission = Permission::where('name', 'Store: create dispatch')->first();
        // $permission->description = 'Permite crear egreso';
        // $permission->save();

        // $permission = Permission::where('name', 'Store: add invoice')->first();
        // $permission->description = 'Permite cargar facturas a uno o más ingresos';
        // $permission->save();

        // $permission = Permission::where('name', 'Store: bincard report')->first();
        // $permission->description = 'Permite visualizar el reporte bincard';
        // $permission->save();

        // $permission = Permission::where('name', 'Store: maintainers')->first();
        // $permission->description = 'Permite acceder a los mantenedores de la bodega';
        // $permission->save();

        // $permission = Permission::where('name', 'Store: warehouse manager')->first();
        // $permission->description = 'Permite gestionar todas las bodegas';
        // $permission->save();

        // $permission = Permission::where('name', 'Store: maintainer programs')->first();
        // $permission->description = 'Permite acceder al mantenedor de programas';
        // $permission->save();

        // // permisions: inventory
        // $permission = Permission::where('name', 'Inventory: index')->first();
        // $permission->description = 'Permite visualizar todos los productos inventariados';
        // $permission->save();

        // $permission = Permission::where('name', 'Inventory: last receptions')->first();
        // $permission->description = 'Permite visualizar los últimos ingresos de la bodega';
        // $permission->save();

        // $permission = Permission::where('name', 'Inventory: pending inventory')->first();
        // $permission->description = 'Permite visualizar todos los inventarios pendientes';
        // $permission->save();

        // $permission = Permission::where('name', 'Inventory: mainteners')->first();
        // $permission->description = 'Permite acceder a los mantenedores de inventario';
        // $permission->save();
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
};
