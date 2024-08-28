<?php

namespace App\Models\Agreements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Agreements\Program;

class ProgramQuotaMinsal extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'agr_quotas_minsal';

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
        'voucher_number'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'percentage' => 'integer',
        'transfer_at' => 'datetime'
    ];

    /**
     * Get the program that owns the quota.
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}