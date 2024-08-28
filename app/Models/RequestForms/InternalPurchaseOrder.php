<?php

namespace App\Models\RequestForms;

use App\Models\Parameters\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class InternalPurchaseOrder extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'arq_internal_purchase_orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'supplier_id',
        'payment_condition',
        'user_id',
        'request_form_id',
        'estimated_delivery_date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime',
        'estimated_delivery_date' => 'datetime',
    ];

    /**
     * Get the supplier that owns the internal purchase order.
     *
     * @return BelongsTo
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    // public function user(){
    //     return $this->belongsTo(User::class);
    // }

    // public function purchasingProcess() {
    //     return $this->belongsTo(PurchasingProcess::class);
    // }
}