<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\models\Rrhh\Absenteeism;
use App\models\Rrhh\AbsenteeismType;
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
        $collection = Excel::toCollection(new AbscencesImportFile, $file, 'gcs');

        $total_count = $collection->first()->count()+1;
        $count_inserts = 0;

        $absenteeismTypes = AbsenteeismType::all();
        $arrayTypes = [];
        foreach($absenteeismTypes as $absenteeismType){
            $arrayTypes[$absenteeismType->name] = $absenteeismType->id;
        }

        // $users = User::all()->pluck('name','id')->toArray();

        // si es csv
        if(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION) == "csv"){
            foreach($collection as $row){

                foreach($row as $key => $column){ 

                    // si no existe, se crea tipo de ausentismo
                    if(!array_key_exists(trim($column['tipo_de_ausentismo']), $arrayTypes)){
                        $absenteeismType = new AbsenteeismType();
                        $absenteeismType->name = trim($column['tipo_de_ausentismo']);
                        $absenteeismType->discount = 1;
                        $absenteeismType->save();
                        $absenteeismType_id = $absenteeismType->id;
                        $arrayTypes[trim($column['tipo_de_ausentismo'])] = $absenteeismType_id;
                    }else{
                        $absenteeismType_id = $arrayTypes[trim($column['tipo_de_ausentismo'])];
                    }
                    
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
    
                            // solo se crean ausentismos de usuarios que existen en ionline
                            if(!User::find($column['rut'])){
                                $this->non_existent_users[$column['rut']] = $column['rut'] . "-" . trim($column['dv']) . ": " . trim($column['nombre']);
                            }else{
                                Absenteeism::updateOrCreate([
                                    'rut' => $column['rut'],
                                    'finicio' => $finicio,
                                    'ftermino' => $ftermino,
                                    'absenteeism_type_id' => $absenteeismType_id,
                                ],[
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
                                ]);
        
                                $count_inserts += 1;
                            }
                            
                            
                        }
                    }
                }
                
            }
        }
        // si es excel
        else{
            foreach($collection as $row){

                foreach($row as $key => $column){ 
                    
                    // si no existe, se crea tipo de ausentismo
                    if(!array_key_exists(trim($column['tipo_de_ausentismo']), $arrayTypes)){
                        $absenteeismType = new AbsenteeismType();
                        $absenteeismType->name = trim($column['tipo_de_ausentismo']);
                        $absenteeismType->discount = 1;
                        $absenteeismType->save();
                        $absenteeismType_id = $absenteeismType->id;
                        $arrayTypes[trim($column['tipo_de_ausentismo'])] = $absenteeismType_id;
                    }else{
                        $absenteeismType_id = $arrayTypes[trim($column['tipo_de_ausentismo'])];
                    }
                    
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

                            // solo se crean ausentismos de usuarios que existen en ionline
                            if(!User::find($column['rut'])){
                            // if(array_key_exists($column['rut'],$users)){
                                $this->non_existent_users[$column['rut']] = $column['rut'] . "-" . trim($column['dv']) . ": " . trim($column['nombre']);
                            }else{
                                Absenteeism::updateOrCreate([
                                    'rut' => $column['rut'],
                                    'finicio' => $finicio->format('Y-m-d'),
                                    'ftermino' => $ftermino->format('Y-m-d'),
                                    'absenteeism_type_id' => $absenteeismType_id,
                                ],[
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
                                    'fresolucion' => $fresolucion,
                                    'finicio' => $finicio,
                                    'ftermino' => $ftermino,
                                    'total_dias_ausentismo' => $column['total_dias_ausentismo'],
                                    'ausentismo_en_el_periodo' => $column['ausentismo_en_el_periodo'],
                                    'costo_de_licencia' => $column['costo_de_licencia'],
                                    'tipo_de_ausentismo' => $column['tipo_de_ausentismo'],
                                    'absenteeism_type_id' => $absenteeismType_id,
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
                
            }
        }
        

        $this->message2 = $this->message2 . 'Se ha cargado correctamente el archivo (' . $count_inserts . ' registros).';
    }

    public function render()
    {
        return view('livewire.rrhh.abscences-import');
    }
}
