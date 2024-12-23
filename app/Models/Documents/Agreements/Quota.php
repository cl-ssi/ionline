<?php

namespace App\Models\Documents\Agreements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quota extends Model
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
        'process_id',
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
    public function process(): BelongsTo
    {
        return $this->belongsTo(Process::class);
    }
}
