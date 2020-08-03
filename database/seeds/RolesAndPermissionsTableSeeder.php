<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        Permission::create(['name' => 'be god']);
        Permission::create(['name' => 'I play with madness']);

        // create permissions
        Permission::create(['name' => 'Users: must change password']);

        Permission::create(['name' => 'Users: create']);
        Permission::create(['name' => 'Users: edit']);
        Permission::create(['name' => 'Users: delete']);
        Permission::create(['name' => 'Users: assign permission']);

        Permission::create(['name' => 'OrganizationalUnits: create']);
        Permission::create(['name' => 'OrganizationalUnits: edit']);
        Permission::create(['name' => 'OrganizationalUnits: delete']);

        Permission::create(['name' => 'Documents: create']);
        Permission::create(['name' => 'Documents: edit']);
        Permission::create(['name' => 'Documents: add number']);

        Permission::create(['name' => 'Resources: create']);
        Permission::create(['name' => 'Resources: edit']);
        Permission::create(['name' => 'Resources: delete']);

        Permission::create(['name' => 'Drugs: view receptions']);
        Permission::create(['name' => 'Drugs: create receptions']);
        Permission::create(['name' => 'Drugs: edit receptions']);
        Permission::create(['name' => 'Drugs: destroy drugs']);
        Permission::create(['name' => 'Drugs: view reports']);
        Permission::create(['name' => 'Drugs: manage parameters']);
        Permission::create(['name' => 'Drugs: manage substances']);
        Permission::create(['name' => 'Drugs: manage courts']);
        Permission::create(['name' => 'Drugs: manage police units']);
        Permission::create(['name' => 'Drugs: delete destructions']);
        Permission::create(['name' => 'Drugs: add results from ISP']);
        Permission::create(['name' => 'Drugs: add protocols']);


        Permission::create(['name' => 'Tickets: create']);
        Permission::create(['name' => 'Tickets: manage']);
        Permission::create(['name' => 'Tickets: TI']);

        Permission::create(['name' => 'Calendar: view']);

        Permission::create(['name' => 'Integrity: manage complaints']);

        Permission::create(['name' => 'Indicators: view']);
        Permission::create(['name' => 'Indicators: manager']);

        Permission::create(['name' => 'Authorities: manager']);
        Permission::create(['name' => 'Authorities: view']);

        Permission::create(['name' => 'Requirements: create']);

        Permission::create(['name' => 'Agreements: user']);
        Permission::create(['name' => 'Agreements: manager']);

        Permission::create(['name' => 'Pharmacy: manager']);
        Permission::create(['name' => 'Pharmacy: user']);
        Permission::create(['name' => 'Pharmacy: SSI (id:1)']);
        Permission::create(['name' => 'Pharmacy: REYNO (id:2)']);

        Permission::create(['name' => 'Health Plan']);

        Permission::create(['name' => 'Partes: user']);
        Permission::create(['name' => 'Partes: director']);
        Permission::create(['name' => 'Partes: oficina']);

        // create roles and assign created permissions
        // GOD LIKE
        $role = Role::create(['name' => 'god']);
        $role = Role::create(['name' => 'dev']);
        //$role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'Drugs: admin']);
        $role->givePermissionTo(['Drugs: view receptions',
                                'Drugs: create receptions',
                                'Drugs: edit receptions',
                                'Drugs: destroy drugs',
                                'Drugs: view reports',
                                'Drugs: manage parameters',
                                'Drugs: manage substances',
                                'Drugs: manage courts',
                                'Drugs: manage police units',
                                'Drugs: delete destructions',
                                'Drugs: add results from ISP',
                                'Drugs: add protocols']);

        $role = Role::create(['name' => 'Drugs: receptionist']);
        $role->givePermissionTo(['Drugs: view receptions',
                                'Drugs: create receptions',
                                'Drugs: edit receptions',
                                'Drugs: destroy drugs',
                                'Drugs: view reports',
                                'Drugs: manage substances',
                                'Drugs: manage courts',
                                'Drugs: manage police units',
                                'Drugs: add protocols']);

        $role = Role::create(['name' => 'Drugs: basic']);
        $role->givePermissionTo(['Drugs: view receptions',
                                'Drugs: destroy drugs',
                                'Drugs: view reports',
                                'Drugs: add results from ISP']);

        $role = Role::create(['name' => 'RRHH: admin']);
        $role->givePermissionTo(['Users: create', 'Users: edit', 'Users: delete', 'Users: assign permission']);

        $role = Role::create(['name' => 'Resources: admin']);
        $role->givePermissionTo(['Resources: create', 'Resources: edit', 'Resources: delete']);

        $role = Role::create(['name' => 'Tickets: admin']);
        $role->givePermissionTo(['Tickets: create', 'Tickets: manage','Tickets: TI']);
    }
}
