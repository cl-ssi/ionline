<?php

namespace App\Http\Livewire\Welfare;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\models\Welfare\Abscence;
use App\Imports\AbscencesImport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\User;

use App\Models\Rrhh\SirhActiveUser;

class AmipassAbscencesImport extends Component
{
    use WithFileUploads;

    public $file;
    public $message2;

    public function save()
    {
        $this->message2 = "";
        $this->validate([
            'file' => 'required|file|mimes:xls,xlsx|max:10240', // 10MB Max
        ]);

        

        $file = $this->file;
        $collection = Excel::toCollection(new AbscencesImport, $file);

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

                        Abscence::updateOrCreate([
                            'rut' => $column['rut'],
                            'fecha_inicio' => $finicio,
                            'fecha_termino' => $ftermino
                        ],[
                            'rut' => $column['rut'],
                            'dv' => $column['dv'],
                            'nombre' => $column['nombre'],
                            'ley' => $column['ley'],
                            'edad_años' => $column['edadanos'],
                            'edad_meses' => $column['edadmeses'],
                            'afp' => $column['afp'],
                            'salud' => $column['salud'],
                            'codigo_unidad' => $column['codigo_unidad'],
                            'nombre_unidad' => $column['nombre_unidad'],
                            'genero' => $column['genero'],
                            'cargo' => $column['cargo'],
                            'calidad_juridica' => $column['calidad_juridica'],
                            'planta' => $column['planta'],
                            'nro_resolucion' => $column['n_resolucion'],
                            'fecha_resolucion' => $fresolucion,
                            'fecha_inicio' => $finicio,
                            'fecha_termino' => $ftermino,
                            'total_dias_auscentismo' => $column['total_dias_ausentismo'],
                            'auscentismo_en_el_periodo' => $column['ausentismo_en_el_periodo'],
                            'costo_de_licencia' => $column['costo_de_licencia'],
                            'tipo_de_auscentismo' => $column['tipo_de_ausentismo'],
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

        $this->message2 = 'Se ha cargado correctamente el archivo (De un total de ' . $total_count . ' registros, se registraron ' . 
        $count_inserts . ' registros con auscentismos).';
    }

    public function render()
    {
        return view('livewire.welfare.amipass-abscences-import');
    }
}
