<?php

namespace App\Models\Pharmacies;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryAdjustment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'frm_inventory_adjustments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'date',
        'inventory_adjustment_type_id',
        'pharmacy_id',
        'user_id',
        'notes',
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
     * Get the pharmacy that owns the inventory adjustment.
     *
     * @return BelongsTo
     */
    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(Pharmacy::class);
    }

    /**
     * Get the user that owns the inventory adjustment.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    /**
     * Get the type of the inventory adjustment.
     *
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(InventoryAdjustmentType::class, 'inventory_adjustment_type_id');
    }

    /**
     * Get the receiving associated with the inventory adjustment.
     *
     * @return HasOne
     */
    public function receiving(): HasOne
    {
        return $this->hasOne(Receiving::class);
    }

    /**
     * Get the dispatch associated with the inventory adjustment.
     *
     * @return HasOne
     */
    public function dispatch(): HasOne
    {
        return $this->hasOne(Dispatch::class);
    }
}
