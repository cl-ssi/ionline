<?php

namespace App\Models\RequestForms;

use App\Models\RequestForms\ItemRequestForm;
use App\User;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchasingProcessDetail extends Pivot
{
    use SoftDeletes;
    
    protected $table = 'arq_purchasing_process_detail';

    protected $fillable = [
        'id', 'purchasing_process_id', 'item_request_form_id', 'internal_purchase_order_id', 'petty_cash_id', 'fund_to_be_settled_id', 'tender_id',
        'immediate_purchase_id', 'user_id', 'quantity', 'unit_value', 'expense', 'status'
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

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    public function immediatePurchase()
    {
        return $this->belongsTo(ImmediatePurchase::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getPurchasingTypeName(){
        if($this->internalPurchaseOrder) return 'OC interna';
        elseif($this->pettyCash) return 'Fondo menor';
        elseif($this->fundToBeSettled) return 'Fondo a rendir';
        elseif($this->tender) return $this->tender->purchaseType->name ?? '';
        elseif($this->immediatePurchase) return $this->itemRequestForm->requestForm->father ? 'Orden de compra' : $this->immediatePurchase->purchaseType->name;
        else return '';
        // return $this->internalPurchaseOrder ? 'OC interna' : ($this->pettyCash ? 'Fondo menor' : ($this->fundToBeSettled ? 'Fondo a rendir' : ($this->tender ? $this->tender->purchaseType->name : '')));
    }
}