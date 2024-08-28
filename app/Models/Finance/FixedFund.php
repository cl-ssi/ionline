<?php

namespace App\Models\Finance;

use App\Models\Rrhh\OrganizationalUnit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedFund extends Model
{
    use HasFactory;

    protected $table = "fin_fixed_funds";

    protected $fillable = [
        'concept',
        'user_id',
        'organizational_unit_id',
        'period',
        'res_number',
        'total',
        'delivery_date',
        'rendition_date',
        'status',
        'observations',
        'rendition_amount',
        'refund_amount',
    ];

    protected $casts = [
        'period' => 'date:Y-m',
        'delivery_date' => 'date',
        'rendition_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function organizationalUnit()
    {
        return $this->belongsTo(OrganizationalUnit::class);
    }

}
