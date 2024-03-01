<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Finance\Dte;
use App\Models\Finance\PurchaseOrder\Prefix;

class DteUpdateEstabishment_id extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dte:update_establishment_id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para actualizar los establecimientos id de las dtes de acuerdo del prefixo de la OC';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dtes = Dte::all();
        foreach ($dtes as $dte) {
            if(($dte->establishment_id == '' || $dte->establishment_id == null) and ($dte->folio_oc !=null)){ 
                $dte->establishment_id = Prefix::getEstablishmentIdFromPoCode($dte->folio_oc);
                $dte->save();
                $this->info('ID de DTE actualizado: ' . $dte->id);
            }
        }

        return Command::SUCCESS;
    }
}
