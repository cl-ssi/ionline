<?php

namespace App\Models\Sirh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExistingContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'rut',
        'dv',
        'corr',
        'nombres',
        'fecha',
        'ley_afecto',
        'calidad_juridica',
        'planta',
        'unidad',
        'unid_descripcion',
        'grado',
        'hora_semana',
        'codigo_esta',
        'esta_nombre',
        'fecha_ini',
        'fecha_fin',
        'cod_cargo',
        'carg_nombre',
        'num_docu',
        'tipo_documento',
        'fecha_resolucion',
        'cod_funcion',
        'funcion',
        'etapa_carrera',
        'nivel_etapa',
        'movi_planta',
        'tipo_movimiento',
        'transitorio',
        'lib_guardia',
        'fecha_nacimiento',
        'lugar_de_nacimiento',
        'estado_civil',
        'sexo',
        'direccion',
        'comuna',
        'ciudad',
        'fono'
    ];

    protected $table = 'sirh_existing_contracts';
}
