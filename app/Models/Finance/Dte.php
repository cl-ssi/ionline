<?php

namespace App\Models\Finance;

use App\Observers\Finance\DteObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\User;
use App\Models\File as FileModel;
use App\Models\Warehouse\Control;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\ImmediatePurchase;
use App\Models\Finance\Receptions\Reception;
use App\Models\Finance\PurchaseOrder;
use App\Models\Finance\File;
use App\Models\Finance\TgrPayedDte;
use App\Models\Finance\ComparativeRequirement;
use App\Models\Finance\TgrAccountingPortfolio;
use App\Models\Establishment;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\Sigfe\PdfBackup;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[ObservedBy([DteObserver::class])]
class Dte extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
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

        // Administrador de contrato
        'contract_manager_id',

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

        // Nombre antiguos Campos
        // 'confirmation_user_id',
        // 'confirmation_ou_id',
        // 'confirmation_at',

        // Nombre nuevos campos
        'completed_user_id',
        'completed_ou_id',
        'completed_at',


        // Se reemplaza por el  reason_rejection confirmation_observation = reason_rejection
        //'confirmation_observation',
        'confirmation_signature_file',

        'dte_id',

        /** Estas 4 ya no deberian usarse, eran del modulo de warehouse */
        'cenabast_reception_file',
        'cenabast_signed_pharmacist',
        'cenabast_signed_boss',
        'block_signature',

        'folio_compromiso_sigfe',
        'archivo_compromiso_sigfe',

        'folio_devengo_sigfe',
        'archivo_devengo_sigfe',

        'devuelto',

        //campos de rechazo
        'rejected',
        'reason_rejection',
        'rejected_user_id',
        'rejected_at',

        'comprobante_liquidacion_fondo',
        'archivo_carga_manual',


        // nombres mas adecuados a los campos
        'all_receptions',
        'all_receptions_user_id',
        'all_receptions_ou_id',
        'all_receptions_at',

        'excel_proveedor',
        'excel_cartera',
        'excel_requerimiento',

        'observation',

        'paid_automatic',
        'paid_manual',
        'check_tesoreria',
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'all_receptions_at' => 'datetime',
        'emision' => 'date:Y-m-d',
        'publicacion' => 'date:Y-m-d',
        'fecha_nar' => 'date:Y-m-d',
        'fecha_arm' => 'date:Y-m-d',
        'fecha_vencimiento' => 'date:Y-m-d',
        'fecha_recepcion_sii' => 'date:Y-m-d',
        'fecha_reclamo' => 'date:Y-m-d',
        'fecha_ingreso_oc' => 'date:Y-m-d',
        'fecha_ingreso_rc' => 'date:Y-m-d',
        'fecha_ingreso' => 'date:Y-m-d',
        'fecha_aceptacion' => 'date:Y-m-d',
        'fecha' => 'date:Y-m-d',
        'payer_at' => 'datetime',
        'confirmation_at' => 'datetime',
    ];

    /**
     * tipo_documento
     * ==============
     * factura_electronica
     * factura_exenta
     * guias_despacho
     * nota_debito
     * nota_credito
     * boleta_honorarios
     * boleta_electronica
     */
    

    /**
     * Get the purchase order associated with the DTE.
     *
     * @return BelongsTo
     */
    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class, 'folio_oc', 'code');
    }

    /**
     * Control (ingresos) de Warehouse.
     *
     * @return HasMany
     */
    public function controls(): HasMany
    {
        return $this->hasMany(Control::class, 'po_code', 'folio_oc');
    }

    /**
     * Get the receptions associated with the guia.
     *
     * @return HasMany
     */
    public function receptionsGuia(): HasMany
    {
        return $this->hasMany(Reception::class, 'guia_id');
    }

    /**
     * Get the receptions associated with the DTE.
     *
     * @return HasMany
     */
    public function receptionsDte(): HasMany
    {
        return $this->hasMany(Reception::class, 'dte_id');
    }

    /**
     * Una factura puede tener muchas dtes
     * y las DTES deberían ser del tipo guia, notas de crédito o débito
     */
    public function dtes(): BelongsToMany
    {
        return $this->belongsToMany(Dte::class,'fin_invoice_dtes','invoice_id','dte_id')->withTimestamps();
    }

    /**
     * Y por el contrario, una DTE de tipo guia de despacho, nota de crédito o débito
     * podría pertenecer a una o muchas facturas
     */
    /**
     * Get the invoices associated with the DTE.
     *
     * @return BelongsToMany
     */
    public function invoices(): BelongsToMany
    {
        return $this->belongsToMany(Dte::class, 'fin_invoice_dtes', 'dte_id', 'invoice_id')->withTimestamps();
    }
    
    /**
     * Get the comparative requirement associated with the DTE.
     *
     * @return HasOne
     */
    public function comparativeRequirement(): HasOne
    {
        return $this->hasOne(ComparativeRequirement::class, 'dte_id');
    }
    
    /**
     * Get the TGR payed DTE associated with the DTE.
     *
     * @return HasOne
     */
    public function tgrPayedDte(): HasOne
    {
        return $this->hasOne(TgrPayedDte::class);
    }
    
    /**
     * Get the TGR accounting portfolios associated with the DTE.
     *
     * @return HasMany
     */
    public function tgrAccountingPortfolios(): HasMany
    {
        return $this->hasMany(TgrAccountingPortfolio::class, 'dte_id');
    }
    
    /**
     * Get the PDF backups associated with the DTE.
     *
     * @return HasMany
     */
    public function pdfBackups(): HasMany
    {
        return $this->hasMany(PdfBackup::class, 'dte_id');
    }

    /**
     * Get the comprobante de pago associated with the DTE.
     *
     * @return HasOne
     */
    public function comprobantePago(): HasOne
    {
        return $this->hasOne(PdfBackup::class, 'dte_id')->where('type', 'comprobante_pago');
    }

    /**
     * Get the payment flows for the DTE.
     *
     * @return HasMany
     */
    public function paymentFlows(): HasMany
    {
        return $this->hasMany(PaymentFlow::class, 'dte_id');
    }
    
    /**
     * Get the files for the DTE.
     *
     * @return HasMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(File::class, 'dte_id');
    }

    
    /**
     * Get all of the files of a model.
     *
     * @return MorphMany
     */
    public function filesPdf(): MorphMany
    {
        return $this->morphMany(FileModel::class, 'fileable');
    }
    
    /**
     * Get the establishment that owns the DTE.
     *
     * @return BelongsTo
     */
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class, 'establishment_id');
    }
    
    /**
     * Get the user that confirmed the DTE.
     *
     * @return BelongsTo
     */
    public function confirmationUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmation_user_id');
    }

    /** Fue cambiada por contract manager, borrar más adelante */
    // public function uploadUser()
    // {
    //     return $this->belongsTo(User::class, 'upload_user_id');
    // }

    /**
     * Get the contract manager that owns the DTE.
     *
     * @return BelongsTo
     */
    public function contractManager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'contract_manager_id')->withTrashed();
    }
    
    /**
     * Get the user for all receptions of the DTE.
     *
     * @return BelongsTo
     */
    public function allReceptionsUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'all_receptions_user_id');
    }
    
    /**
     * Get the organizational unit for all receptions of the DTE.
     *
     * @return BelongsTo
     */
    public function allReceptionsOU(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'all_receptions_ou_id');
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

    
    /** Tiene muchos receptions */
    //FIXME: no se puede utilizar esta relación con with para evitar el n+1 query
    public function receptions()
    {
        if($this->tipo_documento =='guias_despacho')
        {
            return $this->hasMany(Reception::class,'guia_id', 'id');
        }
        else{
            return $this->hasMany(Reception::class);
        }
    }

    /**
     * Get the treasury model.
     */
    public function treasury(): MorphOne
    {
        return $this->morphOne(Treasury::class, 'treasureable');
    }

    /**
     * Get the treasury model.
     */
    public function accountable(): MorphOne
    {
        return $this->morphOne(Accountancy::class, 'accountable');
    }

    protected function treasuryId(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->id,
        );
    }

    protected function treasurySubject(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->tipo_documento,
        );
    }

    protected function modelName(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Documento tributario',
        );
    }

    // public function getTipoDocumentoAttribute(){
    //     return strtoupper(str_replace('_',' ',$this->tipo_documento));
    // }

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

    /**
    * El semaforo
    * Obtener el color de la fila, en base a la fecha de aceptación
    */
    public function getRowClassAttribute()
    {
        $rowClass = '';
        $daysDifference = $this->fecha_recepcion_sii ? (int) $this->fecha_recepcion_sii->diffInDays(now()) : null;
        if ( !is_null($daysDifference )) {
            switch($daysDifference) {
                case 1:
                case 2:
                case 3:
                case 4:
                    $rowClass = 'table-success';
                    break;
                case 5:
                    $rowClass = 'table-info';
                    break;
                case 6:
                case 7:
                case 8:
                    $rowClass = 'table-warning';
                    break;
                default:
                    $rowClass = 'table-danger';
                    break;
            }
        }
        return $rowClass;
    }
    public function getRejectedReceptionAttribute()
    {
        return $this->receptions()->where('rejected', true)->exists();
    }

    public function totalDebe()
    {
        return $this->tgrAccountingPortfolios()->sum('debe');
    }

    public function totalHaber()
    {
        return $this->tgrAccountingPortfolios()->sum('haber');
    }

    public function getTipoDocumentoInicialesAttribute()
    {
        return strtoupper(implode('', array_map(fn($s) => substr($s, 0, 1), explode("_", $this->tipo_documento))));
    }


    /** Creo que ya no se utiliza */
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

    // public function getConfirmationSignatureFileUrlAttribute()
    // {
    //     return Storage::disk('gcs')->url($this->confirmation_signature_file);
    // }

    // public function getCenabastReceptionFileUrlAttribute()
    // {
    //     return Storage::disk('gcs')->url($this->cenabast_reception_file);
    // }

    // public function getPharmacistAttribute()
    // {
    //     return $this->uploadUser->organizationalUnit->currentManager->user ?? null;
    // }

    // public function getBossAttribute()
    // {
    //     return $this->uploadUser->organizationalUnit->father->currentManager->user ?? null;
    // }
}
