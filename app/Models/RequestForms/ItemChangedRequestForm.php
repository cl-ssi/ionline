<?php

namespace App\Models\RequestForms;

use Illuminate\Database\Eloquent\Model;
use App\Models\Parameters\BudgetItem;
use App\Models\Unspsc\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ItemChangedRequestForm extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    public $table = "arq_item_changed_request_forms";

    protected $fillable = [
        'article', 'unit_of_measurement', 'quantity', 'unit_value', 'specification', 'status',
        'tax','expense', 'item_request_form_id', 'budget_item_id', 'article_file', 'type_of_currency',
        'product_id'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function itemRequestForm() {
        return $this->belongsTo(ItemRequestForm::class);
    }

    public function budgetItem() {
        return $this->belongsTo(BudgetItem::class);
    }

    // public function formatExpense()
    // {
    //   return number_format($this->expense,0,",",".");
    // }

}
