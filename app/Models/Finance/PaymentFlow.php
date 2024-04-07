<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PaymentFlow extends Model
{
    use HasFactory;

    protected $table = 'fin_dte_payment_flows';
    
    protected $fillable = [
        'dte_id',
        'status',
        'user_id',
        'observation',
    ];

    public function dte()
    {
        return $this->belongsTo(Dte::class, 'dte_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    
}
