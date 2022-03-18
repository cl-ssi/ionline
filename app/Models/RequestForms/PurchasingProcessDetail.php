<?php

namespace App\Models\RequestForms;

use App\User;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

use OwenIt\Auditing\Contracts\Auditable;

class PurchasingProcessDetail extends Pivot implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = 'arq_purchasing_process_detail';

    public $incrementing = true;

    protected $fillable = [
        'id', 'purchasing_process_id', 'item_request_form_id', 'internal_purchase_order_id', 'petty_cash_id', 'fund_to_be_settled_id', 'tender_id',
        'direct_deal_id', 'immediate_purchase_id', 'user_id', 'quantity', 'unit_value', 'expense', 'status'
    ];

    public function purchasingProcess() {
        return $this->belongsTo(PurchasingProcess::class, 'purchasing_process_id');
    }

    public function itemRequestForm() {
        return $this->belongsTo(ItemRequestForm::class, 'item_request_form_id');
    }

    public function internalPurchaseOrder() {
        return $this->belongsTo(InternalPurchaseOrder::class, 'internal_purchase_order_id');
    }

    public function pettyCash() {
        return $this->belongsTo(PettyCash::class, 'petty_cash_id');
    }

    public function fundToBeSettled(){
        return $this->belongsTo(FundToBeSettled::class, 'fund_to_be_settled_id');
    }

    public function tender()
    {
        return $this->belongsTo(Tender::class, 'tender_id');
    }

    public function directDeal()
    {
        return $this->belongsTo(DirectDeal::class, 'direct_deal_id');
    }

    public function immediatePurchase()
    {
        return $this->belongsTo(ImmediatePurchase::class, 'immediate_purchase_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getPurchasingTypeName(){
        if($this->internalPurchaseOrder) return 'OC interna';
        elseif($this->pettyCash) return 'Fondo menor';
        elseif($this->fundToBeSettled) return 'Fondo a rendir';
        elseif($this->tender) return $this->tender->purchaseType->name ?? '';
        elseif($this->directDeal) return $this->directDeal->purchaseType->name ?? '';
        elseif($this->immediatePurchase) return $this->itemRequestForm->requestForm->father ? 'Orden de compra' : $this->immediatePurchase->purchaseType->name;
        else return '';
        // return $this->internalPurchaseOrder ? 'OC interna' : ($this->pettyCash ? 'Fondo menor' : ($this->fundToBeSettled ? 'Fondo a rendir' : ($this->tender ? $this->tender->purchaseType->name : '')));
    }

    public function getPurchasingType(){
        if($this->internalPurchaseOrder) return $this->internalPurchaseOrder;
        elseif($this->pettyCash) return $this->pettyCash;
        elseif($this->fundToBeSettled) return $this->fundToBeSettled;
        elseif($this->tender) return $this->tender;
        elseif($this->directDeal) return $this->directDeal;
        elseif($this->immediatePurchase) return $this->immediatePurchase;
        else return null;
    }

    public function getPurchasingTypeColumn(){
        if($this->internalPurchaseOrder) return 'internal_purchase_order_id';
        elseif($this->pettyCash) return 'petty_cash_id';
        elseif($this->fundToBeSettled) return 'fund_to_be_settled_id';
        elseif($this->tender) return 'tender_id';
        elseif($this->directDeal) return 'direct_deal_id';
        elseif($this->immediatePurchase) return 'immediate_purchase_id';
        else return null;
    }
}
