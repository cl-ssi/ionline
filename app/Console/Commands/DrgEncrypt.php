<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Console\Command;
use App\Models\Commune;

class DrgEncrypt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'drg:encrypt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        /** Crear un comando */
        // php artisan make:command DrgEncrypt



        /** Atributo del modelo para encryptar */

        // protected $casts = [
        //     'name' => 'encrypted'
        // ];


        /** Listar comunas */
        /** No olvidar importar la clase Commune arriba */
        $communes = Commune::all();

        foreach($communes as $commune) {
            echo $commune->name . "\n";
            $commune->name = Crypt::encryptString($commune->name);
            $commune->save();
        }
        
        return 0;
    }
}
