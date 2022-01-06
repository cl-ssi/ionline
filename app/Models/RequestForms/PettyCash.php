<?php

namespace App\Models\RequestForms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PettyCash extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'date', 'amount', 'receipt_number', 'receipt_type', 'file', 'user_id', 'purchasing_process_id'
    ];

    protected $table = 'arq_petty_cash';

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function purchasingProcess() {
        return $this->belongsTo(PurchasingProcess::class);
    }

    protected $dates = [
        'date',
    ];
}
