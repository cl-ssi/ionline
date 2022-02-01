<?php

namespace App\Models\RequestForms;

use App\Models\Parameters\PurchaseType;
use App\Models\Parameters\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ImmediatePurchase extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'purchase_type_id', 'cot_id', 'po_id', 'po_date', 'po_sent_date', 'po_accepted_date', 'po_with_confirmed_receipt_date',
        'po_amount', 'estimated_delivery_date', 'days_type_delivery', 'days_delivery', 'description', 'supplier_id', 'tender_id',
        'resol_supplementary_agree', 'resol_awarding', 'resol_purchase_intention'
    ];

    public $dates = [
        'po_date', 'po_sent_date', 'po_accepted_date', 'po_with_confirmed_receipt_date',
        'estimated_delivery_date'
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
}
