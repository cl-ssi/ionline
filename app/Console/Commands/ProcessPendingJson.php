<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\WebService\PendingJsonToInsert;

class ProcessPendingJson extends Command
{
    protected $signature = 'process:pending-json';

    protected $description = 'Process pending JSON data and insert into database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $pendingRecords = PendingJsonToInsert::where('procesed', 0)->get();

        foreach ($pendingRecords as $record) {
            try {
                $this->processRecord($record);
            } catch (\Exception $e) {
                $this->error('Error al procesar registro: ' . $e->getMessage());
            }
        }

        $this->info('Proceso completado.');
    }

    private function processRecord($record)
    {
        $modelRoute = $record->model_route;
        $jsonData = json_decode($record->data_json, true);
        $columnMapping = json_decode($record->column_mapping, true);

        // Verificar si el JSON tiene el formato correcto
        if (!is_string($modelRoute) || !is_array($jsonData) || !is_array($columnMapping)) {
            throw new \Exception('El JSON no tiene el formato correcto');
        }

        // Verificar si el modelo especificado existe
        if (!class_exists($modelRoute)) {
            throw new \Exception('El modelo especificado no existe');
        }

        // Verificar si el modelo especificado tiene las columnas especificadas en el mapeo
        $modelInstance = new $modelRoute;
        $modelColumns = $modelInstance->getConnection()->getSchemaBuilder()->getColumnListing($modelInstance->getTable());
        $mappedColumns = array_values($columnMapping);
        if (count(array_diff($mappedColumns, $modelColumns)) > 0) {
            throw new \Exception('El mapeo de columnas contiene nombres de columna no válidos para el modelo especificado');
        }

        // Insertar datos en la base de datos
        DB::transaction(function () use ($modelRoute, $jsonData, $columnMapping, $record) {
            $modelInstance = new $modelRoute;
            foreach ($jsonData as $data) {
                $modelAttributes = [];
                foreach ($columnMapping as $jsonKey => $columnName) {
                    $modelAttributes[$columnName] = $data[$jsonKey];
                }
                $modelInstance->create($modelAttributes);
            }
            $record->update(['procesed' => 1]); // Marcar el registro como procesado
            $this->info("Datos insertados en $modelRoute con éxito.");
        });
    }
}
