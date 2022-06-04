<?php

namespace App\Models\Inv;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inv_inventories';

    protected $fillable = [
        'number',
        'useful_life',
        'brand',
        'model',
        'serial_number',
        'po_code',
        'po_price',
        'po_date',
        'reception_confirmation',
        'deliver_date',
        'delivered_user_ou_id',
        'delivered_user_id',
        'request_user_ou_id',
        'request_user_id',
        'product_id',
        'control_id',
        'store_id',
        'place_id',
        'po_id',
        'request_form_id',
    ];
}
