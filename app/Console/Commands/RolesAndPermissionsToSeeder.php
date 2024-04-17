<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
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
        $seederContent = "<?php\n\nnamespace Database\Seeders;\n\nuse Illuminate\\Database\\Seeder;\nuse Spatie\Permission\Models\Role;\nuse Spatie\Permission\Models\Permission;\n\nclass RoleAndPermissionSeeder extends Seeder\n{\n    public function run()\n    {\n";
    
        $seederContent .= "        Permission::create(['name' => 'be god', 'description' => 'God Mode !']);\n";
        $seederContent .= "        Permission::create(['name' => 'dev', 'description' => 'Developer']);\n";
        $seederContent .= "\n\n";

        // get all permissions
        $permissions = Permission::whereNotIn('name',['be god','dev'])->orderBy('name')->get();
        foreach ($permissions as $permission) {
            $seederContent .=  "        Permission::create(['name' => '" . $permission->name . "', 'description' => '" . addslashes($permission->description) . "']);\n";
        }

        // get all roles
        $roles = Role::whereNotIn('name',['god'])->with('permissions')->orderBy('name')->get();
        foreach ($roles as $role) {
            $seederContent .=  "\n        \$role = Role::create(['name' => '" . $role->name . "', 'description' => '" . $role->description . "']);\n";
            foreach ($role->permissions as $permission) {
                $seederContent .=  "        \$role->givePermissionTo('" . $permission->name . "');\n";
            }
        }

        $seederContent .=  "\n\n        // GOD LIKE\n";
        $seederContent .=  "        \$role = Role::create(['name' => 'god', 'description' => 'God Mode !']);\n";
        $seederContent .=  "        \$role->givePermissionTo(Permission::all());\n";

        $seederContent .= "    }\n}\n";

        File::put(database_path("seeders/RoleAndPermissionSeeder.php"), $seederContent);

        $this->info("Seeder RoleAndPermissionSeeder generado exitosamente.");
    }
}
