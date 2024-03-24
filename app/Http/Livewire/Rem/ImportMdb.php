<?php

namespace App\Http\Livewire\Rem;

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
        'file.mimes' => 'Debe ser de tipo ZIP.',
        'file.max' => 'No puede ser mayor a 62MB',
    ];

    public function save()
    {
        // $this->validate([
            
        // ]);

        // $filename = '02A21022024.zip';

        $filename = $this->file->getClientOriginalName();
        $this->file->storeAs('rems', $filename, 'local');

        // Descomprimir el archivo subido que es .zip
        $zip = new ZipArchive;
        $res = $zip->open(storage_path('app/rems/'.$filename));
        if ($res === TRUE) {
            $zip->extractTo(storage_path('app/rems'));
            $zip->close();
            $this->info['message'] = 'Archivo descomprimido';
        } else {
            $this->info['message'] = 'Error al descomprimir el archivo: '. $res;
        }

        // replace .zip to .mdb
        $filename = str_replace('.zip', '.mdb', $filename);

        $fullpath = storage_path('app/rems/'.$filename);
        $command = "mdb-export $fullpath Registros | cut -d',' -f6 | head -n 2 | tail -n 1";
        $this->info['comando'] = $command;

        $output = shell_exec($command);

        // elimina del output "2024" las doble comillas
        $tabla = str_replace('"', '', trim($output))."rems";
        $this->info['titulo'] = $tabla;

        $command = "mdb-export -I mysql $fullpath Datos | sed 's/INTO `Datos`/INTO `$tabla`/'";
        $output = shell_exec($command);
        
        // $connection = DB::connection('mysql_rem');

        // // vaciar la tabla $tabla de mysql
        // $connection->table($tabla)->truncate();

        // // Procesar la salida y ejecutar cada instrucción SQL generada por mdb-export
        // // Este es un ejemplo básico, asegúrate de procesar y validar correctamente el SQL para evitar problemas de seguridad
        // foreach (explode("\n", $output) as $sql) {
        //     if (!empty($sql)) {
        //         // Ejecutar el SQL en la base de datos "rems"
        //         try {
        //             $connection->unprepared($sql);
        //         } catch (\Exception $e) {
        //             $this->error("Error ejecutando SQL: " . $e->getMessage());
        //             return;
        //         }
        //     }
        // }


    }

    public function render()
    {
        return view('livewire.rem.import-mdb');
    }
}
