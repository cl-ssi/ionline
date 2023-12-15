<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Finance\Dte;

class FixReceptionDte extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'FixReceptionDte';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Arregla la relación creada de reception (cabecera), primero ejecutar antes FixReceptionGuia';

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
                    foreach ($dte->receptions as $reception)
                    {
                        if($dte->tipo_documento =='factura_electronica' or $dte->tipo_documento =='factura_exenta')
                            {
                            $this->info('Actualizando dte_id para el recepcions' . $reception->id);
                            $reception->dte_id = $dte->id;
                            $reception->save();                        
                        }
                    }
                    
                
            
         }

        $this->info('Proceso completado.');
        return Command::SUCCESS;
    }
}
