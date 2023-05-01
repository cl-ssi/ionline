<?php

namespace App\Models\RequestForms;

use Illuminate\Database\Eloquent\Model;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\PurchasingProcess;
use App\Models\Parameters\BudgetItem;
use App\Models\Unspsc\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
//use App\Models\Parameters\PurchaseType;
//use App\Models\Parameters\PurchaseUnit;
//use App\Models\Parameters\PurchaseMechanism;

class ItemRequestForm extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    public $table = "arq_item_request_forms";

    protected $fillable = [
        'article', 'unit_of_measurement', 'quantity', 'unit_value', 'specification',
        'tax','expense', 'request_form_id', 'budget_item_id', 'article_file', 'type_of_currency',
        'product_id'
        //'purchase_unit_id', 'purchase_type_id', 'purchase_mechanism_id', 'budget_item',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function requestForm() {
        return $this->belongsTo(RequestForm::class);
    }

    public function budgetItem() {
        return $this->belongsTo(BudgetItem::class);
    }

    public function itemChangedRequestForms() {
        return $this->hasMany(ItemChangedRequestForm::class, 'item_request_form_id');
    }

    public function latestPendingItemChangedRequestForms() {
        return $this->hasOne(ItemChangedRequestForm::class, 'item_request_form_id')->where('status', 'pending')->latestOfMany();
    }

    public function purchasingProcesses() {
        return $this->hasMany(PurchasingProcess::class, 'item_request_form_id');
    }

    public function getPurchasingProcess($status){
        return PurchasingProcess::Where('status',$status)->Where('item_request_form_id', $this->id)->get()->first();
    }

    public function purchasingProcess(){
      return $this->belongsToMany(PurchasingProcess::class, 'arq_purchasing_process_detail')->withPivot('id', 'internal_purchase_order_id', 'petty_cash_id', 'fund_to_be_settled_id', 'tender_id', 'direct_deal_id', 'immediate_purchase_id', 'user_id', 'quantity', 'unit_value', 'tax', 'expense', 'status', 'release_observation', 'supplier_run', 'supplier_name', 'supplier_specifications', 'charges', 'discounts')->whereNull('arq_purchasing_process_detail.deleted_at')->withTimestamps()->using(PurchasingProcessDetail::class);
    }
/*
    public function purchaseUnit(){
      return $this->belongsTo(PurchaseUnit::class, 'purchase_unit_id');
    }

    public function purchaseType(){
      return $this->belongsTo(PurchaseType::class, 'purchase_type_id');
    }

    public function purchaseMechanism(){
      return $this->belongTo(PurchaseMechanism::class, 'purchase_mechanism_id');
    }
*/

    public function formatExpense()
    {
      return number_format($this->expense,0,",",".");
    }

}
