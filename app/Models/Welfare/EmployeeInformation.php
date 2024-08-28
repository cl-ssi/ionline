<?php

namespace App\Models\Welfare;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class EmployeeInformation extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'well_ami_employee_information';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'rut',
        'dv',
        'correlativo',
        'nombre_funcionario',
        'codigo_planta',
        'descripcion_planta',
        'codigo_calidad_juridica',
        'descripcion_calidad_juridica',
        'grado',
        'genero',
        'estado_civil',
        'direccion',
        'ciudad',
        'comuna',
        'nacionalidad',
        'fecha_ingreso_grado',
        'fecha_ingreso_servicio',
        'fecha_ingreso_adm_publica',
        'codigo_isapre',
        'descripcion_isapre',
        'codigo_afp',
        'descripcion',
        'cargas_familiares',
        'bienio_trienio',
        'antiguedad',
        'ley',
        'numero_horas',
        'etapa',
        'nivel',
        'fecha_inicio_en_el_nivel',
        'fecha_pago',
        'antiguedad_en_nivel_anos_meses_dias',
        'establecimiento',
        'descripcion_establecimiento',
        'glosa_establecimiento_9999_contratos_historicos',
        'fecha_nacimiento',
        'codigo_unidad',
        'descripcion_unidad',
        'codigo_unidad_2',
        'descripcion_unidad_2',
        'c_costo',
        'codigo_turno',
        'codigo_cargo',
        'descripcion_cargo',
        'correl_informe',
        'codigo_funcion',
        'descripcion_funcion',
        'espec_carrera',
        'titulo',
        'fecha_inicio_contrato',
        'fecha_termino_contrato',
        'fecha_alejamiento',
        'correl_planta',
        '15076_condicion',
        'transitorio',
        'numero_resolucion',
        'fecha_resolucion',
        'tipo_documento',
        'tipo_movimiento',
        'total_haberes',
        'remuneracion',
        'sin_planillar',
        'servicio_salud',
        'usuario_ingreso',
        'fecha_ingreso',
        'rut_reemplazado',
        'dv_reemplazado',
        'corr_contrato_reemplazado',
        'nombre_reemplazado',
        'motivo_reemplazo',
        'fecha_inicio_ausentismo',
        'fecha_termino_ausentismo',
        'fecha_primer_contrato'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'fecha_ingreso_grado' => 'date:Y-m-d',
        'fecha_ingreso_servicio' => 'date:Y-m-d',
        'fecha_ingreso_adm_publica' => 'date:Y-m-d',
        'fecha_inicio_en_el_nivel' => 'date:Y-m-d',
        'fecha_pago' => 'date:Y-m-d',
        'fecha_nacimiento' => 'date:Y-m-d',
        'fecha_inicio_contrato' => 'date:Y-m-d',
        'fecha_termino_contrato' => 'date:Y-m-d',
        'fecha_alejamiento' => 'date:Y-m-d',
        'fecha_resolucion' => 'date:Y-m-d',
        'fecha_ingreso' => 'date:Y-m-d',
        'fecha_inicio_ausentismo' => 'date:Y-m-d',
        'fecha_termino_ausentismo' => 'date:Y-m-d',
        'fecha_primer_contrato' => 'date:Y-m-d',
        'created_at' => 'datetime',
    ];
}