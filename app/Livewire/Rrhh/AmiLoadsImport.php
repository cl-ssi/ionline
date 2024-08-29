<?php

namespace App\Livewire\Rrhh;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\Rrhh\AmiLoad;
use App\Imports\AbscencesImport as AbscencesImportFile;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Models\User;

class AmiLoadsImport extends Component
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

        $non_existent_users = [];

        foreach($collection as $row){

            foreach($row as $key => $column){ 
                
                if(array_key_exists('rut', $column->toArray()))
                {

                    if($column['rut']!=null)
                    {
                        $val = trim($column['fecha']);
                        $fecha = new Carbon($val);

                        $rut = explode("-",$column['rut'])[0];
                        $dv = explode("-",$column['rut'])[1];


                        // if(!User::find($rut)){
                        //     $this->non_existent_users[$rut] = $rut . "-" . $dv . ": " . $column['nombre_empleado'];
                        // }else{
                        //     AmiLoad::updateOrCreate([
                        //         'id_amipass' => $column['id'],
                        //         'sucursal' => $column['sucursal'],
                        //         'centro_de_costo' => $column['centro_de_costo'],
                        //         'n_factura' => $column['no_factura'],
                        //         'fecha' => $fecha,
                        //         'n_tarjeta' => $column['no_tarjeta']
                        //     ],[
                        //         'id_amipass' => $column['id'],
                        //         'sucursal' => $column['sucursal'],
                        //         'centro_de_costo' => $column['centro_de_costo'],
                        //         'n_factura' => $column['no_factura'],
                        //         'tipo' => $column['tipo'],
                        //         'fecha' => $fecha,
                        //         'n_tarjeta' => $column['no_tarjeta'],
                        //         'nombre_empleado' => $column['nombre_empleado'],
                        //         'run' => $rut,
                        //         'dv' => $dv,
                        //         'tipo_empleado' => $column['tipo_empleado'],
                        //         'monto' => $column['monto']
                        //     ]);

                        //     $count_inserts += 1;
                        // } 

                        $insert_array[] = [
                            'id_amipass' => $column['id'],
                            'sucursal' => $column['sucursal'],
                            'centro_de_costo' => $column['centro_de_costo'],
                            'n_factura' => $column['no_factura'],
                            'tipo' => $column['tipo'],
                            'fecha' => $fecha,
                            'n_tarjeta' => $column['no_tarjeta'],
                            'nombre_empleado' => $column['nombre_empleado'],
                            'run' => $rut,
                            'dv' => $dv,
                            'tipo_empleado' => $column['tipo_empleado'],
                            'monto' => $column['monto']
                        ];

                        $count_inserts += 1;
                        
                    }
                }
            }
            
        }

        AmiLoad::upsert(
            $insert_array, 
            ['id_amipass','fecha','run'], 
            ['sucursal','centro_de_costo','tipo','n_factura','monto','n_tarjeta','nombre_empleado','dv','tipo_empleado']
        );
        

        $this->message2 = $this->message2 . 'Se ha cargado correctamente el archivo (' . $count_inserts . ' filas procesadas).';
    }

    public function render()
    {
        return view('livewire.rrhh.ami-loads-import');
    }
}
