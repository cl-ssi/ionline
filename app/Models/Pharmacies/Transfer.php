<?php

namespace App\Models\Pharmacies;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pharmacies\Destiny;

class Transfer extends Model
{
    protected $fillable = [
        'quantity', 'remarks'
    ];

    protected $table = 'frm_transfers';

    /**
     * Get the user that created the receiving.
     *
     * @return BelongsTo
     */
    public function destiny_from(): BelongsTo
    {
        return $this->belongsTo(Destiny::class, 'from');
    }

    /**
     * Get the user that created the receiving.
     *
     * @return BelongsTo
     */
    public function destiny_to(): BelongsTo
    {
        return $this->belongsTo(Destiny::class, 'to');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Pharmacies\Product');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User')->withTrashed();
    }
}
