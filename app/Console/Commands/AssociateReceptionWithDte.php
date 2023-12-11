<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Finance\Receptions\Reception;
use App\Models\Finance\Dte;
use App\Models\File;

class AssociateReceptionWithDte extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AssociateReceptionWithDte';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $files = File::where('type','signed_file')
            ->whereHas('fileable')
            ->get();

        foreach ($files as $file) {
            $path = $file->storage_path;

            // Utilizando expresiones regulares para extraer el ID del DTE
            if (preg_match('/\/dte-(\d+)\.pdf/', $path, $matches)) {
                $dteId = $matches[1];
                $this->info("ID del DTE para el archivo {$file->id}: $dteId");

                $dte = DTE::find($dteId);
                if($dte->tipo_documento =='factura_electronica' or $dte->tipo_documento =='factura_exenta' or $dte->tipo_documento =='boleta_honorarios')
                {
                    $file->fileable->dte_id = $dteId;
                    $file->fileable->save();  
                }
                if($dte->tipo_documento =='guias_despacho')
                {
                    $file->fileable->guia_id = $dteId;
                    $file->fileable->save();
                }

            } else {
                $this->warn("No se encontró un ID de DTE válido en el archivo {$file->id}");
            }
        }

    





        return Command::SUCCESS;
    }
}
