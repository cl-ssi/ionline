<?php

namespace App\Agreements;

use Illuminate\Database\Eloquent\Model;

class AgreementQuota extends Model
{
    public function agreement() {
        return $this->belongsTo('App\Agreements\Agreement');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'amount', 'percentage', 'transfer_at', 'voucher_number'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['transfer_at'];
    protected $casts = ['percentage' => 'integer'];

    protected $table = 'agr_quotas';
}
