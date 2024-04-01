<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportMDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:mdb {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from an MDB file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $file = $this->argument('file');
        $command = "mdb-export $file Registros | cut -d',' -f6 | head -n 2 | tail -n 1";

        $output = shell_exec($command);

        // elimina del output "2024" las doble comillas
        $tabla = str_replace('"', '', trim($output))."rems";

        // dd($tabla);
        $command = "mdb-export -I mysql /home/atorres/02A21022024.mdb Datos | sed 's/INTO `Datos`/INTO `$tabla`/'";
        $output = shell_exec($command);
        
        $connection = DB::connection('mysql_rem');

        // vaciar la tabla $tabla de mysql
        $connection->table($tabla)->truncate();

        // Procesar la salida y ejecutar cada instrucción SQL generada por mdb-export
        // Este es un ejemplo básico, asegúrate de procesar y validar correctamente el SQL para evitar problemas de seguridad
        foreach (explode("\n", $output) as $sql) {
            if (!empty($sql)) {
                // Ejecutar el SQL en la base de datos "rems"
                try {
                    $connection->unprepared($sql);
                } catch (\Exception $e) {
                    $this->error("Error ejecutando SQL: " . $e->getMessage());
                    return;
                }
            }
        }

        $this->info("Datos importados con éxito a la base de datos $tabla.");

        return Command::SUCCESS;
    }
}
