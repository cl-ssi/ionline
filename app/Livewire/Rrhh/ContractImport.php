<?php

namespace App\Livewire\Rrhh;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\Rrhh\Contract;
use App\Imports\EmployeeInformationImport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Rrhh\OrganizationalUnit;
use App\Http\Controllers\WebserviceController;
use App\Models\WebService\Fonasa;
use App\Models\Rrhh\SirhActiveUser;

class ContractImport extends Component
{
    use WithFileUploads;

    public $file;
    public $message2;
    public $non_existent_users = array();
    public $non_existent_ous = array();

    public function mount(){
        $this->non_existent_users = 0;
        $this->non_existent_ous = [];
    }

    public function save()
    {
        $this->message2 = "";
        $this->non_existent_ous = [];

        $this->validate([
            'file' => 'required|mimes:csv,txt|max:10240', // 10MB Max
        ]);

        $file = $this->file;
        $collection = Excel::toCollection(new EmployeeInformationImport, $this->file->path());

        // se modifican todos los usuarios a inactivos
        // User::where('id','>',0)->update(['active' => 0]);

        // $total_count = $collection->first()->count();
        $count_inserts = 0;

        set_time_limit(7200);
        ini_set('memory_limit', '2048M');

        $insert_array = [];
        try {
            foreach($collection as $row){
                foreach($row as $key => $column){ 
                    if(array_key_exists('rut', $column->toArray()))
                    {
                        if($column['rut']!=null)
                        {
                            if($column['fecha_ingreso_grado']!="00/00/0000" && $column['fecha_ingreso_grado']!=null){
                                $fecha_ingreso_grado = Carbon::createFromFormat('d/m/Y',$column['fecha_ingreso_grado']);
                            }else{$fecha_ingreso_grado = null;}
    
                            // $fecha_ingreso_servicio = Carbon::createFromFormat('d/m/Y',$column['fecha_ingreso_servicio']);
                            if($column['fecha_ingreso_servicio']!="00/00/0000" && $column['fecha_ingreso_servicio']!=null){
                                $fecha_ingreso_servicio = Carbon::createFromFormat('d/m/Y',$column['fecha_ingreso_servicio']);
                            }else{$fecha_ingreso_servicio = null;}
                            
                            $fecha_ingreso_adm_publica = Carbon::createFromFormat('d/m/Y',$column['fecha_ingreso_adm_pblica']);
    
                            if($column['fecha_inicio_en_el_nivel']!=null){
                                $fecha_inicio_en_el_nivel = Carbon::createFromFormat('d/m/Y',$column['fecha_inicio_en_el_nivel']);
                            }else{$fecha_inicio_en_el_nivel = null;}
    
                            if($column['fecha_pago']!=null && $column['fecha_pago']!="" && $column['fecha_pago']!=" "){
                                $fecha_pago = Carbon::createFromFormat('d/m/Y',$column['fecha_pago']);
                            }else{$fecha_pago = null;}
    
                            $fecha_nacimiento = Carbon::createFromFormat('d/m/Y',$column['fecha_nacimiento']);
                            $fecha_inicio_contrato = Carbon::createFromFormat('d/m/Y',$column['fecha_inicio_contrato']);
    
                            if($column['fecha_termino_contrato']!="00/00/0000"){
                                $fecha_termino_contrato = Carbon::createFromFormat('d/m/Y',$column['fecha_termino_contrato']);
                            }else{$fecha_termino_contrato = null;}
    
                            if($column['fecha_alejamiento']!="00/00/0000"){
                                $fecha_alejamiento = Carbon::createFromFormat('d/m/Y',$column['fecha_alejamiento']);
                            }else{$fecha_alejamiento = null;}
    
                            $fecha_resolucion = Carbon::createFromFormat('d/m/Y',$column['fecha_resolucin']);
                            
                            if($column['fecha_ingreso']!=null){
                                $fecha_ingreso = explode(" ", $column['fecha_ingreso']);
                                $fecha_ingreso = Carbon::createFromFormat('d/m/Y',$fecha_ingreso[0]);
                            }else{$fecha_ingreso = null;}
    
                            if($column['fecha_inicio_ausentismo']!=null){
                                $fecha_inicio_ausentismo = Carbon::createFromFormat('d/m/Y',$column['fecha_inicio_ausentismo']);
                            }else{$fecha_inicio_ausentismo = null;}
    
                            if($column['fecha_trmino_ausentismo']!=null){
                                $fecha_termino_ausentismo = Carbon::createFromFormat('d/m/Y',$column['fecha_trmino_ausentismo']);
                            }else{$fecha_termino_ausentismo = null;}
    
                            if($column['fecha_primer_contrato']!=null){
                                $fecha_primer_contrato = Carbon::createFromFormat('d/m/Y',$column['fecha_primer_contrato']);
                            }else{$fecha_primer_contrato = null;}

                            // si no existe usuario, se crea
                            $rut = trim($column['rut']);
                            $dv = trim($column['dv']);

                            $insert_array[] = [
                                        'rut' => $rut,
                                        'dv' => $column['dv'],
                                        'correlativo' => $column['correlativo'],
                                        'nombre_funcionario' => $column['nombre_funcionario'],
                                        'codigo_planta' => $column['cdigo_planta'],
                                        'descripcion_planta' => $column['descripcin_planta'],
                                        'codigo_calidad_juridica' => $column['cdigo_calidad_jurdica'],
                                        'descripcion_calidad_juridica' => $column['descripcin_calidad_jurdica'],
                                        'grado' => $column['grado'],
                                        'genero' => $column['gnero'],
                                        'estado_civil' => $column['estado_civil'],
                                        'direccion' => $column['direccin'],
                                        'ciudad' => $column['ciudad'],
                                        'comuna' => $column['comuna'],
                                        'nacionalidad' => $column['nacionalidad'],
                                        'fecha_ingreso_grado' => $fecha_ingreso_grado,
                                        'fecha_ingreso_servicio' => $fecha_ingreso_servicio,
                                        'fecha_ingreso_adm_publica' => $fecha_ingreso_adm_publica,
                                        'codigo_isapre' => $column['cdigo_isapre'],
                                        'descripcion_isapre' => $column['descripcin_isapre'],
                                        'codigo_afp' => $column['cdigo_afp'],
                                        'descripcion' => $column['descripcin'],
                                        'cargas_familiares' => $column['cargas_familiares'],
                                        'bieniotrienio' => $column['bieniotrienio'],
                                        'antiguedad' => $column['antiguedad'],
                                        'ley' => $column['ley'],
                                        'numero_horas' => $column['nmero_horas'],
                                        'etapa' => $column['etapa'],
                                        'nivel' => $column['nivel'],
                                        'fecha_inicio_en_el_nivel' => $fecha_inicio_en_el_nivel,
                                        'fecha_pago' => $fecha_pago,
                                        'antiguedad_en_nivel_anosmesesdias' => $column['antigedad_en_nivel_aos_meses_das'],
                                        'establecimiento' => $column['establecimiento'],
                                        'descripcion_establecimiento' => $column['descripcin_establecimiento'],
                                        'glosa_establecimiento_9999_contratos_historicos' => $column['glosa_establecimiento_9999_contratos_histricos'],
                                        'fecha_nacimiento' => $fecha_nacimiento,
                                        'codigo_unidad' => $column['cdigo_unidad'],
                                        'descripcion_unidad' => $column['descripcin_unidad'],
                                        'codigo_unidad_2' => $column['cdigo_unidad_2'],
                                        'descripcion_unidad_2' => $column['descripcin_unidad_2'],
                                        'c_costo' => $column['c_costo'],
                                        'codigo_turno' => $column['cdigo_turno'],
                                        'codigo_cargo' => $column['cdigo_cargo'],
                                        'descripcion_cargo' => $column['descripcin_cargo'],
                                        'correl_informe' => $column['correl_informe'],
                                        'codigo_funcion' => $column['cdigo_funcin'],
                                        'descripcion_funcion' => $column['descripcin_funcin'],
                                        'especcarrera' => $column['especcarrera'],
                                        'titulo' => $column['ttulo'],
                                        'fecha_inicio_contrato' => $fecha_inicio_contrato,
                                        'fecha_termino_contrato' => $fecha_termino_contrato,
                                        'fecha_alejamiento' => $fecha_alejamiento,
                                        'correl_planta' => $column['correl_planta'],
                                        '15076condicion' => $column['15076condicin'],
                                        'transitorio' => $column['transitorio'],
                                        'numero_resolucion' => $column['numero_resolucin'],
                                        'fecha_resolucion' => $fecha_resolucion,
                                        'tipo_documento' => $column['tipo_documento'],
                                        'tipo_movimiento' => $column['tipo_movimiento'],
                                        'total_haberes' => $column['total_haberes'],
                                        'remuneracion' => $column['remuneracin'],
                                        'sin_planillar' => $column['sin_planillar'],
                                        'servicio_de_salud' => $column['servicio_de_salud'],
                                        'usuario_ingreso' => $column['usuario_ingreso'],
                                        'fecha_ingreso' => $fecha_ingreso,
                                        'rut_del_reemplazado' => $column['rut_del_reemplazado'],
                                        'dv_del_reemplazado' => $column['dv_del_reemplazado'],
                                        'corr_contrato_del_reemplazado' => $column['corr_contrato_del_reemplazado'],
                                        'nombre_del_reemplazado' => $column['nombre_del_reemplazado'],
                                        'motivo_del_reemplazo' => $column['motivo_del_reemplazo'],
                                        'fecha_inicio_ausentismo' => $fecha_inicio_ausentismo,
                                        'fecha_termino_ausentismo' => $fecha_termino_ausentismo,
                                        'fecha_primer_contrato' => $fecha_primer_contrato
                            ];
    
                            $count_inserts += 1;
                        }
                    }
                }
            }

            // dd($insert_array);
            Contract::upsert($insert_array, 
                    ['rut', 'correlativo'], 
                    ['dv','nombre_funcionario','codigo_planta','descripcion_planta','codigo_calidad_juridica','descripcion_calidad_juridica','grado',
                    'genero','estado_civil','direccion','ciudad','comuna','nacionalidad','fecha_ingreso_grado','fecha_ingreso_servicio','fecha_ingreso_adm_publica',
                    'codigo_isapre','descripcion_isapre','codigo_afp','descripcion','cargas_familiares','bieniotrienio','antiguedad','ley','numero_horas','etapa',
                    'nivel','fecha_inicio_en_el_nivel','fecha_pago','antiguedad_en_nivel_anosmesesdias','establecimiento','descripcion_establecimiento',
                    'glosa_establecimiento_9999_contratos_historicos','fecha_nacimiento','codigo_unidad','descripcion_unidad','codigo_unidad_2',
                    'descripcion_unidad_2','c_costo','codigo_turno','codigo_cargo','descripcion_cargo','correl_informe','codigo_funcion','descripcion_funcion',
                    'especcarrera','titulo','fecha_inicio_contrato','fecha_termino_contrato','fecha_alejamiento','correl_planta','15076condicion','transitorio',
                    'numero_resolucion','fecha_resolucion','tipo_documento','tipo_movimiento','total_haberes','remuneracion','sin_planillar','servicio_de_salud',
                    'usuario_ingreso','fecha_ingreso','rut_del_reemplazado','dv_del_reemplazado','corr_contrato_del_reemplazado','nombre_del_reemplazado',
                    'motivo_del_reemplazo','fecha_inicio_ausentismo','fecha_termino_ausentismo','fecha_primer_contrato'
                    ]
            );

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        $this->message2 = 'Se ha cargado correctamente el archivo (' . $count_inserts . ' filas procesadas).';
    }

    public function process(){

        set_time_limit(7200);
        ini_set('memory_limit', '2048M');

        $this->message2 = "";
        $this->non_existent_users = 0;
        $this->non_existent_ous = [];

        $count_inserts = 0;
        $contracts = Contract::whereDoesntHave('user')
                            ->with('organizationalUnit')
                            ->whereHas('organizationalUnit')
                            ->where(function($query) {
                                $query->whereNull('fecha_termino_contrato')
                                        ->orWhere('fecha_termino_contrato','>=',now());
                            })
                            ->get();

        $withoutOu = array_unique(Contract::whereDoesntHave('user')->whereDoesntHave('organizationalUnit')->pluck('codigo_unidad')->toArray());
        // dd($withoutOu);
        $this->non_existent_users = Contract::whereDoesntHave('user')->whereDoesntHave('organizationalUnit')->count();
        // dd($this->non_existent_users);

        foreach($contracts as $contract){
 
            $rut = $contract->rut;
            $dv = $contract->dv;

            if(!User::find($rut)){
                
                $fonasaUser = Fonasa::find($rut."-".$dv);
                if(!isset($fonasaUser->message)){
                    if($fonasaUser->name){
                        User::withTrashed()->updateOrCreate([
                            'id' => $rut
                        ],[
                            'id' => $rut,
                            'dv' => $dv,
                            'mothers_family' => $fonasaUser->mothers_family,
                            'fathers_family' => $fonasaUser->fathers_family,
                            'name' => $fonasaUser->name,
                            'organizational_unit_id' => $contract->organizationalUnit->id,
                            'deleted_at' => null,
                        ]);
        
                        $count_inserts += 1;
                    }
                }
            }
        }

        $this->non_existent_ous = $withoutOu;

        $this->message2 = 'Procesamiento completado. Se han creado/actualizado ' . $count_inserts . ' usuarios en el sistema. Si no se han creado más funcionarios, la posible causa puede ser que tengan asignado en el archivo de importación un código sirh no parametrizado con unidades organizacionales del ionline.';
    }

    public function render()
    {
        return view('livewire.rrhh.contract-import');
    }
}
