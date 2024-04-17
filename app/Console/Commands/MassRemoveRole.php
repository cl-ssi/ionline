<?php

namespace App\Console\Commands;

use App\Models\User;
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
    protected $description = 'Elimina roles masivamente a los usuarios que tengan el rol pasado como parametro';

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
        $ct = 1;

        // Por cada usuario, quitarle el ROLE
        foreach ($users as $user) {
            $user->removeRole($rol_name);
            echo $ct . " Removed rol " . $rol_name . " from user: " . $user->shortName . "\n";
            $ct++;
        }

        return Command::SUCCESS;
    }
}
