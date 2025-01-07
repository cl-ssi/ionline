<?php

namespace App\Models\Indicators;

use App\Jobs\ProcessSqlLine;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Rem extends Model
{
    protected $connection = 'mysql_rem';

    protected $year = null;

    public function setYear($year)
    {
        $this->year = $year;
        if ($year != null) {
            $this->table = $year.'rems';
        }
    }

    public static function year($year)
    {
        $instance = new static;
        $instance->setYear($year);

        return $instance->newQuery();
    }

    public function newInstance($attributes = [], $exists = false)
    {
        $model = parent::newInstance($attributes, $exists);
        $model->setYear($this->year);

        return $model;
    }

    public function prestacion(): BelongsTo
    {
        $instance = new Prestacion;
        $instance->setYear($this->year);

        return new BelongsTo($instance->newQuery(), $this, 'CodigoPrestacion', 'codigo_prestacion', 'prestacion');
    }

    public function establecimiento(): BelongsTo
    {
        $instance = new Establecimiento;
        $instance->setYear($this->year);

        return new BelongsTo($instance->newQuery(), $this, 'IdEstablecimiento', 'Codigo', 'establecimiento');
    }

    /**
     * Importa un archivo MDB desde un archivo ZIP.
     *
     * @param  \Illuminate\Http\UploadedFile  $originalFile  El archivo ZIP subido.
     * @return void
     */
    public static function importMdb($originalFile)
    {
        /**
         * Este metodo tiene las siguientes etapas:
         * ====================================================================
         * 1. Guardar el archivo ZIP
         * 2. Descomprimirlo
         * 3. Revisar si el archivo mdb contiene un año válido (el actual o anterior)
         * 4. Exportar el contenido del archivo MDB a SQL y reemplazar el nombre de la tabla
         * 5. Limpiar la tabla de datos existentes para la serie específica
         * 6. Despachar trabajos para procesar cada archivo SQL temporal
         */

        // Reemplaza los espacios en el nombre del archivo ZIP con guiones bajos
        $safeZipFilename = str_replace(' ', '_', $originalFile->getClientOriginalName());
        // Cambia la extensión del archivo de ZIP a MDB
        $safeMdbFilename = str_replace('zip', 'mdb', $safeZipFilename);

        // Define las rutas de almacenamiento para los archivos ZIP y MDB
        $zipFilePath = storage_path("app/rems/$safeZipFilename");
        $mdbFilePath = storage_path("app/rems/$safeMdbFilename");

        // 1. Almacena el archivo ZIP en el directorio 'rems'
        $originalFile->storeAs('rems', $safeZipFilename, 'local');

        // 2. Abre y extrae el archivo ZIP
        $zip = new \ZipArchive;
        $res = $zip->open($zipFilePath);

        if ($res === true) {
            $zip->extractTo(storage_path('app/rems'));
            $zip->close();
        } else {
            // Notifica al usuario si hay un error al extraer el archivo ZIP
            Notification::make()
                ->title('Error al extraer el ZIP')
                ->danger()
                ->send();
            return;
        }

        // Verifica si el archivo MDB existe después de la extracción
        if (file_exists($mdbFilePath)) {
            // Obtiene el año del archivo MDB
            $command = "mdb-export $mdbFilePath Registros | cut -d',' -f6 | head -n 2 | tail -n 1 | tr -d '\"'";
            $year    = trim(shell_exec($command));

            // Obtiene la serie del archivo MDB
            $command = "mdb-export $mdbFilePath Registros | cut -d',' -f3 | head -n 2 | tail -n 1 | tr -d '\"' |cut -d' ' -f2";
            $serie   = trim(shell_exec($command));

            // Define el nombre de la tabla en la base de datos
            $tabla = "{$year}rems";

            // Salir si el año es menor que el año pasado
            if ($year < date('Y') - 2) {
                Notification::make()
                    ->title('Error: Año incorrecto, debe estar entre el año actual y el anterior')
                    ->danger()
                    ->send();
                return;
            }

            // 4. Exporta el contenido del archivo MDB a SQL y reemplaza el nombre de la tabla
            $command    = "mdb-export -I mysql $mdbFilePath Datos | sed 's/INTO `Datos`/INTO `$tabla`/'";
            $sqlContent = shell_exec($command);

            // Divide el contenido SQL en líneas individuales y las guarda en archivos temporales
            $sqlLines = explode(";\n", $sqlContent);
            foreach ($sqlLines as $index => $sql) {
                if (stripos($sql, 'INSERT INTO') !== false) {
                    $tempSqlFile = storage_path("app/rems/sql_line_$index.sql");
                    file_put_contents($tempSqlFile, $sql.";\n");
                }
            }

            // 5. Borra los datos existentes en la tabla para la serie específica
            $connection = DB::connection('mysql_rem');
            $sql        = "DELETE FROM $tabla WHERE codigoprestacion IN (SELECT codigo_prestacion FROM {$year}prestaciones WHERE serie='$serie')";
            $connection->statement($sql);

            // 6. Despacha trabajos para procesar cada archivo SQL temporal
            $files = glob(storage_path('app/rems/sql_line_*.sql'));
            foreach ($files as $file) {
                $content = file_get_contents($file);
                ProcessSqlLine::dispatch($content);
                unlink($file);
            }

            // Elimina los archivos ZIP y MDB después de procesarlos
            unlink($mdbFilePath);
            unlink($zipFilePath);

            // Notifica al usuario que el proceso se completó con éxito
            Notification::make()
                ->title('Se está procesando el archivo MDB en la cola '.$safeMdbFilename)
                ->success()
                ->send();
        } else {
            // Notifica al usuario si el archivo MDB no se encuentra
            Notification::make()
                ->title('Error, no se encuentra el archivo MDB: '.$safeMdbFilename)
                ->danger()
                ->send();
            return;
        }
    }
}
