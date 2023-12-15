<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Finance\Dte;

class FixReceptionGuia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'FixReceptionGuia';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Arregla la relación creada de reception (cabecera), primero ejecutar esta antes del FixReceptionDte';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Iniciando el proceso...');
        $dtes = DTE::all();
        foreach ($dtes as $dte) {
            if($dte->receptionsDte)
            {
                if($dte->tipo_documento =='guias_despacho')
                {
                    foreach ($dte->receptionsDte as $reception)
                    {
                        $this->info('Actualizando guia_id para el recepcions ' . $reception->id);
                        $reception->guia_id = $dte->id;
                        $reception->save();
                    }
                }
            }
         }

        $this->info('Proceso completado.');
        return Command::SUCCESS;
    }
}
