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
        'applicant',
        'brand',
        'model',
        'serial_number',
        'po_code',
        'po_price',
        'po_date',
        'deliver_date',
        'reception_confirmation',
        'user_id',
        'organization_id',
        'product_id',
        'po_id',
        'control_id',
        'place_id',
        'store_id',
        'request_form_id',
    ];
}
