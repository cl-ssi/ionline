<?php

namespace app\Models\RequestForms;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $table = "arq_items";

    protected $fillable = [
        'article', 'unitOfMeasurement', 'quantity', 'unitValue', 'specification', 'tax', 'item_estimated_expense',
        'expense', 'request_form_id', 'request_form_item_codes_id'
    ];

    public function request_form() {
        return $this->belongsTo('app\Model\RequestForms\RequestForm');
    }

}
