<?php

namespace App\Models\RequestForms;

use App\Models\Parameters\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InternalPurchaseOrder extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'date', 'supplier_id', 'payment_condition', 'user_id', 'request_form_id'.
        'estimated_delivery_date'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    protected $dates = ['date', 'estimated_delivery_date'];

    protected $table = 'arq_internal_purchase_orders';
}
