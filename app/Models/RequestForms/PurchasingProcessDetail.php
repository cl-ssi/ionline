<?php

namespace App\Models\RequestForms;

use app\Models\RequestForms\ItemRequestForm;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchasingProcessDetail extends Pivot
{
    use SoftDeletes;
    
    protected $table = 'arq_purchasing_process_detail';

    protected $fillable = [
        'id', 'purchasing_process_id', 'item_id', 'internal_purchase_order_id', 'petty_cash_id', 'funds_to_be_settled_id', 'user_id',
        'quantity', 'unit_value', 'expense', 'status'
    ];

    public function purchasingProcess() {
        return $this->belongsTo(PurchasingProcess::class);
    }

    public function itemRequestForm() {
        return $this->belongsTo(ItemRequestForm::class);
    }

    public function internalPurchaseOrder() {
        return $this->belongsTo(internalPurchaseOrder::class);
    }

    public function pettyCash() {
        return $this->belongsTo(PettyCash::class);
    }

    public function fundToBeSettled(){
        return $this->belongsTo(FundToBeSettled::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}