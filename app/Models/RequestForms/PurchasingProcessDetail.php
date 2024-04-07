<?php

namespace App\Models\RequestForms;

use App\Models\User;
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
        'id', 'purchasing_process_id', 'item_request_form_id', 'request_form_id', 'internal_purchase_order_id', 'petty_cash_id', 'fund_to_be_settled_id', 'tender_id',
        'direct_deal_id', 'immediate_purchase_id', 'user_id', 'quantity', 'unit_value', 'tax', 'expense', 'status', 'release_observation',
        'supplier_run', 'supplier_name', 'supplier_specifications', 'charges', 'discounts', 'passenger_request_form_id'
    ];

    public function purchasingProcess() {
        return $this->belongsTo(PurchasingProcess::class, 'purchasing_process_id');
    }

    public function itemRequestForm() {
        return $this->belongsTo(ItemRequestForm::class, 'item_request_form_id')->with('budgetItem');
    }

    public function passenger() {
        return $this->belongsTo(Passenger::class, 'passenger_request_form_id');
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

    public function requestForm(){
        return $this->belongsTo(RequestForm::class, 'request_form_id');
    }

    // public static function boot()
    // {
    //     parent::boot();
        
    //     //while creating/inserting item into db  
    //     static::creating(function ($purchasingProcessDetail) {
    //         if($purchasingProcessDetail->petty_cash_id != null){
    //             $purchasingProcessDetail->immediatePurchase->request_form_id = $purchasingProcessDetail->pettyCash->purchasingProcess->requestForm()->first()->id;
    //             $purchasingProcessDetail->immediatePurchase->save();
    //         }
    //         if($purchasingProcessDetail->direct_deal_id != null){
    //             $purchasingProcessDetail->immediatePurchase->request_form_id = $purchasingProcessDetail->directDeal->purchasingProcessDetail->purchasingProcess->requestForm()->first()->id;
    //             $purchasingProcessDetail->immediatePurchase->save();
    //         }
    //         if($purchasingProcessDetail->tender_id != null){
    //             if($purchasingProcessDetail->immediatePurchase){
    //                 $purchasingProcessDetail->immediatePurchase->request_form_id = $purchasingProcessDetail->purchasingProcess->requestForm()->first()->id;
    //                 $purchasingProcessDetail->immediatePurchase->save();
    //             }
    //         }
    //         if($purchasingProcessDetail->immediate_purchase_id != null){
    //             $purchasingProcessDetail->immediatePurchase->request_form_id = $purchasingProcessDetail->purchasingProcess->requestForm()->first()->id;
    //             $purchasingProcessDetail->immediatePurchase->save();
    //         }
    //     });
    // }

    public function getPurchasingTypeName(){
        if($this->internalPurchaseOrder) return 'OC interna';
        elseif($this->pettyCash) return 'Fondo menor';
        elseif($this->fundToBeSettled) return 'Fondo a rendir';
        elseif($this->tender) return $this->tender->purchaseType->name ?? '';
        elseif($this->directDeal) return $this->directDeal->purchaseType->name ?? '';
        elseif($this->immediatePurchase) return $this->itemRequestForm && $this->itemRequestForm->requestForm->request_form_id ? 'Orden de compra' : $this->immediatePurchase->purchaseType->name;
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

    public function getStatus(){
        switch ($this->status) {
            case "total":
                return 'Comprado';
                break;
            case "desert":
                return 'Desierto';
                break;
        }
    }
}
