<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Drugs\Protocol;

class AddSubstanceResult extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-substance-result';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach(Protocol::all() as $protocol){
            if($protocol->result == 'Positivo' && $protocol->receptionItem->result_substance_id == null){
                $protocol->receptionItem->result_substance_id = 23; // FIXME: Corregir en futuro
                $protocol->receptionItem->save();
            }
        }
    }
}
