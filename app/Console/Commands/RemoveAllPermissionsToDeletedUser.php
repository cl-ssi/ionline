<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class RemoveAllPermissionsToDeletedUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove_permissions_deleted_user';

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
        // get all deleted users
        $users = User::onlyTrashed()->get();

        // por cada usuarios eliminar todos los roles y permisos
        foreach ($users as $u) {
            $u->syncRoles([]);
            $u->syncPermissions([]);
            echo "Removed all roles and permissions from user: " . $u->name . "\n";
        }

        return Command::SUCCESS;
    }
}
