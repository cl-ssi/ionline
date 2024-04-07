<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class SetRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:role {rol_name}';

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
        $rol_name = $this->argument('rol_name');

        // Get all permissions from rol {rol_name}
        $permissions = Role::findByName($rol_name)->permissions;

        // Obtener todos los usuarios que tengan el conjunto de permisos $permissions
        $users = User::permission($permissions)->get();

        foreach ($users as $user) {
            // set the rol {rol_name} to the user
            $user->assignRole($rol_name);
            echo "Set rol " . $rol_name . " to user: " . $user->shortName . "\n";
        }

        // Get all users whe have the rol {rol_name}
        $users = User::role($rol_name)->get();

        foreach ($users as $user) {
            foreach ($permissions as $permission) {
                $user->revokePermissionTo($permission);
            }
            echo "Revoked all permissions from user: " . $user->shortName . "\n";
        }

        return Command::SUCCESS;
    }
}
