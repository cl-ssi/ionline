<?php

namespace App\Livewire\Rem;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
        'file.mimes' => 'Al archivo subido debe ser de tipo ZIP.',
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

        $zip = new ZipArchive;
        $res = $zip->open(storage_path("app/rems/$safeFilename"));

        if ($res === TRUE) {
            $zip->extractTo(storage_path('app/rems'));
            $zip->close();
            $this->info['step2'] = 'Archivo descomprimido';

            // Reemplazar .zip por .mdb y espacios por guiones bajos
            $mdbFilename = str_replace(['.zip', ' '], ['.mdb', '_'], $originalFilename);
            $fullpath = storage_path("app/rems/$mdbFilename");

            // Renombrar el archivo descomprimido si tiene espacios
            $oldPath = storage_path("app/rems/" . str_replace('.zip', '.mdb', $originalFilename));
            if ($oldPath !== $fullpath) {
                rename($oldPath, $fullpath);
            }

            // check if file exists
            if (file_exists($fullpath)) {
                $this->info['step3'] = 'Archivo mdb encontrado';

                // Obtiene el año del archivo mdb
                $command = "mdb-export $fullpath Registros | cut -d',' -f6 | head -n 2 | tail -n 1 | tr -d '\"'";
                $year = trim(shell_exec($command));
                
                // Obtiene la serie del archivo mdb
                $command = "mdb-export $fullpath Registros | cut -d',' -f3 | head -n 2 | tail -n 1 | tr -d '\"' |cut -d' ' -f2";
                $serie = trim(shell_exec($command));
                $this->info['step4'] = "Serie a procesar: $serie año $year";

                // $year tiene que estar entre el año actual y el anterior
                if ( $year < date('Y') - 10) {
                    $this->info['step5'] = 'Error: Año incorrecto, debe estar entre el año actual y el anterior';
                    session()->flash('status','danger');
                    return;
                }
                $tabla = "{$year}rems";

                $command = "mdb-export -I mysql $fullpath Datos | sed 's/INTO `Datos`/INTO `$tabla`/'";
                $output = shell_exec($command);
                $this->info['step5'] = "Obteniendo los datos de la tabla Datos";

                $connection = DB::connection('mysql_rem');

                // vaciar la tabla $tabla de mysql
                // $connection->table($tabla)->truncate();

                // Borrar solo los datos de la serie
                $sql = "DELETE FROM $tabla WHERE codigoprestacion IN (SELECT codigo_prestacion FROM {$year}prestaciones WHERE serie='$serie')";
                $connection->unprepared($sql);
                // $this->info['sql'] = $sql;

                $this->info['step6'] = "Borrar los datos de la serie: $serie de la tabla: $tabla";

                // Procesar la salida y ejecutar cada instrucción SQL generada por mdb-export
                foreach (explode("\n", $output) as $sql) {
                    if (!empty($sql)) {
                        // Ejecutar el SQL en la $tabla
                        try {
                            $connection->unprepared($sql);
                        } catch (\Exception $e) {
                            $this->error("Error ejecutando SQL: " . $e->getMessage());
                            return;
                        }
                    }
                }
                $this->info['step7'] = "Cargados los Datos a la tabla $tabla";
                $this->info['Fin'] = "Proceso terminado exitosamente";
                session()->flash('status','success');
            }
            else {
                $this->info['step3'] = 'Error: El archivo mdb no existe';
                session()->flash('status','danger');
            }
        } else {
            $this->info['step2'] = "Error: al descomprimir el archivo: $res";
            session()->flash('status','danger');
        }

        session()->flash('message', $this->info);
        // Return redirect a la misma pagina
        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.rem.import-mdb');
    }
}
