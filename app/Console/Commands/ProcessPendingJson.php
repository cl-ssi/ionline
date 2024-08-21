<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\WebService\PendingJsonToInsert;

class ProcessPendingJson extends Command
{
    protected $signature = 'process:pending-json';

    protected $description = 'Process pending JSON data and insert new, delete missing entries in database';

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

        $this->info('Proceso completado.');
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

        DB::transaction(function () use ($modelRoute, $jsonData, $columnMapping, $primaryKeys, $record) {
            $modelInstance = new $modelRoute;
            $existingRecords = $modelInstance->all();

            $newEntries = [];
            $existingKeys = [];

            $insertsCount = 0;
            $deletesCount = 0;

            foreach ($jsonData as $data) {
                $attributes = [];
                $primaryKeyValues = [];

                foreach ($columnMapping as $jsonKey => $columnName) {
                    $attributes[$columnName] = $data[$jsonKey];

                    // Construir las claves primarias para la búsqueda
                    if (isset($primaryKeys[$columnName])) {
                        $primaryKeyValues[$columnName] = $data[$jsonKey];
                    }
                }

                // Verificar si ya existe un registro con las mismas claves primarias
                $existingRecord = $modelInstance->where($primaryKeyValues)->first();

                if (!$existingRecord) {
                    // Crear un nuevo registro si no existe
                    $modelInstance->create($attributes);
                    $insertsCount++;
                }

                // Guardar las claves primarias procesadas para su comparación posterior
                $existingKeys[] = $primaryKeyValues;
                $newEntries[] = $attributes;
            }

            // Eliminar registros existentes que no estén en el nuevo conjunto de datos
            foreach ($existingRecords as $existingRecord) {
                $recordKeyValues = [];
                foreach ($primaryKeys as $column => $isPrimaryKey) {
                    $recordKeyValues[$column] = $existingRecord->{$column};
                }

                if (!in_array($recordKeyValues, $existingKeys)) {
                    $existingRecord->delete();
                    $deletesCount++;
                }
            }

            $record->update(['procesed' => 1]); // Marcar el registro como procesado

            if ($insertsCount > 0 || $deletesCount > 0) {
                $this->info("$insertsCount registros insertados y $deletesCount registros eliminados en $modelRoute.");
            } else {
                $this->info("No hubo modificaciones en la tabla $modelRoute.");
            }
        });
    }
}
