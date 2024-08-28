<?php

namespace App\Models\Vaccination;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Slot extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vac_slots';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_at',
        'end_at',
        'available',
        'used',
        'day_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_at' => 'datetime',
        'end_at'   => 'datetime'
    ];

    /**
     * Get the day that owns the slot.
     *
     * @return BelongsTo
     */
    public function day(): BelongsTo
    {
        return $this->belongsTo(Day::class);
    }
}