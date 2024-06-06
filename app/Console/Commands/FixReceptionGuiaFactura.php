<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Finance\Dte;

class FixReceptionGuiaFactura extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'FixReceptionGuiaFactura';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Añade a Reception la guia_id y dte_id asociado si tiene recepcion';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $this->info('Iniciando el proceso...');
        $dtes = Dte::with('receptions')->get();
        
        foreach ($dtes as $dte) {
            if($dte->tipo_documento == 'guias_despacho')
            {
                if($guia_despacho and $guia_despacho->receptions->first() and $guia_despacho->receptions->first()->dte_id == null and $guias_despacho)
                {

                }

            }

        }


        return Command::SUCCESS;
    }
}
