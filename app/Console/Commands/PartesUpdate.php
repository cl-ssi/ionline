<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Database\QueryException;

class PartesUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:PartesUpdate';

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

        // Parte::where('id','>',0)->update([
        //     'user_id' => null,
        //     'organizational_unit_id' => null,
        //     'signatures_file_id' => null,
        // ]);


        // Copiar(crear) columnas organizational_unit_id, user_id desde parte_events hacia partes
        try {
            \DB::statement("
                UPDATE partes 
                JOIN (
                    SELECT p.id as parte_id, e.user_id, e.organizational_unit_id
                    FROM partes p
                    JOIN parte_events e ON p.id = e.parte_id
                    WHERE p.organizational_unit_id IS NULL
                ) as subquery ON partes.id = subquery.parte_id
                SET partes.user_id = subquery.user_id, partes.organizational_unit_id = subquery.organizational_unit_id
            ");
        
            echo "La consulta se ejecutó correctamente.\n";
        } catch (QueryException $e) {
            echo "Ocurrió un error al ejecutar la consulta: " . $e->getMessage();
        }

        // crear signatures_file_id en partes y migrar desde la tabla parte_files
        try {
            \DB::statement("
            UPDATE partes
            JOIN parte_files ON partes.id = parte_files.parte_id
            SET partes.signatures_file_id = parte_files.signature_file_id
            WHERE parte_files.signature_file_id IS NOT NULL
            AND parte_files.deleted_at IS null");
        
            echo "La consulta se ejecutó correctamente.\n";
        } catch (QueryException $e) {
            echo "Ocurrió un error al ejecutar la consulta: " . $e->getMessage();
        }

        // pasar event_files a la tabla file genérica
        try {
            \DB::statement("
            INSERT INTO files (storage_path, `name`, fileable_id, `stored`, stored_by_id, fileable_type, created_at, updated_at, deleted_at)
            SELECT pf.file, pf.name, pf.parte_id, 1, p.user_id, 'App\\\Models\\\Documents\\\Parte', pf.created_at, pf.updated_at, pf.deleted_at
            FROM parte_files pf
            LEFT JOIN partes p ON pf.parte_id = p.id;");
        
            echo "La consulta se ejecutó correctamente.\n";
        } catch (QueryException $e) {
            echo "Ocurrió un error al ejecutar la consulta: " . $e->getMessage();
        }


        

        
        return Command::SUCCESS;
    }
}
