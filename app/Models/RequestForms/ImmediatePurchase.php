<?php

namespace App\Models\RequestForms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;

class ImmediatePurchase extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $fillable = [
        'po_date', 'po_sent_date', 'po_accepted_date', 'po_with_confirmed_receipt_date',
        'po_amount', 'supplier_id', 'estimated_delivery_date'
    ];

    protected $table = 'arq_immediate_purchases';
}
