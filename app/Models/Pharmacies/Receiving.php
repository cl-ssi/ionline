<?php

namespace App\Models\Pharmacies;

use App\Models\User;
use App\Models\Pharmacies\Destiny;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'destiny_id',
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
     * Get the destiny that owns the receiving.
     *
     * @return BelongsTo
     */
    public function destiny(): BelongsTo
    {
        return $this->belongsTo(Destiny::class);
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
