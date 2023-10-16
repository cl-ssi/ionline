<?php

namespace App\Models\Welfare\Amipass;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Absence extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'well_absences';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rut', 'dv', 'nombre','ley','nombre_unidad','mes_ausentismo','fecha_inicio', 'fecha_termino', 
        'fecha_termino_2', 'ausentismo_calculado', 'total_dias_ausentismo', 'ausentismos_en_periodo','tipo_ausentismo'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */    

    protected $casts = [
        'fecha_inicio' => 'date:Y-m-d',
        'fecha_termino' => 'date:Y-m-d',
        'fecha_termino_2' => 'date:Y-m-d',
    ];

}
