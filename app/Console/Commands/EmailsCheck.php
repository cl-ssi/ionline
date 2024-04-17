<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User; // Asegúrate de importar el modelo User

class EmailsCheck extends Command
{
    protected $signature = 'emails:check';
    protected $description = 'Verifica y corrige correos mal formados';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            $email = strtolower(trim($user->email));

            if($email == '') {
                $user->email = null;
                $user->save();
            }
            else {
                // Filtro si el email está bien formado
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $this->error("Correo mal formado para el usuario {$user->name}: $email");
                    $correctedEmail = $this->ask('Ingresa el correo corregido o presiona Enter para omitir:');
                    
                    if (!empty($correctedEmail) && filter_var($correctedEmail, FILTER_VALIDATE_EMAIL)) {
                        $user->email = $correctedEmail;
                        $user->save();
                    } else {
                        $user->email = null;
                        $user->save();
                    }
                }
                else {
                    // Si estaba bien formado y el trim y pasarlo a minuscula tuvo algún efecto
                    // entonces guardo el mail
                    if($user->email != $email) {
                        $user->email = $email;
                        $user->save();
                    }
                }
            }
        }

        $this->info('Proceso completado.');
    }
}
