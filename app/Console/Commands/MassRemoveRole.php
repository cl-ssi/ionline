<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class MassRemoveRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mass-remove:role {rol_name}';

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
        // Lista todos los usuarios que tengan el ROLE pasado como parametro
        $rol_name = $this->argument('rol_name');
        $users = User::role($rol_name)->get();

        // Por cada usuario, quitarle el ROLE
        foreach ($users as $user) {
            $user->removeRole($rol_name);
            echo "Removed rol " . $rol_name . " from user: " . $user->shortName . "\n";
        }

        return Command::SUCCESS;
    }
}
