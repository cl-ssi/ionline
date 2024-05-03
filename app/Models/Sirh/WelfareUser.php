<?php

namespace App\Models\Sirh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WelfareUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'rut',
        'dv',
        'fecha',
        'nombre',
        'fecha_nac',
        'edad',
        'sexo',
        'tipo_afilia',
        'vigencia',
        'direccion',
        'telefono',
        'salud',
        'prevision',
        'contrato',
        'unidad',
        'establ',
        'cargo',
        'cuota_mes',
        'afil_fecha_desafiliacion'
    ];

    protected $table = 'sirh_welfare_users';
}
