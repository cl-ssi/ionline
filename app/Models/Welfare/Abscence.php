<?php

namespace App\Models\Welfare;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Abscence extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'well_ami_abscences';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'rut', 'dv', 'nombre','ley','edad_años','edad_meses','afp', 'salud', 'codigo_unidad', 'nombre_unidad', 'genero', 'cargo', 'calidad_juridica',
        'planta', 'nro_resolucion', 'fecha_resolucion', 'fecha_inicio', 'fecha_termino', 'total_dias_auscentismo', 'auscentismo_en_el_periodo', 'costo_de_licencia', 
        'tipo_de_auscentismo', 'codigo_de_establecimiento', 'nombre_de_establecimiento', 'saldo_dias_no_reemplazados', 'tipo_de_contrato'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */    

    protected $casts = [
        'fecha_resolucion' => 'date:Y-m-d',
        'fecha_inicio' => 'date:Y-m-d',
        'fecha_termino' => 'date:Y-m-d',
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

}
