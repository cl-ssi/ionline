<?php

namespace App\Models\Pharmacies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receiving extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'frm_receivings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'date',
        'establishment_id',
        'pharmacy_id',
        'notes',
        'inventory_adjustment_id',
        'order_number',
        'user_id',
        'created_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * Get the pharmacy that owns the receiving.
     *
     * @return BelongsTo
     */
    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(Pharmacy::class);
    }

    /**
     * Get the receiving items for the receiving.
     *
     * @return HasMany
     */
    public function receivingItems(): HasMany
    {
        return $this->hasMany(ReceivingItem::class);
    }

    /**
     * Get the establishment that owns the receiving.
     *
     * @return BelongsTo
     */
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    /**
     * Get the user that created the receiving.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the inventory adjustment associated with the receiving.
     *
     * @return BelongsTo
     */
    public function inventoryAdjustment(): BelongsTo
    {
        return $this->belongsTo(InventoryAdjustment::class);
    }
}
