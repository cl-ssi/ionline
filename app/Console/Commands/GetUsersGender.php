<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WebService\Fonasa;

use App\Models\User;

class GetUsersGender extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:usersGender';

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
        User::disableAuditing();

        $count_inserts = 0;
        $count_search = 0;
        $users = User::withTrashed()->whereNull('gender')->get();
        $total = $users->count();
        print('Total encontrados:'. $total . " \n");
        foreach($users as $user){
            
            $count_search += 1;
            $fonasaUser = Fonasa::find((string)$user->id."-".$user->dv);
            
            if(!isset($fonasaUser->message)){

                if($fonasaUser->gender != null or $fonasaUser->gender != ""){
                    if($fonasaUser->gender == "Masculino"){
                        $user->gender = "male";
                    }
                    elseif($fonasaUser->gender == "Femenino"){
                        $user->gender = "female";
                    }
                    $user->save();
                    $count_inserts += 1;
                }
            }
            sleep(1);
            
            print((100 * $count_search / $total) . "% \n" );
        }

        User::enableAuditing();
        
        print("De un total de " . $count_search . " usuarios, se modificó el genero de " . $count_inserts . " funcionarios.");
        return Command::SUCCESS;
    }
}
