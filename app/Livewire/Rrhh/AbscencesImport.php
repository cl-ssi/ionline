<?php

namespace App\Livewire\Rrhh;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\Rrhh\Absenteeism;
use App\Models\Rrhh\AbsenteeismType;
use App\Imports\AbscencesImport as AbscencesImportFile;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Models\User;

use App\Models\Rrhh\SirhActiveUser;

class AbscencesImport extends Component
{
    use WithFileUploads;

    public $file;
    public $message2;
    public $non_existent_users;

    public function save()
    {
        set_time_limit(3600);
        ini_set('memory_limit', '1024M');

        $this->message2 = "";
        $this->validate([
            'file' => 'required|file|max:10240', // 10MB Max
        ]);

        $file = $this->file;
        $collection = Excel::toCollection(new AbscencesImportFile, $this->file->path());

        $total_count = $collection->first()->count()+1;
        $count_inserts = 0;
        if($total_count>2000){
            $this->message2 = "Sobrepasó el máximo de filas soportadas por el sistema (Máximo 2000).";
            return;
        }

        // obtiene los tipos de ausentismos que no están creados en ionline.
        $absenteeismTypes = AbsenteeismType::pluck('name')->toArray();
        $absenteeisms_in_file = array_unique(array_column( $collection->first()->toArray() , 'tipo_de_ausentismo' ));
        $absenteeisms_in_file = array_map('trim', $absenteeisms_in_file);
        $result = array_diff($absenteeisms_in_file, $absenteeismTypes);   

        // se debe crear los nuevos ausentismo
        foreach($result as $value){
            $absenteeismType = new AbsenteeismType();
            $absenteeismType->name = $value;
            $absenteeismType->discount = 1;
            $absenteeismType->save();
        }
        // se obtienen nuevamente los ausentismos, y se agregan en array, que será consultado en la iteración
        $arrayTypes = AbsenteeismType::pluck('id','name')->toArray();
        // dd($arrayTypes);

        // si es csv
        $insert_array = [];
        if(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION) == "csv"){
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

                            $insert_array[] = [
                                'rut' => $column['rut'],
                                'dv' => trim($column['dv']),
                                'nombre' => trim($column['nombre']),
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
                                'absenteeism_type_id' => $arrayTypes[trim($column['tipo_de_ausentismo'])],
                                'codigo_de_establecimiento' => $column['codigo_de_establecimiento'],
                                'nombre_de_establecimiento' => $column['nombre_de_establecimiento'],
                                'saldo_dias_no_reemplazados' => $column['saldo_dias_no_reemplazados'],
                                'tipo_de_contrato' => $column['tipo_de_contrato']
                            ];
                            $count_inserts += 1;
                            
                        }
                    }
                }
                
            }
        }
        // si es excel
        else{
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

                            $insert_array[] = [
                                'rut' => $column['rut'],
                                'dv' => trim($column['dv']),
                                'nombre' => trim($column['nombre']),
                                'ley' => $column['ley'],
                                'edadanos' => $column['edadanos'],
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
                                'fresolucion' => ($fresolucion!=null ? $fresolucion->format('Y-m-d H:i') : null),
                                'finicio' => $finicio->format('Y-m-d H:i'),
                                'ftermino' => $ftermino->format('Y-m-d H:i'),
                                'total_dias_ausentismo' => $column['total_dias_ausentismo'],
                                'ausentismo_en_el_periodo' => $column['ausentismo_en_el_periodo'],
                                'costo_de_licencia' => $column['costo_de_licencia'],
                                'tipo_de_ausentismo' => $column['tipo_de_ausentismo'],
                                'absenteeism_type_id' => $arrayTypes[trim($column['tipo_de_ausentismo'])],
                                'codigo_de_establecimiento' => $column['codigo_de_establecimiento'],
                                'nombre_de_establecimiento' => $column['nombre_de_establecimiento'],
                                'saldo_dias_no_reemplazados' => $column['saldo_dias_no_reemplazados'],
                                'tipo_de_contrato' => $column['tipo_de_contrato']
                            ];

                            $count_inserts += 1;
                        }
                    }
                }
                
            }
        }

        // dd($insert_array);
        Absenteeism::upsert(
                    $insert_array, 
                    ['rut', 'finicio','ftermino','absenteeism_type_id'], 
                    ['dv','nombre','ley','edadanos','edadmeses','afp','salud','codigo_unidad','nombre_unidad','genero','cargo','calidad_juridica','planta','n_resolucion','fresolucion','total_dias_ausentismo','ausentismo_en_el_periodo','costo_de_licencia','tipo_de_ausentismo','codigo_de_establecimiento','nombre_de_establecimiento','saldo_dias_no_reemplazados','tipo_de_contrato']
        );
        

        $this->message2 = $this->message2 . 'Se ha cargado correctamente el archivo (' . $count_inserts . ' filas procesadas).';
    }

    public function render()
    {
        return view('livewire.rrhh.abscences-import');
    }
}
