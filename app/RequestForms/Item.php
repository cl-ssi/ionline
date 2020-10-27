<?php

namespace App\RequestForms;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $table = "arq_items";

    protected $fillable = [
        'item', 'quantity', 'specification', 'item_estimated_expense',
        'expense', 'request_form_id', 'request_form_item_codes_id'
    ];

    public function getQuantityFormatAttribute()
    {
      return number_format($this->quantity, 0, ',', '.');
    }

    public function request_form() {
        return $this->belongsTo('App\RequestForms\RequestForm');
    }

    public function request_form_item_codes() {
        return $this->belongsTo('App\RequestForms\RequestFormItemCode');
    }

}
