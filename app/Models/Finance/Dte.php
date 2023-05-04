<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dte extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'tipo',
        'tipo_documento',
        'folio',
        'emisor',
        'razon_social_emisor',
        'receptor',
        'publicacion',
        'emision',
        'monto_neto',
        'monto_exento',
        'monto_iva',
        'monto_total',
        'impuestos',
        'estado_acepta',
        'estado_sii',
        'estado_intercambio',
        'informacion_intercambio',
        'uri',
        'referencias',
        'fecha_nar',
        'estado_nar',
        'uri_nar',
        'mensaje_nar',
        'uri_arm',
        'fecha_arm',
        'fmapago',
        'controller',
        'fecha_vencimiento',
        'estado_cesion',
        'url_correo_cesion',
        'fecha_recepcion_sii',
        'estado_reclamo',
        'fecha_reclamo',
        'mensaje_reclamo',
        'estado_devengo',
        'codigo_devengo',
        'folio_oc',
        'fecha_ingreso_oc',
        'folio_rc',
        'fecha_ingreso_rc',
        'ticket_devengo',
        'folio_sigfe',
        'tarea_actual',
        'area_transaccional',
        'fecha_ingreso',
        'fecha_aceptacion',
        'fecha',
    ];

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = [
        'publicacion',
        'emision',
        'fecha_nar',
        'fecha_arm',
        'fecha_vencimiento',
        'fecha_recepcion_sii',
        'fecha_reclamo',
        'fecha_ingreso_oc',
        'fecha_ingreso_rc',
        'fecha_ingreso',
        'fecha_aceptacion',
        'fecha',
    ];
}
