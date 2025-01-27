<?php

namespace App\Models\Documents\Agreements;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Number;

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

    public function amountInWords(): Attribute
    {
        return Attribute::make(
            get: fn (): string => Number::spell($this->amount,locale:'es')
        );
    }

    public function amountFormat(): Attribute
    {
        return Attribute::make(
            get: fn (): string => number_format($this->amount, 0, '', '.')
        );
    }
}
