<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Auth;
use Illuminate\Console\Command;
use App\Models\User;

class RemoveDefaultPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:passwords';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove default and weak passwords';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::all();
        foreach($users as $user) {
            if(Auth::guard('web')->attempt(['id'=> $user->id, 'password' => $user->id])){
                echo '[default] '.$user->shortName."\n";
                $user->password = null;
                $user->password_changed_at = null;
                $user->save();
            }
            // if(Auth::guard('web')->attempt(['id' => $user->id, 'password' => 'salud123'])){
            //     echo '[salud123] '.$user->shortName."\n";
            //     $user->password_changed_at = null;
            //     $user->save();
            // }
            // if(Auth::guard('web')->attempt(['id' => $user->id, 'password' => 'Salud123'])){
            //     echo '[Salud123] '.$user->shortName."\n";
            //     $user->password_changed_at = null;
            //     $user->save();
            // }
        }
        return Command::SUCCESS;
    }
}
