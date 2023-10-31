<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class CheckEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:emails';

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
        $users = User::whereNotNull('email')->get();

        foreach ($users as $user) {

            // $user->email = strtolower($user->email);
            // $user->save();
            
            $email = $user->email;
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo $user->id .  ",";
                // Si el email no tiene un formato válido, imprímelo en pantalla
                // echo " Email no válido: " . $email . "\n";
            }

        }
        return Command::SUCCESS;
    }
}
