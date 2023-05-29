<?php

namespace App\Models\Agreements;

use Illuminate\Database\Eloquent\Model;

class ProgramQuotaMinsal extends Model
{
    public function program() {
        return $this->belongsTo('App\Models\Agreements\Program');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'percentage', 'amount', 'transfer_at', 'voucher_number'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['transfer_at'];
    protected $casts = ['percentage' => 'integer'];

    protected $table = 'agr_quotas_minsal';
}
