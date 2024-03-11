<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Finance\Dte;

class TgrPayedDte extends Model
{
    use HasFactory;

    protected $table = 'fin_tgr_payed_dtes';

    protected $fillable = [
        'rut_emisor',
        'folio_documento',
        'razon_social_emisor',
        'tipo_documento',
        'area_transaccional',
        'folio',
        'tipo_operacion',
        'fecha_generacion',
        'cuenta_contable',
        'tipo_documento_tgr',
        'nro_documento',
        'fecha_cumplimiento',
        'combinacion_catalogo',
        'principal',
        'principal_relacionado',
        'beneficiario',
        'banco_cta_corriente',
        'medio_pago',
        'tipo_medio_pago',
        'nro_documento_pago',
        'fecha_emision',
        'estado_documento',
        'monto',
        'moneda',
        'tipo_cambio',
        'banco_beneficiario',
        'cuenta_beneficiaria',
        'medio_de_pago',
        'numero_de_medio_de_pago',
        'cuenta_tgr',
        'dte_id',
    ];


    protected $casts = [
        'fecha_generacion'=> 'datetime',
        
    ];

    public function dte()
    {
        return $this->belongsTo(Dte::class);
    }


}
