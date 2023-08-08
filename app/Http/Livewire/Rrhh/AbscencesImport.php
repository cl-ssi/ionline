<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\models\Rrhh\Absenteeism;
use App\Imports\AbscencesImport as AbscencesImportFile;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\User;

use App\Models\Rrhh\SirhActiveUser;

class AbscencesImport extends Component
{
    use WithFileUploads;

    public $file;
    public $message2;

    public function save()
    {
        $this->message2 = "";
        $this->validate([
            'file' => 'required|file|mimes:csv|max:10240', // 10MB Max
        ]);

        $file = $this->file;
        $collection = Excel::toCollection(new AbscencesImportFile, $file);

        $total_count = $collection->first()->count()+1;
        $count_inserts = 0;

        foreach($collection as $row){

            foreach($row as $key => $column){ 
                
                if(array_key_exists('rut', $column->toArray()))
                {
                    if($column['rut']!=null)
                    {
                        $fresolucion = null;
                        $val = trim($column['fresolucion']);
                        if($val){
                            $val = explode("/",$val)[2]."-".explode("/",$val)[1]."-".explode("/",$val)[0];
                            $fresolucion = new Carbon($val);
                        }  

                        $val = trim($column['finicio']);
                        $val = explode("/",$val)[2]."-".explode("/",$val)[1]."-".explode("/",$val)[0];
                        $finicio = new Carbon($val);

                        $val = trim($column['ftermino']);
                        $val = explode("/",$val)[2]."-".explode("/",$val)[1]."-".explode("/",$val)[0];
                        $ftermino = new Carbon($val);

                        Absenteeism::updateOrCreate([
                            'rut' => $column['rut'],
                            'finicio' => $finicio,
                            'ftermino' => $ftermino
                        ],[
                            'rut' => $column['rut'],
                            'dv' => $column['dv'],
                            'nombre' => $column['nombre'],
                            'ley' => $column['ley'],
                            'edadanos' => $column['edadaos'],
                            'edadmeses' => $column['edadmeses'],
                            'afp' => $column['afp'],
                            'salud' => $column['salud'],
                            'codigo_unidad' => $column['codigo_unidad'],
                            'nombre_unidad' => $column['nombre_unidad'],
                            'genero' => $column['genero'],
                            'cargo' => $column['cargo'],
                            'calidad_juridica' => $column['calidad_juridica'],
                            'planta' => $column['planta'],
                            'n_resolucion' => $column['n_resolucion'],
                            'fresolucion' => $fresolucion,
                            'finicio' => $finicio,
                            'ftermino' => $ftermino,
                            'total_dias_ausentismo' => $column['total_dias_ausentismo'],
                            'ausentismo_en_el_periodo' => $column['ausentismo_en_el_periodo'],
                            'costo_de_licencia' => $column['costo_de_licencia'],
                            'tipo_de_ausentismo' => $column['tipo_de_ausentismo'],
                            'codigo_de_establecimiento' => $column['codigo_de_establecimiento'],
                            'nombre_de_establecimiento' => $column['nombre_de_establecimiento'],
                            'saldo_dias_no_reemplazados' => $column['saldo_dias_no_reemplazados'],
                            'tipo_de_contrato' => $column['tipo_de_contrato']
                        ]);

                        $count_inserts += 1;
                        
                    }
                }
            }
            
        }

        $this->message2 = 'Se ha cargado correctamente el archivo (' . $count_inserts . ' registros).';
    }

    public function render()
    {
        return view('livewire.rrhh.abscences-import');
    }
}
