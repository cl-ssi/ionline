<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsToSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rolesandpermission:seeder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        echo "Permission::create(['name' => 'be god', 'description' => 'God Mode !']);\n";
        echo "Permission::create(['name' => 'dev', 'description' => 'Developer']);\n";
        echo "\n\n";

        // get all permissions
        $permissions = Permission::whereNotIn('name',['be god','dev'])->orderBy('name')->get();
        foreach ($permissions as $permission) {
            echo "Permission::create(['name' => '" . $permission->name . "', 'description' => '" . addslashes($permission->description) . "']);\n";
        }

        // get all roles
        $roles = Role::whereNotIn('name',['god'])->with('permissions')->orderBy('name')->get();
        foreach ($roles as $role) {
            echo "\n\$role = Role::create(['name' => '" . $role->name . "', 'description' => '" . $role->description . "']);\n";
            foreach ($role->permissions as $permission) {
                echo "\$role->givePermissionTo('" . $permission->name . "');\n";
            }
        }

        echo "\n\n// GOD LIKE\n";
        echo "\$role = Role::create(['name' => 'god', 'description' => 'God Mode !']);\n";
        echo "\$role->givePermissionTo(Permission::all());\n";
        return Command::SUCCESS;
    }
}
