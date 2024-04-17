<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\BirthdayGreeting as BirthdayGreetingMail;
use App\Mail\BirthdayGreetingSirhActiveUser;
use App\Models\Commune;
use Illuminate\Support\Facades\Mail;

use App\Models\User;
use App\Models\Rrhh\SirhActiveUser;
use Carbon\Carbon;

class BirthdayGretting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:birthdayGretting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía correo de saludo de cumpleaños a funcionarios del SSI.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // encuentra usuarios que están de cumpleaños el día de hoy
        $users = User::where('active',1)
                    ->whereMonth('birthday', Carbon::now()->format('m'))
                    ->whereDay('birthday', Carbon::now()->format('d'))
                     ->whereNotNull('email_personal')
                    ->get();

        foreach($users as $user){
            if($user->checkEmailFormat()){
                Mail::to($user->email_personal)->send(new BirthdayGreetingMail($user));
                Mail::to('sick_iqq@hotmail.com')->send(new BirthdayGreetingMail($user));
            }else{
                logger()->info('Error en el formato de correo del usuario ID: ' . $user->id);
            }
        }
        
        $users = SirhActiveUser::whereMonth('birthdate', Carbon::now()->format('m'))
                    ->whereDay('birthdate', Carbon::now()->format('d'))
                    ->whereNotNull('email')
                    ->get();

        foreach($users as $user){
            if($user->checkEmailFormat()){
                Mail::to($user->email)->send(new BirthdayGreetingSirhActiveUser($user));
                Mail::to('sick_iqq@hotmail.com')->send(new BirthdayGreetingSirhActiveUser($user));
            }else{
                logger()->info('Error en el formato de correo del usuario ID: ' . $user->id);
            }
        }
        
        
        // // de prueba
        // $users = User::where('id',17430005)->get();
        // foreach($users as $user){
        //     Mail::to($user->email)->send(new BirthdayGreetingMail($user));
        // }

    }
}
