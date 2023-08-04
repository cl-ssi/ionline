<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\User;

class Contract extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
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
        'bieniotrienio',
        'antiguedad',
        'ley',
        'numero_horas',
        'etapa',
        'nivel',
        'fecha_inicio_en_el_nivel',
        'fecha_pago',
        'antiguedad_en_nivel_anosmesesdias',
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
        'especcarrera',
        'titulo',
        'fecha_inicio_contrato',
        'fecha_termino_contrato',
        'fecha_alejamiento',
        'correl_planta',
        '15076condicion',
        'transitorio',
        'numero_resolucion',
        'fecha_resolucion',
        'tipo_documento',
        'tipo_movimiento',
        'total_haberes',
        'remuneracion',
        'sin_planillar',
        'servicio_de_salud',
        'usuario_ingreso',
        'fecha_ingreso',
        'rut_del_reemplazado',
        'dv_del_reemplazado',
        'corr_contrato_del_reemplazado',
        'nombre_del_reemplazado',
        'motivo_del_reemplazo',
        'fecha_inicio_ausentismo',
        'fecha_termino_ausentismo',
        'fecha_primer_contrato'
    ];

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = [
        'fecha_inicio_contrato',
        'fecha_termino_contrato',
        'fecha_alejamiento',
    ];

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'rrhh_contracts';

    public function user()
    {
        return $this->belongsTo(User::class,'rut');
    }

}
