<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Finance\Dte;

class ComparativeRequirement extends Model
{
    use HasFactory;

    protected $table = 'fin_comparative_requirements';

    protected $fillable = [
        'dte_rut_emisor',
        'dte_folio',
        'dte_razon_social_emisor',
        'dte_tipo_documento',
        'oc',
        'afectacion_folio',
        'afectacion_fecha',
        'afectacion_titulo',
        'afectacion_monto',
        'devengo_folio',
        'devengo_fecha',
        'devengo_titulo',
        'devengo_monto',
        'efectivo_folio',
        'efectivo_fecha',
        'efectivo_monto',
        'dte_id',
    ];

    protected $casts = [
        'afectacion_fecha' => 'date:Y-m-d',
        'devengo_fecha' => 'date:Y-m-d',
        'efectivo_fecha' => 'date:Y-m-d',
        
    ];

    public function dte()
    {
        return $this->belongsTo(Dte::class);
    }
}
