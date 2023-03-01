<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\BirthdayGreeting as BirthdayGreetingMail;
use App\Models\Commune;
use Illuminate\Support\Facades\Mail;

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
        Mail::to("sick_iqq@hotmail.com")->send(new BirthdayGreetingMail());
        // Commune::create(['name'=>'prueba_correo']);
    }
}
