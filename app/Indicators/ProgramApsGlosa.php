<?php

namespace App\Indicators;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramApsGlosa extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'periodo', 'numero', 'nivel', 'prestacion', 'poblacion', 'verificacion',
        'profesional'
    ];

    public function values() {
        return $this->hasMany('App\Indicators\ProgramApsValue');
    }
/*
    ProgramAps::Create([
        'periodo' => 2018,
        'nivel' => 'Prevención',
        'prestaciones' => 'CONTROL DE SALUD EN POBLACIÓN INFANTIL MENOR DE 1 AÑO',
        'glosaPoblacion' => 'Población 2, 4, 6 meses',
        'verificacion' => 'REM A01, Sección B celdas H32+J32+L32',
        'profesional' => 'Enfermera'
    ]);
    */

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = 'ind_program_aps_glosas';
}
