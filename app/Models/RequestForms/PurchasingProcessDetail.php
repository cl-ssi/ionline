<?php

namespace App\Models\RequestForms;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchasingProcessDetail extends Pivot
{
    use SoftDeletes;
    
    protected $table = 'arq_purchasing_process_detail';

    protected $fillable = [
        'id', 'purchasing_process_id', 'item_request_form_id', 'internal_purchase_order_id', 'petty_cash_id', 'fund_to_be_settled_id', 'tender_id',
        'direct_deal_id', 'immediate_purchase_id', 'user_id', 'quantity', 'unit_value', 'expense', 'status'
    ];

    public function purchasingProcess() {
        return $this->belongsTo('App\RequestForms\PurchasingProcess');
    }

    public function itemRequestForm() {
        return $this->belongsTo('App\RequestForms\ItemRequestForm');
    }

    public function internalPurchaseOrder() {
        return $this->belongsTo('App\RequestForms\InternalPurchaseOrder');
    }

    public function pettyCash() {
        return $this->belongsTo('App\RequestForms\PettyCash');
    }

    public function fundToBeSettled(){
        return $this->belongsTo('App\RequestForms\FundToBeSettled');
    }

    public function tender()
    {
        return $this->belongsTo('App\RequestForms\Tender');
    }

    public function directDeal()
    {
        return $this->belongsTo('App\RequestForms\DirectDeal');
    }

    public function immediatePurchase()
    {
        return $this->belongsTo('App\RequestForms\ImmediatePurchase');
    }

    public function user(){
        return $this->belongsTo('App\User');
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
}