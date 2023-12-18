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
        $dtes = Dte::with('receptions')->get();
        foreach ($dtes as $dte) {
            if ($dte->receptions->isNotEmpty()) {
                if ($dte->tipo_documento == 'guias_despacho') {
                    foreach ($dte->receptions as $reception) {
                        $this->info('Actualizando guia_id para el recepcion ' . $reception->id);
                        $reception->guia_id = $dte->id;

                        if($reception->guia_id == $reception->dte_id) {
                            $reception->dte_id = null;
                        }

                        // Verificar si invoices no es null y tiene al menos un elemento
                        if ($dte->invoices && $dte->invoices->isNotEmpty()) {
                            $reception->dte_id = $dte->invoices->first()->id;
                        }

                        $reception->save();
                    }
                }
            }
        }

        $this->info('Proceso completado.');
        return Command::SUCCESS;
    }
}
