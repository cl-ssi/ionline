<?php

namespace App\Livewire\Rem;

use App\Jobs\ProcessSqlLine;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use ZipArchive;

class ImportMdb extends Component
{
    use WithFileUploads;

    public $file;
    public $info = [];

    protected $rules = [
        'file' => 'required|mimes:zip|max:62288',
    ];

    protected $messages = [
        'file.required' => 'El nombre es requerido.',
        'file.mimes' => 'El archivo subido debe ser de tipo ZIP.',
        'file.max' => 'No puede ser mayor a 62MB',
    ];

    public function save()
    {
        $this->validate();

        /**
         * ATENCIÓN DESARROLLADORES:
         * ====================================================================
         * ESTE SCRIPT UTILIZA UNA APLICACIÓN DE TERCEROS QUE DEBE SER INSTALADA
         * Instalar MDB-TOOLS, para poder ejecutar mdb-export
         * $ mdb-export --version 
         */

        // $this->info['mdb-export'] = shell_exec("mdb-export --version");
        //$filename = '02A20032024.mdb';

        $originalFilename = $this->file->getClientOriginalName();
        $safeFilename = str_replace(' ', '_', $originalFilename);

        $this->file->storeAs('rems', $safeFilename, 'local');
        $this->info['step1'] = 'Archivo almacenado temporalmente';

        if ($this->extractZipFile($safeFilename)) {
            $mdbFilename = $this->prepareMdbFile($originalFilename);

            if ($mdbFilename && file_exists($mdbFilename)) {
                $this->processMdbFile($mdbFilename);
                $this->dispatchJobs();
                $this->cleanupTemporaryFiles([$mdbFilename, "storage/app/rems/$safeFilename"]);

                $this->info['Fin'] = "Proceso terminado exitosamente";
                session()->flash('status', 'success');
            } else {
                $this->info['step3'] = 'Error: El archivo mdb no existe';
                session()->flash('status', 'danger');
            }
        } else {
            $this->info['step2'] = "Error: al descomprimir el archivo";
            session()->flash('status', 'danger');
        }

        session()->flash('message', $this->info);
        return redirect(request()->header('Referer'));
    }

    private function extractZipFile($safeFilename)
    {
        $zip = new ZipArchive;
        $res = $zip->open(storage_path("app/rems/$safeFilename"));

        if ($res === TRUE) {
            $zip->extractTo(storage_path('app/rems'));
            $zip->close();
            $this->info['step2'] = 'Archivo descomprimido';
            return true;
        }

        return false;
    }

    private function prepareMdbFile($originalFilename)
    {
        $mdbFilename = str_replace(['.zip', ' '], ['.mdb', '_'], $originalFilename);
        $fullpath = storage_path("app/rems/$mdbFilename");

        $oldPath = storage_path("app/rems/" . str_replace('.zip', '.mdb', $originalFilename));
        if ($oldPath !== $fullpath) {
            rename($oldPath, $fullpath);
        }

        return $fullpath;
    }

    private function processMdbFile($mdbFilename)
    {
        $year = $this->getMdbYear($mdbFilename);
        $serie = $this->getMdbSerie($mdbFilename);
        $this->info['step4'] = "Serie a procesar: $serie año $year";

        if ($year < date('Y') - 2) {
            $this->info['step5'] = 'Error: Año incorrecto, debe estar entre el año actual y el anterior';
            session()->flash('status', 'danger');
            return;
        }

        $tabla = "{$year}rems";
        $this->clearTableData($tabla, $year, $serie);
        $this->generateSqlFiles($mdbFilename, $tabla);
    }

    private function getMdbYear($mdbFilename): string
    {
        $command = "mdb-export $mdbFilename Registros | cut -d',' -f6 | head -n 2 | tail -n 1 | tr -d '\"'";
        return trim(shell_exec($command));
    }

    private function getMdbSerie($mdbFilename): string
    {
        $command = "mdb-export $mdbFilename Registros | cut -d',' -f3 | head -n 2 | tail -n 1 | tr -d '\"' |cut -d' ' -f2";
        return trim(shell_exec($command));
    }

    private function clearTableData($tabla, $year, $serie)
    {
        $connection = DB::connection('mysql_rem');
        $sql = "DELETE FROM $tabla WHERE codigoprestacion IN (SELECT codigo_prestacion FROM {$year}prestaciones WHERE serie='$serie')";
        $connection->unprepared($sql);
        $this->info['step6'] = "Borrar los datos de la serie: $serie de la tabla: $tabla";
    }

    private function generateSqlFiles($mdbFilename, $tabla)
    {
        $command = "mdb-export -I mysql $mdbFilename Datos | sed 's/INTO `Datos`/INTO `$tabla`/'";
        $sqlContent = shell_exec($command);
        $this->info['step5'] = "Generando archivos SQL para cada línea";

        $sqlLines = explode(";\n", $sqlContent);
        foreach ($sqlLines as $index => $sql) {
            if (stripos($sql, 'INSERT INTO') !== false) {
                $tempSqlFile = storage_path("app/rems/sql_line_$index.sql");
                file_put_contents($tempSqlFile, $sql . ";\n");
            }
        }

        $this->info['step7'] = "Se generaron " . count($sqlLines) . " archivos SQL individuales.";
    }

    private function dispatchJobs()
    {
        $files = glob(storage_path("app/rems/sql_line_*.sql"));

        foreach ($files as $file) {
            $content = file_get_contents($file);
            logger()->info($file);
            ProcessSqlLine::dispatch($content);
            unlink($file); // Elimina el archivo después de despacharlo
        }
    }

    private function cleanupTemporaryFiles($files)
    {
        foreach ($files as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }

        $this->info['step8'] = "Archivos temporales eliminados";
    }

    public function render()
    {
        return view('livewire.rem.import-mdb');
    }
}
