<?php

namespace app\Models\RequestForms;

use Illuminate\Database\Eloquent\Model;
use App\Models\RequestForms\RequestForm;
use App\Models\Parameters\BudgetItem;

class ItemRequestForm extends Model
{
    public $table = "arq_item_request_forms";

    protected $fillable = [
        'article', 'unit_of_measurement', 'quantity', 'unit_value', 'specification', 'tax',
        'expense', 'request_form_id', 'budget_item', 'budget_item_id'
    ];

    public function requestForm() {
        return $this->belongsTo(RequestForm::class);
    }

    public function budgetItem() {
        return $this->belongsTo(BudgetItem::class);
    }

}
