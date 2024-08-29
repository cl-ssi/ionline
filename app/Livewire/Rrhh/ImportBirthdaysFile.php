<?php

namespace App\Livewire\Rrhh;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Imports\UserBirthdayImport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Models\User;

use App\Models\Rrhh\SirhActiveUser;


class ImportBirthdaysFile extends Component
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
        $collection = Excel::toCollection(new UserBirthdayImport, $file);

        set_time_limit(7200);
        ini_set('memory_limit', '2048M');

        // se modifican todos los usuarios a inactivos
        User::where('id','>',0)->update(['active' => 0]);

        $total_count = $collection->first()->count()+1;
        $count_ionline = 0;
        $count_sirh = 0;
        foreach($collection as $row){
            foreach($row as $key => $column){ 
                
                if(array_key_exists('rut', $column->toArray()))
                {
                    if($column['rut']!=null)
                    {
                        // $date = Carbon::parse($column['fecha_nacimiento']);
                        $UNIX_DATE = ($column['fecha_nacimiento'] - 25569) * 86400;
                        $date_fecha_nacimiento = Carbon::parse(gmdate("d-m-Y H:i:s", $UNIX_DATE));

                        if($column['fecha_inicio_contrato']!="00/00/0000"){
                            $UNIX_DATE = ($column['fecha_inicio_contrato'] - 25569) * 86400;
                            $date_fecha_inicio_contrato = Carbon::parse(gmdate("d-m-Y H:i:s", $UNIX_DATE));
                        }else{$date_fecha_inicio_contrato = null;}

                        if($column['fecha_termino_contrato']!="00/00/0000"){
                            $UNIX_DATE = ($column['fecha_termino_contrato'] - 25569) * 86400;
                            $fecha_termino_contrato = Carbon::parse(gmdate("d-m-Y H:i:s", $UNIX_DATE));
                        }else{$fecha_termino_contrato = null;}
                        
                        if($date_fecha_nacimiento->isValid()){
                            // si encuentra al usuario en tabla users, lo deja como activo. Solo guarda correo, si este es un correo válido.
                            if(User::find($column['rut'])){
                                $user = User::find($column['rut']);
                                $user->birthday = $date_fecha_nacimiento;
                                if(filter_var($column['correos'], FILTER_VALIDATE_EMAIL)) {
                                    if($user->email_personal==null){
                                        $user->email_personal = $column['correos'];
                                    }
                                }
                                $user->active = 1;
                                $user->save();

                                $count_ionline += 1;
                            }
                            // cuando no existe usuario en users, se crea en tabla sirh_active_users
                            else{
                                SirhActiveUser::updateOrCreate([
                                    'id' => $column['rut']
                                    // 'dv' => $column['dv'],
                                    // 'email' => $column['correos'],
                                    // 'name' => $column['nombre_funcionario'],
                                    // 'birthdate' => $date_fecha_nacimiento,
                                    // 'start_contract_date' => $date_fecha_inicio_contrato,
                                    // 'end_contract_date' => $fecha_termino_contrato,
                                    // 'legal_quality' => $column['descripcion_calidad_juridica'],
                                    // 'ou_description' => $column['descripcion_unidad']
                                ],[
                                    'id' => $column['rut'],
                                    'dv' => $column['dv'],
                                    'email' => $column['correos'],
                                    'name' => $column['nombre_funcionario'],
                                    'birthdate' => $date_fecha_nacimiento,
                                    'start_contract_date' => $date_fecha_inicio_contrato,
                                    'end_contract_date' => $fecha_termino_contrato,
                                    'legal_quality' => $column['descripcion_calidad_juridica'],
                                    'ou_description' => $column['descripcion_unidad']
                                ]);

                                $count_sirh += 1;
                            }
                        }

                    }
                }
            }
            
        }

        $this->message2 = 'Se ha cargado correctamente el archivo (De un total de ' . $total_count . ' registros, se actualizaron ' . 
        $count_ionline . ' usuarios de ionline, y se crearon/actualizando ' . $count_sirh .' usuarios de forma externa a ionline).';
    }

    public function render()
    {
        return view('livewire.rrhh.import-birthdays-file');
    }
}
