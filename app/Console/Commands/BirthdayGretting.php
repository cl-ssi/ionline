<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\BirthdayGreeting as BirthdayGreetingMail;
use App\Models\Commune;
use Illuminate\Support\Facades\Mail;

use App\User;
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
        // $users = User::where('active',1)
        //             ->whereMonth('birthday', Carbon::now()->format('m'))
        //             ->whereDay('birthday', Carbon::now()->format('d'))
        //              ->whereNotNull('email_personal')
        //             ->get();

        // foreach($users as $user){
        //     Mail::to($user->email)->send(new BirthdayGreetingMail($user));
        // }
        
        // $users = SirhActiveUser::whereMonth('birthdate', Carbon::now()->format('m'))
        //             ->whereDay('birthdate', Carbon::now()->format('d'))
        //             ->whereNotNull('email')
        //             ->get();

        // foreach($users as $user){
        //     Mail::to($user->email)->send(new BirthdayGreetingMail($user));
        // }
        
        
        // de prueba
        $users = User::where('id',17430005)->get();
        foreach($users as $user){
            Mail::to($user->email)->send(new BirthdayGreetingMail($user));
        }

        
        

    }
}
