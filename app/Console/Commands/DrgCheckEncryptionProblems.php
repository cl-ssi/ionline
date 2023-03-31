<?php

namespace App\Console\Commands;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Console\Command;
use App\Models\Drugs\Reception;

class DrgCheckEncryptionProblems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'drg:checkencryption';

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
        $receptions = Reception::all();
        $ct = 1;
        foreach($receptions as $reception) {
            try {
                $imputed = $reception->imputed . $reception->imputed_run;
            } catch (DecryptException $e) {
                echo "Error $ct en Acta ID: " . $reception->id . " ";
                print_r($e->getMessage());
                echo "\n";
                $ct++;
            }
        }

        // return 0;
    }
}
