<?php

namespace App\Models\RequestForms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PettyCash extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
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
