<?php

namespace app\Models\RequestForms;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $table = "arq_items";

    protected $fillable = [
        'article', 'unit_of_measurement', 'quantity', 'unit_value', 'specification', 'tax', 'item_estimated_expense',
        'expense', 'request_form_id', 'request_form_item_codes_id'
    ];

    public function requestForm() {
        return $this->belongsTo('app\Model\RequestForms\RequestForm');
    }

}
