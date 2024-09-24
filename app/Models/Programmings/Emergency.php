<?php

namespace App\Models\Programmings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Emergency extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $table = 'pro_emergencies';
    protected $fillable = [
        'id', 'name', 'description', 'frecuency', 'impact_level', 'ss_rol', 'programming_id', 'another_name', 'origin', 'measures'
    ];
    protected $appends = [
        'factor',
    ];

    static public function getDangerList()
    {
        return array('Natural' => ['SISMOS DE GRAN MAGNITUD', 'FENÓMENOS METEROLÓGICOS: crecidas, inundaciones, aluviones, deslizamiento, nevazones y marejadas',
                                    'FENÓMENOS METEROLÓGICOS ASOCIADOS A CAMBIO CLIMÁTICO: sequías y lluvias extremas','EMERGENCIA EPIDEMIOLÓGICA',
                                    'TSUNAMI', 'INCENDIOS FORESTALES','ERUPCIÓN VOLCÁNICA', 'OTRO'], 
                    'Antrópico' => ['SITUACIÓN MIGRATORIA REGIONAL DESCONTROLADA',
                                'ACCIDENTES CON MÚLTIPLES VÍCTIMAS: grandes accidentes carreteros, grandes accidentes ferroviarios, aéreos, accidentes en mega eventos, violencia social, accidentes carreteros',
                                'ACCIDENTES EN MEGA EVENTOS / Actividades Sociales-Religiosas (peregrinaciones multitudinarias)', 'INCENDIOS URBANOS', 'INCENDIOS QUÍMICOS',
                                'PÉRDIDA DE CONECTIVIDAD Y SERVICIOS BÁSICOS', 'ACTOS TERRORISTAS', 'OTRO']);
    }

    public function programming() {
        return $this->belongsTo('App\Models\Programmings\Programming');
    }

    public function getFactorAttribute()
    {
        return $this->frecuency * $this->impact_level * $this->ss_rol;
    }
}
