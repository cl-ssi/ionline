<?php

namespace app\Models\RequestForms;

use Illuminate\Database\Eloquent\Model;
use App\Model\RequestForms\RequestForm;

class ItemRequestForm extends Model
{
    public $table = "arq_item_request_forms";

    protected $fillable = [
        'article', 'unit_of_measurement', 'quantity', 'unit_value', 'specification', 'tax',
        'expense', 'request_form_id'
    ];

    public function requestForm() {
        return $this->belongsTo(RequestForm::class, 'request_form_id');
    }

}
