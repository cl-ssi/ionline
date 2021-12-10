<?php

namespace App\Models\RequestForms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InternalPurchaseOrder extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'date', 'supplier_id', 'payment_condition', 'user_id', 'request_form_id'
    ];

    protected $table = 'arq_purchasing_processes';
}
