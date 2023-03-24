<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
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
        Permission::create(['name' => 'Users: must change password', 'description' => 'Para obligar a cambiar su clave (sin uso)']);

        Permission::create(['name' => 'Users: create', 'description' => 'Permite crear ususarios']);
        Permission::create(['name' => 'Users: edit', 'description' => 'Editar usuarios']);
        Permission::create(['name' => 'Users: delete', 'description' => 'Borrar usuarios']);
        Permission::create(['name' => 'Users: assign permission', 'description' => 'Asignar permisos a usuarios']);

        Permission::create(['name' => 'OrganizationalUnits: create', 'description' => 'Crear unidades organizacionales']);
        Permission::create(['name' => 'OrganizationalUnits: edit', 'description' => 'Editar unidades organizacionales']);
        Permission::create(['name' => 'OrganizationalUnits: delete', 'description' => 'Borrar unidades organizacionales']);

        Permission::create(['name' => 'Documents: create', 'description' => 'Crear documentos']);
        Permission::create(['name' => 'Documents: edit', 'description' => 'Editar documentos']);
        Permission::create(['name' => 'Documents: add number', 'description' => 'Agregar número a documento y subir archivo']);
        Permission::create(['name' => 'Documents: signatures and distribution', 'description' => 'Firmas y distribución']);
        Permission::create(['name' => 'Documents: delete document', 'description' => 'Permite eliminar un documento que no tenga archivo adjunto o firmas']);

        Permission::create(['name' => 'Resources: create', 'description' => 'Crear un recurso']);
        Permission::create(['name' => 'Resources: edit', 'description' => 'Editar un recurso']);
        Permission::create(['name' => 'Resources: delete', 'description' => 'Borrar un recurso']);

        Permission::create(['name' => 'Drugs', 'description' => 'Permite acceder al menú del módulo de Drogas']);
        Permission::create(['name' => 'Drugs: view receptions' , 'description' => 'Permite ver actas de recepción']);
        Permission::create(['name' => 'Drugs: create receptions', 'description' => 'Crear actas de recepciones']);
        Permission::create(['name' => 'Drugs: edit receptions', 'description' => 'Editar actas de recepción']);
        Permission::create(['name' => 'Drugs: destroy drugs', 'description' => 'Crear actas de destrucción']);
        Permission::create(['name' => 'Drugs: view reports', 'description' => 'Ver reporte']);
        Permission::create(['name' => 'Drugs: manage parameters', 'description' => 'Modificar parametros del módulo de drogas']);
        Permission::create(['name' => 'Drugs: manage substances', 'description' => 'Mantenedor de sustancias']);
        Permission::create(['name' => 'Drugs: manage courts', 'description' => 'Mantenedor de Juzgados']);
        Permission::create(['name' => 'Drugs: manage police units', 'description' => 'Mantenedor de unidades policiales']);
        Permission::create(['name' => 'Drugs: delete destructions', 'description' => 'Borrar actas de destrucción']);
        Permission::create(['name' => 'Drugs: add results from ISP', 'description' => 'Agregar resultados del ISP']);
        Permission::create(['name' => 'Drugs: add protocols', 'description' => 'Crear protocolos (resultados de análisis)']);


        Permission::create(['name' => 'Tickets: create']);
        Permission::create(['name' => 'Tickets: manage']);
        Permission::create(['name' => 'Tickets: TI']);

        Permission::create(['name' => 'Calendar: view']);
        Permission::create(['name' => 'Calendar: aps']);

        Permission::create(['name' => 'Integrity: manage complaints']);

        Permission::create(['name' => 'Indicators: view']);
        Permission::create(['name' => 'Indicators: manager']);

        Permission::create(['name' => 'Authorities: view', 'description' => 'Permite tener acceso al módulo de autoridades']);
        Permission::create(['name' => 'Authorities: create', 'description' => 'Permite crear una autoridad']);
        Permission::create(['name' => 'Authorities: edit', 'description' => 'Permite editar una autoridad']);
        Permission::create(['name' => 'Authorities: all', 'description' => 'Permite tener acceso a todas las autoridades del módulo de autoridades']);

        Permission::create(['name' => 'Requirements: create', 'description' => 'Acceso al SGR']);

        Permission::create(['name' => 'Agreements: user']);
        Permission::create(['name' => 'Agreements: manager']);

        Permission::create(['name' => 'Pharmacy: manager']);
        Permission::create(['name' => 'Pharmacy: user']);
        Permission::create(['name' => 'Pharmacy: create']);
        Permission::create(['name' => 'Pharmacy: deliver']);
        Permission::create(['name' => 'Pharmacy: dispatch']);
        Permission::create(['name' => 'Pharmacy: edit_delete']);
        Permission::create(['name' => 'Pharmacy: mantenedores']);
        Permission::create(['name' => 'Pharmacy: purchase']);
        Permission::create(['name' => 'Pharmacy: receiving']);
        Permission::create(['name' => 'Pharmacy: reports']);
        Permission::create(['name' => 'Pharmacy: transfer']);
        Permission::create(['name' => 'Pharmacy: transfer view ortesis']);
        Permission::create(['name' => 'Pharmacy: create suppliers']);
        Permission::create(['name' => 'Pharmacy: create establishments']);
        Permission::create(['name' => 'Pharmacy: create products']);
        Permission::create(['name' => 'Pharmacy: create programs']);

        Permission::create(['name' => 'Service Request']);
        Permission::create(['name' => 'Service Request: additional data']);
        Permission::create(['name' => 'Service Request: additional data finanzas']);
        Permission::create(['name' => 'Service Request: additional data oficina partes']);
        Permission::create(['name' => 'Service Request: additional data rrhh']);
        Permission::create(['name' => 'Service Request: consolidated data']);
        Permission::create(['name' => 'Service Request: change signature flow']);
        Permission::create(['name' => 'Service Request: audit']);
        Permission::create(['name' => 'Service Request: delete request']);
        Permission::create(['name' => 'Service Request: derive requests']);
        Permission::create(['name' => 'Service Request: fulfillments']);
        Permission::create(['name' => 'Service Request: fulfillments finance']);
        Permission::create(['name' => 'Service Request: fulfillments responsable']);
        Permission::create(['name' => 'Service Request: fulfillments rrhh']);
        Permission::create(['name' => 'Service Request: maintainers']);
        Permission::create(['name' => 'Service Request: pending requests']);
        Permission::create(['name' => 'Service Request: report to pay']);
        Permission::create(['name' => 'Service Request: sign document']);
        Permission::create(['name' => 'Service Request: transfer requests']);
        Permission::create(['name' => 'Service Request: view']);
        Permission::create(['name' => 'Service Request: with resolution']);

        Permission::create(['name' => 'Shift Management: view']);

        Permission::create(['name' => 'Suitability: admin']);
        Permission::create(['name' => 'Suitability: test']);
        Permission::create(['name' => 'Suitability: ssi']);

        Permission::create(['name' => 'Rem: admin', 
                            'description' => 'Usuario Administrador que revisa los REM y bloquea para que no puedan seguir y a la vez designa a los usuarios por cada establecimiento']);
        Permission::create(['name' => 'Rem: user',
                            'description' => 'Usuario asignado para poder cargar REM a establecimiento correspondiente']);

        Permission::create(['name' => 'Request Forms: all']);
        Permission::create(['name' => 'Request Forms: audit']);
        Permission::create(['name' => 'Request Forms: boss']);
        Permission::create(['name' => 'Request Forms: config']);

        Permission::create(['name' => 'Health Plan']);

        Permission::create(['name' => 'Partes: user']);
        Permission::create(['name' => 'Partes: director']);
        Permission::create(['name' => 'Partes: oficina']);
        Permission::create(['name' => 'Partes: delete']);

        Permission::create(['name' => 'Rrhh: wellfair']);

        Permission::create(['name' => 'Replacement Staff: assign request', 'description' => '	Permite asignar solicitudes a funcionarios de la unidad de reclutamiento y selección']);
        Permission::create(['name' => 'Replacement Staff: create request', 'description' => 'Permite crear solicitudes de reemplazo']);
        Permission::create(['name' => 'Replacement Staff: list rrhh', 'description' => 'Permite visualizar el listado de staff de reemplazo']);
        Permission::create(['name' => 'Replacement Staff: manage', 'description' => 'Permite editar parámetros del módulo']);
        Permission::create(['name' => 'Replacement Staff: personal sign', 'description' => 'Permite a funcionarios de unidad de personal aprobar o declinar solicitudes']);
        Permission::create(['name' => 'Replacement Staff: staff manage', 'description' => 'Permite gestionar staff por unidad organizacional']);
        Permission::create(['name' => 'Replacement Staff: technical evaluation', 'description' => 'Permite acceder al listado de solicitudes aceptadas para evaluación técnica']);
        Permission::create(['name' => 'Replacement Staff: view requests', 'description' => 'Permite visualizar requerimientos']);

        Permission::create(['name' => 'Allowances: create', 'description' => 'Permite crear viáticos']);
        Permission::create(['name' => 'Allowances: all',    'description' => 'Permite visualizar todos los viáticos']);
        Permission::create(['name' => 'Allowances: reports', 'description' => 'Permite acceder a los reportes del módulo']);
        Permission::create(['name' => 'Allowances: sirh', 'description' => 'Permite revisión inicial del formulario e ingreso de folio sirh']);

        Permission::create(['name' => 'Job Position Profile: create', 'description' => 'Permite crear la creación de perfiles de cargo']);
        Permission::create(['name' => 'Job Position Profile: all', 'description' => 'Permite acceder a todo el listado de perfiles de cargo']);
        Permission::create(['name' => 'Job Position Profile: audit', 'description' => 'Permite acceder al registro de auditoría del módulo']);
        
        Permission::create(['name' => 'Payments', 'description' => 'Acceso al módulo Estados de Pago']);

        // @role(
        //   'Replacement Staff: admin |
        //   Replacement Staff: user'
        // )

        $role = Role::create(['name' => 'Drugs: admin']);
        $role->givePermissionTo([
            'Drugs',
            'Drugs: view receptions',
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
        $role->givePermissionTo([
            'Drugs',
            'Drugs: view receptions',
            'Drugs: create receptions',
            'Drugs: edit receptions',
            'Drugs: destroy drugs',
            'Drugs: view reports',
            'Drugs: manage substances',
            'Drugs: manage courts',
            'Drugs: manage police units',
            'Drugs: add protocols']);

        $role = Role::create(['name' => 'Drugs: basic']);
        $role->givePermissionTo([
            'Drugs',
            'Drugs: view receptions',
            'Drugs: destroy drugs',
            'Drugs: view reports',
            'Drugs: add results from ISP']);

        $role = Role::create(['name' => 'RRHH: admin']);
        $role->givePermissionTo(['Users: create', 'Users: edit', 'Users: delete', 'Users: assign permission']);

        $role = Role::create(['name' => 'Resources: admin']);
        $role->givePermissionTo(['Resources: create', 'Resources: edit', 'Resources: delete']);

        $role = Role::create(['name' => 'Tickets: admin']);
        $role->givePermissionTo(['Tickets: create', 'Tickets: manage','Tickets: TI']);

        $role = Role::create(['name' => 'Replacement Staff: admin']);
        $role->givePermissionTo([
            'Replacement Staff: assign request',
            'Replacement Staff: create request',
            'Replacement Staff: list rrhh',
            'Replacement Staff: manage',
            'Replacement Staff: staff manage',
            'Replacement Staff: technical evaluation'
        ]);

        $role = Role::create(['name' => 'Replacement Staff: user']);
        $role->givePermissionTo([
            'Replacement Staff: create request'
        ]);

        $role = Role::create(['name' => 'Replacement Staff: user rys']);
        $role->givePermissionTo([
            'Replacement Staff: create request',
            'Replacement Staff: list rrhh',
            'Replacement Staff: technical evaluation',
            'Replacement Staff: view requests'
        ]);

        $role = Role::create(['name' => 'Replacement Staff: personal']);
        $role->givePermissionTo([
            'Replacement Staff: view requests'
        ]);

        $role = Role::create(['name' => 'Replacement Staff: personal sign']);
        $role->givePermissionTo([
            'Replacement Staff: view requests',
            'Replacement Staff: personal sign'
        ]);

        $roleStoreAdmin = Role::create(['name' => 'Store: admin']);
        $roleStoreUser = Role::create(['name' => 'Store: user']);
        $roleStoreSuperAdmin = Role::create(['name' => 'Store: Super admin']);

        // TODO: Definir mas permisos por rol
        $permission = Permission::create(['name' => 'Store: index']);

        // $user = User::find(15287582);
        // $user->assignRole($roleStoreSuperAdmin);
        // $user->givePermissionTo('Store: index');

        $roleStoreSuperAdmin->givePermissionTo($permission);

        // create roles and assign created permissions
        // GOD LIKE
        $role = Role::create(['name' => 'god']);
        $role->givePermissionTo(Permission::all());
        $role = Role::create(['name' => 'dev']);
    }
}
