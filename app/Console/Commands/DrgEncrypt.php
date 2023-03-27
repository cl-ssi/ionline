<?php

namespace App\Console\Commands;


use App\Models\Drugs\Reception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Console\Command;



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

        $imputed = Reception::all();
        foreach($imputed as $imputed) {
            echo $imputed->imputed . "\n";
            $imputed->imputed = Crypt::encryptString($imputed->imputed);
            $imputed->imputed_run = Crypt::encryptString($imputed->imputed_run);
            $imputed->save();
        }
        
        return 0;
    }
}
