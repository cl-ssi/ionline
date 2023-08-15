<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Warehouse\Control;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\ImmediatePurchase;
use App\Models\Finance\PurchaseOrder;
use App\Models\Finance\File;
use App\Models\Establishment;

class Dte extends Model
{
    use HasFactory;

    protected $table = 'fin_dtes';

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

        //Datos envia a pago
        'sender_id',
        'sender_ou',
        'sender_at',


        //Datos pagador
        'payer_id',
        'payer_ou',
        'payer_at',

        //Establecimiento que le corresponde el DTE
        'establishment_id',

        'confirmation_status',
        'confirmation_user_id',
        'confirmation_ou_id',
        'confirmation_observation',
        'confirmation_at',
        'confirmation_signature_file',


        'dte_id',
        'cenabast',
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
        'payer_at',
        'confirmation_at',
        
        
        
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'folio_oc', 'code');
    }

    /** Control(ingresos) de Warehouse */
    public function controls()
    {
        return $this->hasMany(Control::class, 'po_code', 'folio_oc');
    }

    /**
     * Relación con RequestForm a través de ImmediatePurchase
     */
    public function requestForm()
    {
        return $this->hasOneThrough(
            RequestForm::class,
            ImmediatePurchase::class,
            'po_id', // Foreign key on the ImmediatePurchase table...
            'id', // Foreign key on the RequestForm table...
            'folio_oc', // Local key on the Dte table...
            'request_form_id', // Local key on the ImmediatePurchase table...
        );
    }

    /** Compras Inmediatas */
    // public function immediatePurchases()
    // {
    //     return $this->hasMany(ImmediatePurchase::class, 'po_id', 'folio_oc');
    // }

    // /** Compra Inmediata en singular, es para poder utilizar la relación de request form de abajo */
    // public function immediatePurchase()
    // {
    //     return $this->hasOne(ImmediatePurchase::class, 'po_id', 'folio_oc');
    // }

    // /** Formulario de Requerimientos  */
    // public function requestForm()
    // {
    //     // if($this->immediatePurchase AND $this->immediatePurchase->purchasingProcessDetail) {
    //     //     return $this->immediatePurchase->purchasingProcessDetail->itemRequestForm->requestForm();
    //     // }
    //     // else {
    //     return $this->immediatePurchase->requestForm();
    //     // }
    // }



    public function paymentFlows()
    {
        return $this->hasMany(PaymentFlow::class, 'dte_id');
    }

    public function files()
    {
        return $this->hasMany(File::class, 'dte_id');
    }

    public function establishment()
    {
        return $this->belongsTo(Establishment::class, 'establishment_id');
    }


    public function scopeSearch($query, $filter)
    {
        if (!empty($filter)) {
            foreach ($filter as $column => $value) {
                if (!empty($value)) {
                    switch ($column) {
                        case 'folio':
                            $query->where($column, $value);
                            break;
                        case 'folio_oc':
                            $query->where($column, $value);
                            break;
                        case 'folio_sigfe':
                            switch ($value) {
                                case 'con_folio':
                                    $query->whereNotNull('folio_sigfe');
                                    break;
                                case 'sin_folio':
                                    $query->whereNull('folio_sigfe');
                                    break;
                                    // Con todos no debería hacer nada asi que no lo considero
                            }
                            break;
                        case 'sender_status':
                            switch ($value) {
                                case 'no confirmadas y enviadas a confirmación':
                                    $query->whereNull('confirmation_status')->whereNotNull('confirmation_send_at');
                                    break;
                                case 'Enviado a confirmación':
                                    $query->whereNotNull('confirmation_send_at');
                                    break;
                                case 'Confirmada':
                                    $query->whereNotNull('confirmation_send_at')->where('confirmation_status', 1);
                                    break;
                                case 'No Confirmadas':
                                    $query->whereNotNull('confirmation_send_at')->whereNull('confirmation_status');
                                    break;
                                case 'Confirmadas':
                                    $query->whereNotNull('confirmation_send_at')->where('confirmation_status', 1);
                                    break;
                                case 'Rechazadas':
                                    $query->whereNotNull('confirmation_send_at')->where('confirmation_status', 0);
                                    break;
                                case 'Sin Envío':
                                    $query->whereNull('confirmation_send_at')->whereNull('confirmation_status');
                                    break;
                            }
                            break;

                        case 'selected_establishment':
                            $query->where('establishment_id', $value);
                            break;
                    }
                }
            }
        }
    }
}
