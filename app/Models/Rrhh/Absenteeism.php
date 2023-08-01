<?php

namespace App\Models\Rrhh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absenteeism extends Model
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
        'nombre',
        'ley',
        'edadanos',
        'edadmeses',
        'afp',
        'salud',
        'codigo_unidad',
        'nombre_unidad',
        'genero',
        'cargo',
        'calidad_juridica',
        'planta',
        'n_resolucion',
        'fresolucion',
        'finicio',
        'ftermino',
        'total_dias_ausentismo',
        'ausentismo_en_el_periodo',
        'costo_de_licencia',
        'tipo_de_ausentismo',
        'codigo_de_establecimiento',
        'nombre_de_establecimiento',
        'saldo_dias_no_reemplazados',
        'tipo_de_contrato'
    ];

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = [
        'finicio',
        'ftermino',
    ];

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'rrhh_absenteeisms';

    public function user()
    {
        return $this->belongsTo(User::class,'rut');
    }
}
