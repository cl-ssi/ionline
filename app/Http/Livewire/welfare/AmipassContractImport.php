<?php

namespace App\Http\Livewire\welfare;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\models\Welfare\EmployeeInformation;
use App\Imports\EmployeeInformationImport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\User;

use App\Models\Rrhh\SirhActiveUser;

class AmipassContractImport extends Component
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
        $collection = Excel::toCollection(new EmployeeInformationImport, $file);

        // se modifican todos los usuarios a inactivos
        User::where('id','>',0)->update(['active' => 0]);

        $total_count = $collection->first()->count()+1;
        $count_inserts = 0;

        set_time_limit(7200);
        ini_set('memory_limit', '2048M');

        foreach($collection as $row){
            foreach($row as $key => $column){ 
                
                if(array_key_exists('rut', $column->toArray()))
                {
                    if($column['rut']!=null)
                    {

                        if($column['fecha_ingreso_grado']!="00/00/0000"){
                            $fecha_ingreso_grado = ($column['fecha_ingreso_grado'] - 25569) * 86400;
                            $fecha_ingreso_grado = Carbon::parse(gmdate("d-m-Y H:i:s", $fecha_ingreso_grado));
                        }else{$fecha_ingreso_grado = null;}

                        $fecha_ingreso_servicio = ($column['fecha_ingreso_servicio'] - 25569) * 86400;
                        $fecha_ingreso_servicio = Carbon::parse(gmdate("d-m-Y H:i:s", $fecha_ingreso_servicio));

                        $fecha_ingreso_adm_publica = ($column['fecha_ingreso_adm_publica'] - 25569) * 86400;
                        $fecha_ingreso_adm_publica = Carbon::parse(gmdate("d-m-Y H:i:s", $fecha_ingreso_adm_publica));

                        if($column['fecha_inicio_en_el_nivel']!=null){
                            $fecha_inicio_en_el_nivel = ($column['fecha_inicio_en_el_nivel'] - 25569) * 86400;
                            $fecha_inicio_en_el_nivel = Carbon::parse(gmdate("d-m-Y H:i:s", $fecha_inicio_en_el_nivel));
                        }else{$fecha_inicio_en_el_nivel = null;}

                        if($column['fecha_pago']!=null){
                            $fecha_pago = ($column['fecha_pago'] - 25569) * 86400;
                            $fecha_pago = Carbon::parse(gmdate("d-m-Y H:i:s", $fecha_pago));
                        }else{$fecha_pago = null;}

                        $fecha_nacimiento = ($column['fecha_nacimiento'] - 25569) * 86400;
                        $fecha_nacimiento = Carbon::parse(gmdate("d-m-Y H:i:s", $fecha_nacimiento));

                        $fecha_inicio_contrato = ($column['fecha_inicio_contrato'] - 25569) * 86400;
                        $fecha_inicio_contrato = Carbon::parse(gmdate("d-m-Y H:i:s", $fecha_inicio_contrato));

                        if($column['fecha_termino_contrato']!="00/00/0000"){
                            $fecha_termino_contrato = ($column['fecha_termino_contrato'] - 25569) * 86400;
                            $fecha_termino_contrato = Carbon::parse(gmdate("d-m-Y H:i:s", $fecha_termino_contrato));
                        }else{$fecha_termino_contrato = null;}

                        if($column['fecha_alejamiento']!="00/00/0000"){
                            $fecha_alejamiento = ($column['fecha_alejamiento'] - 25569) * 86400;
                            $fecha_alejamiento = Carbon::parse(gmdate("d-m-Y H:i:s", $fecha_alejamiento));
                        }else{$fecha_alejamiento = null;}

                        $fecha_resolucion = ($column['fecha_resolucion'] - 25569) * 86400;
                        $fecha_resolucion = Carbon::parse(gmdate("d-m-Y H:i:s", $fecha_resolucion));    
                        
                        if($column['fecha_ingreso']!=null){
                            $fecha_ingreso = ($column['fecha_ingreso'] - 25569) * 86400;
                            $fecha_ingreso = Carbon::parse(gmdate("d-m-Y H:i:s", $fecha_ingreso));
                        }else{$fecha_ingreso = null;}

                        if($column['fecha_inicio_ausentismo']!=null){
                            $fecha_inicio_ausentismo = ($column['fecha_inicio_ausentismo'] - 25569) * 86400;
                            $fecha_inicio_ausentismo = Carbon::parse(gmdate("d-m-Y H:i:s", $fecha_inicio_ausentismo));
                        }else{$fecha_inicio_ausentismo = null;}

                        if($column['fecha_termino_ausentismo']!=null){
                            $fecha_termino_ausentismo = ($column['fecha_termino_ausentismo'] - 25569) * 86400;
                            $fecha_termino_ausentismo = Carbon::parse(gmdate("d-m-Y H:i:s", $fecha_termino_ausentismo));
                        }else{$fecha_termino_ausentismo = null;}

                        if($column['fecha_primer_contrato']!=null){
                            $fecha_primer_contrato = ($column['fecha_primer_contrato'] - 25569) * 86400;
                            $fecha_primer_contrato = Carbon::parse(gmdate("d-m-Y H:i:s", $fecha_primer_contrato));
                        }else{$fecha_primer_contrato = null;}
                        
                        EmployeeInformation::updateOrCreate([
                            'rut' => $column['rut'],
                            'correlativo' => $column['correlativo']
                        ],[
                            'rut' => $column['rut'],
                            'dv' => $column['dv'],
                            'correlativo' => $column['correlativo'],
                            'nombre_funcionario' => $column['nombre_funcionario'],
                            'codigo_planta' => $column['codigo_planta'],
                            'descripcion_planta' => $column['descripcion_planta'],
                            'codigo_calidad_juridica' => $column['codigo_calidad_juridica'],
                            'descripcion_calidad_juridica' => $column['descripcion_calidad_juridica'],
                            'grado' => $column['grado'],
                            'genero' => $column['genero'],
                            'estado_civil' => $column['estado_civil'],
                            'direccion' => $column['direccion'],
                            'ciudad' => $column['ciudad'],
                            'comuna' => $column['comuna'],
                            'nacionalidad' => $column['nacionalidad'],
                            'fecha_ingreso_grado' => $fecha_ingreso_grado,
                            'fecha_ingreso_servicio' => $fecha_ingreso_servicio,
                            'fecha_ingreso_adm_publica' => $fecha_ingreso_adm_publica,
                            'codigo_isapre' => $column['codigo_isapre'],
                            'descripcion_isapre' => $column['descripcion_isapre'],
                            'codigo_afp' => $column['codigo_afp'],
                            'descripcion' => $column['descripcion'],
                            'cargas_familiares' => $column['cargas_familiares'],
                            'bienio_trienio' => $column['bieniotrienio'],
                            'antiguedad' => $column['antiguedad'],
                            'ley' => $column['ley'],
                            'numero_horas' => $column['numero_horas'],
                            'etapa' => $column['etapa'],
                            'nivel' => $column['nivel'],
                            'fecha_inicio_en_el_nivel' => $fecha_inicio_en_el_nivel,
                            'fecha_pago' => $fecha_pago,
                            'antiguedad_en_nivel_anos_meses_dias' => $column['antiguedad_en_nivel_anos_meses_dias'],
                            'establecimiento' => $column['establecimiento'],
                            'descripcion_establecimiento' => $column['descripcion_establecimiento'],
                            'glosa_establecimiento_9999_contratos_historicos' => $column['glosa_establecimiento_9999_contratos_historicos'],
                            'fecha_nacimiento' => $fecha_nacimiento,
                            'codigo_unidad' => $column['codigo_unidad'],
                            'descripcion_unidad' => $column['descripcion_unidad'],
                            'codigo_unidad_2' => $column['codigo_unidad_2'],
                            'descripcion_unidad_2' => $column['descripcion_unidad_2'],
                            'c_costo' => $column['c_costo'],
                            'codigo_turno' => $column['codigo_turno'],
                            'codigo_cargo' => $column['codigo_cargo'],
                            'descripcion_cargo' => $column['descripcion_cargo'],
                            'correl_informe' => $column['correl_informe'],
                            'codigo_funcion' => $column['codigo_funcion'],
                            'descripcion_funcion' => $column['descripcion_funcion'],
                            'espec_carrera' => $column['especcarrera'],
                            'titulo' => $column['titulo'],
                            'fecha_inicio_contrato' => $fecha_inicio_contrato,
                            'fecha_termino_contrato' => $fecha_termino_contrato,
                            'fecha_alejamiento' => $fecha_alejamiento,
                            'correl_planta' => $column['correl_planta'],
                            '15076_condicion' => $column['15076condicion'],
                            'transitorio' => $column['transitorio'],
                            'numero_resolucion' => $column['numero_resolucion'],
                            'fecha_resolucion' => $fecha_resolucion,
                            'tipo_documento' => $column['tipo_documento'],
                            'tipo_movimiento' => $column['tipo_movimiento'],
                            'total_haberes' => $column['total_haberes'],
                            'remuneracion' => $column['remuneracion'],
                            'sin_planillar' => $column['sin_planillar'],
                            'servicio_salud' => $column['servicio_de_salud'],
                            'usuario_ingreso' => $column['usuario_ingreso'],
                            'fecha_ingreso' => $fecha_ingreso,
                            'rut_reemplazado' => $column['rut_del_reemplazado'],
                            'dv_reemplazado' => $column['dv_del_reemplazado'],
                            'corr_contrato_reemplazado' => $column['corr_contrato_del_reemplazado'],
                            'nombre_reemplazado' => $column['nombre_del_reemplazado'],
                            'motivo_reemplazo' => $column['motivo_del_reemplazo'],
                            'fecha_inicio_ausentismo' => $fecha_inicio_ausentismo,
                            'fecha_termino_ausentismo' => $fecha_termino_ausentismo,
                            'fecha_primer_contrato' => $fecha_primer_contrato
                        ]);

                        $count_inserts += 1;

                    }
                }
            }
            
        }

        $this->message2 = 'Se ha cargado correctamente el archivo (De un total de ' . $total_count . ' registros, se registraron ' . 
        $count_inserts . ' registros).';
    }

    public function render()
    {
        return view('livewire.welfare.amipass-contract-import');
    }
}
