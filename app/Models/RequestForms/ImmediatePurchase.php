<?php

namespace App\Models\RequestForms;

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
        'po_date', 'po_sent_date', 'po_accepted_date', 'po_with_confirmed_receipt_date',
        'po_amount', 'estimated_delivery_date', 'supplier_id'
    ];

    public $dates = [
        'po_date', 'po_sent_date', 'po_accepted_date', 'po_with_confirmed_receipt_date',
        'estimated_delivery_date'
    ];

    protected $table = 'arq_immediate_purchases';
}
