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
                // Si ocurre un error, marcar el registro como procesado y agregar el mensaje de error al campo data_json
                $record->update(['procesed' => 1, 'data_json' => 'Error - fecha hora: ' . now()->toDateTimeString() . ' - ' . $e->getMessage()]);
            }
        }

        // $this->info('Proceso completado.');
    }

    private function processRecord($record)
    {
        $modelRoute = $record->model_route;
        $jsonData = json_decode($record->data_json, true);
        $columnMapping = json_decode($record->column_mapping, true);
        $primaryKeys = json_decode($record->primary_keys, true);

        // Verificar si el JSON tiene el formato correcto
        if (!is_string($modelRoute) || !is_array($jsonData) || !is_array($columnMapping) || !is_array($primaryKeys)) {
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
        DB::transaction(function () use ($modelRoute, $jsonData, $columnMapping, $primaryKeys, $record) {
            $modelInstance = new $modelRoute;
            foreach ($jsonData as $data) {
                $attributes = [];
                foreach ($columnMapping as $jsonKey => $columnName) {
                    $attributes[$columnName] = $data[$jsonKey];
                }
                
                // Verificar si ya existe un registro con las mismas claves primarias
                $existingRecord = $modelInstance;
                foreach ($primaryKeys as $column => $isPrimaryKey) {
                    $existingRecord = $existingRecord->where($column, $attributes[$column]);
                }
                $existingRecord = $existingRecord->first();

                // Si no existe un registro con las mismas claves primarias, se crea uno nuevo
                if (!$existingRecord) {
                    $modelInstance->create($attributes);
                }
            }
        });

        $record->update(['procesed' => 1]); // Marcar el registro como procesado
        $this->info("Datos insertados en $modelRoute.");
    }


}
