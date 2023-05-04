<?php

namespace App\Models\RequestForms;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Parameters\Supplier;
use App\Models\Parameters\PurchaseType;
use App\Models\Finance\Dte;

class ImmediatePurchase extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'purchase_type_id', 'cot_id', 'po_id', 'po_date', 'po_sent_date', 'po_accepted_date', 'po_with_confirmed_receipt_date',
        'po_amount', 'estimated_delivery_date', 'days_type_delivery', 'days_delivery', 'description', 'supplier_id', 'tender_id',
        'resol_supplementary_agree', 'resol_awarding', 'resol_purchase_intention', 'destination_warehouse', 'supplier_specifications',
        'po_status', 'po_discounts', 'po_charges', 'po_net_amount', 'po_tax_percent', 'po_tax_amount', 'po_supplier_name', 
        'po_supplier_activity', 'po_supplier_office_name', 'po_supplier_office_run', 'po_supplier_address', 'po_supplier_commune', 
        'po_supplier_region', 'po_supplier_contact_name', 'po_supplier_contact_position', 'po_supplier_contact_phone', 'po_supplier_contact_email'
    ];

    public $dates = [
        'po_date', 'po_sent_date', 'po_accepted_date', 'po_with_confirmed_receipt_date', 'estimated_delivery_date'
    ];

    protected $table = 'arq_immediate_purchases';

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    public function purchaseType()
    {
        return $this->belongsTo(PurchaseType::class, 'purchase_type_id');
    }

    public function attachedFiles()
    {
        return $this->hasMany(AttachedFile::class);
    }

    public function purchasingProcessDetail()
    {
        return $this->hasOne(PurchasingProcessDetail::class);
    }

    /** Relación con el formulario de requerimiento
     * Sin embargo no puedo hacer busquedas de FRs utilizando esta relación
     * ejemplo: ImmediatePurchase::whereRelation('requestForm','id',2208)->get()
     */
    public function requestForm()
    {
        return $this->purchasingProcessDetail->itemRequestForm->requestForm();
    }

    /** Documentos Tributarios */
    public function dtes()
    {
        return $this->hasMany(Dte::class,'folio_oc','po_id');
    }
}
