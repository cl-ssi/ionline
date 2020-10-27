<?php

namespace App\RequestForms;

use Illuminate\Database\Eloquent\Model;

class RequestFormItemCode extends Model
{
    public $table = "arq_request_form_item_codes";

    protected $fillable = [
        'item_code', 'name'
    ];

    public function getItemCodesAttribute()
    {
      return $this->item_code;
    }

    public function item() {
        return $this->belongsTo('App\RequestForms\Item');
    }

    public function passage() {
        return $this->belongsTo('App\RequestForms\Pasagge');
    }
}
