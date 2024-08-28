<?php

namespace App\Models\Agreements;

use App\Models\Agreements\Agreement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgreementQuota extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'agr_quotas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'percentage',
        'amount',
        'transfer_at',
        'voucher_number',
        'agreement_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'transfer_at' => 'date',
        'percentage' => 'integer'
    ];

    /**
     * Get the agreement.
     */
    public function agreement(): BelongsTo
    {
        return $this->belongsTo(Agreement::class);
    }
}