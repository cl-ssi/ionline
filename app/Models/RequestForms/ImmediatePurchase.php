<?php

namespace App\Models\RequestForms;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\RequestForms\DirectDeal;
use App\Models\Parameters\Supplier;
use App\Models\Parameters\PurchaseType;
use App\Models\Finance\Dte;
use App\Models\RequestForms\RequestForm;
use Illuminate\Support\Str;

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
        'po_supplier_region', 'po_supplier_contact_name', 'po_supplier_contact_position', 'po_supplier_contact_phone', 'po_supplier_contact_email',
        'request_form_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'po_date'                           => 'date', 
        'po_sent_date'                      => 'date', 
        'po_accepted_date'                  => 'date', 
        'po_with_confirmed_receipt_date'    => 'date', 
        'estimated_delivery_date'           => 'date'
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

    public function directDeal()
    {
        return $this->belongsTo(DirectDeal::class);
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
        
        // if($this->tender_id) {
        //     return $this->tender->purchasingProcessDetail->purchasingProcess->requestForm();
        // }
        // elseif($this->direct_deal_id) {
        //     return $this->directDeal->purchasingProcessDetail->purchasingProcess->requestForm();
        // }
        // else {
        //     return $this->purchasingProcessDetail->purchasingProcess->requestForm();
        // }

        return $this->belongsTo(RequestForm::class, 'request_form_id');
        // return $this->purchasingProcessDetail->requestForm();
        // 1. Migracion y agregar request_form_id;
        // 2. Comando que recorra todos los immediatepurchases y le setee el request_form_id
        // 3. Dejar la relacion con bleongTo 
        // 4. Boot created o updated, y guardar automaticamente el request_form_id cuando se cree un modelo ImmediatePurchase
    }

    /** Documentos Tributarios */
    public function dtes()
    {
        return $this->hasMany(Dte::class,'folio_oc','po_id');
    }

    // public static function boot()
    // {
    //     parent::boot();
    //     //while creating/inserting item into db  
    //     static::creating(function ($immediatePurchase) {
    //         if($immediatePurchase->tender_id) {
    //             $immediatePurchase->request_form_id = $immediatePurchase->tender->purchasingProcessDetail->purchasingProcess->requestForm()->first()->id;
    //         }
    //         elseif($immediatePurchase->direct_deal_id) {
    //             $immediatePurchase->request_form_id = $immediatePurchase->directDeal->purchasingProcessDetail->purchasingProcess->requestForm()->first()->id;
    //         }
    //         else {
    //             $immediatePurchase->request_form_id = $immediatePurchase->purchasingProcessDetail->purchasingProcess->requestForm()->first()->id;
    //         }
    //         $immediatePurchase->save();
    //     });
    // }

    public function setPoIdAttribute($value)
    {
        $this->attributes['po_id'] = Str::upper($value);
    }
}
