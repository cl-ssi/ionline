<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Documents\Approval;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\PurchaseOrder;
use App\Models\RequestForms\Invoice;
use App\Models\Parameters\Supplier;
use App\Models\Parameters\Program;
use App\Models\Finance\Dte;
use App\Models\Documents\Signature;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Finance\Receptions\Reception;

class Control extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wre_controls';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'date',
        'note',
        'confirm',
        'po_code',
        'po_date',
        'document_type',
        'document_number',
        'document_date',
        'status',
        'completed_invoices',
        'store_id',
        'origin_id',
        'destination_id',
        'type_dispatch_id',
        'type_reception_id',
        'store_origin_id',
        'store_destination_id',
        'supplier_id',
        'program_id',
        'po_id',
        'request_form_id',
        'organizational_unit_id',
        'technical_signature_id',
        'technical_signer_id',
        'reception_visator_id',


        //Datos del Administrador de contrato
        'require_contract_manager_visation',
        'visation_contract_manager_user_id',
        'visation_contract_manager_ou',
        'visation_contract_manager_at',
        'visation_contract_manager_status',
        'visation_contract_manager_rejection_observation',

        //Datos del jefe de bodega
        'visation_warehouse_manager_user_id',
        'visation_warehouse_manager_ou',
        'visation_warehouse_manager_at',
        'visation_warehouse_manager_status',
        'visation_warehouse_manager_rejection_observation',

        //dato relacion con reception
        'reception_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the store that owns the control.
     *
     * @return BelongsTo
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the program that owns the control.
     *
     * @return BelongsTo
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the supplier that owns the control.
     *
     * @return BelongsTo
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get the purchase order that owns the control.
     *
     * @return BelongsTo
     */
    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_id');
    }

    /**
     * Get the request form that owns the control.
     *
     * @return BelongsTo
     */
    public function requestForm(): BelongsTo
    {
        return $this->belongsTo(RequestForm::class);
    }

    /**
     * Get the origin that owns the control.
     *
     * @return BelongsTo
     */
    public function origin(): BelongsTo
    {
        return $this->belongsTo(Origin::class);
    }

    /**
     * Get the destination that owns the control.
     *
     * @return BelongsTo
     */
    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    /**
     * Get the items for the control.
     *
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(ControlItem::class, 'control_id');
    }

    /**
     * Get the type dispatch that owns the control.
     *
     * @return BelongsTo
     */
    public function typeDispatch(): BelongsTo
    {
        return $this->belongsTo(TypeDispatch::class);
    }

    /**
     * Get the type reception that owns the control.
     *
     * @return BelongsTo
     */
    public function typeReception(): BelongsTo
    {
        return $this->belongsTo(TypeReception::class);
    }

    /**
     * Get the destination store that owns the control.
     *
     * @return BelongsTo
     */
    public function destinationStore(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_destination_id');
    }

    /**
     * Get the origin store that owns the control.
     *
     * @return BelongsTo
     */
    public function originStore(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_origin_id');
    }

    /**
     * Get the invoices for the control.
     *
     * @return HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the organizational unit that owns the control.
     *
     * @return BelongsTo
     */
    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class);
    }

    /**
     * Get the dtes for the control.
     *
     * @return HasMany
     */
    public function dtes(): HasMany
    {
        return $this->hasMany(Dte::class, 'folio_oc', 'po_code');
    }

    /**
     * Recepción Técnica: Usuario Firmante
     */
    /**
     * Get the technical signer that owns the control.
     *
     * @return BelongsTo
     */
    public function technicalSigner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Recepción Técnica: Firma Digital
     */
    public function technicalSignature(): BelongsTo
    {
        return $this->belongsTo(Signature::class);
    }

    /**
     * Recepción Digital: Usuario que da Ingreso a Bodega (visador de la bodega)
     */
        /**
     * Get the reception visator that owns the control.
     *
     * @return BelongsTo
     */
    public function receptionVisator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the reception that owns the control.
     *
     * @return BelongsTo
     */
    public function reception(): BelongsTo
    {
        return $this->belongsTo(Reception::class);
    }

    /**
     * Get the approvals for the control.
     *
     * @return MorphMany
     */
    public function approvals(): MorphMany
    {
        return $this->morphMany(Approval::class, 'approvable');
    }


    public function isReceiving()
    {
        return $this->type == 1;
    }

    public function isDispatch()
    {
        return $this->type == 0;
    }

    public function isInternalDispatch()
    {
        return $this->isDispatch() && ($this->type_dispatch_id == TypeDispatch::internal());
    }

    public function isAdjustInventory()
    {
        return $this->isDispatch() && ($this->type_dispatch_id == TypeDispatch::adjustInventory());
    }

    public function isSendToStore()
    {
        return $this->isDispatch() && ($this->type_dispatch_id == TypeDispatch::sendToStore());
    }

    public function isExternalDispatch()
    {
        return $this->isDispatch() && ($this->type_dispatch_id == TypeDispatch::external());
    }

    public function isReceptionNormal()
    {
        return $this->isReceiving() && ($this->type_reception_id == TypeReception::receiving());
    }

    public function isReceiveFromStore()
    {
        return $this->isReceiving() && ($this->type_reception_id == TypeReception::receiveFromStore());
    }

    public function isPurchaseOrder()
    {
        return $this->isReceiving() && ($this->type_reception_id == TypeReception::purchaseOrder());
    }

    public function isConfirmed()
    {
        return $this->confirm == true;
    }

    public function isClose()
    {
        return $this->status == false;
    }

    public function isOpen()
    {
        return $this->status == true;
    }

    public function getTypeFormatAttribute()
    {
        return ($this->type) ? 'Ingreso' : 'Egreso';
    }

    public function getDateFormatAttribute()
    {
        return $this->date->format('Y-m-d');
    }

    public function getShortNoteAttribute()
    {
        return Str::limit($this->note, 20);
    }

    public function getProgramNameAttribute()
    {
        $programName = 'Sin Programa';
        if($this->program)
            $programName = $this->program->period . " - " . $this->program->name;
        return $programName;
    }

    public function getColorConfirmAttribute()
    {
        $status = 'danger';
        if($this->isConfirmed())
            $status = 'success';
        return $status;
    }

    public function getConfirmFormatAttribute()
    {
        $status = 'no confirmado';
        if($this->isConfirmed())
            $status = 'confirmado';
        return $status;
    }

    public function getNetTotalAttribute()
    {
        return $this->items->sum('total_price');
    }

    public function getTotalTaxAttribute()
    {
        return $this->items->sum('tax');
    }

    public function getTotalAttribute()
    {
        return $this->net_total + $this->total_tax;
    }

    public function getFormatDateAttribute()
    {
        return $this->date->day . ' de ' . $this->date->monthName . ' del ' . $this->date->year;
    }

    public function getDocumentTypeTranslateAttribute()
    {
        switch ($this->document_type) {
            case 'invoice':
                $documentType = "Factura";
                break;

            case 'guide':
                $documentType = "Guía";
                break;

            default:
                $documentType = "";
                break;
        }
        return $documentType;
    }
}
