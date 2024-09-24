<?php

namespace App\Models\Pharmacies;

use App\Models\Pharmacies\DispatchItem;
use App\Models\Pharmacies\DispatchVerificationMailing;
use App\Models\Pharmacies\Destiny;
use App\Models\Pharmacies\File;
use App\Models\Pharmacies\InventoryAdjustment;
use App\Models\Pharmacies\Pharmacy;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dispatch extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'frm_dispatches';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'date',
        'pharmacy_id',
        'destiny_id',
        'notes',
        'inventory_adjustment_id',
        'user_id',
        'receiver_id',
        'sendC19',
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
     * Get the pharmacy that owns the dispatch.
     *
     * @return BelongsTo
     */
    public function pharmacy(): BelongsTo
    {
        return $this->belongsTo(Pharmacy::class);
    }

    /**
     * Get the items for the dispatch.
     *
     * @return HasMany
     */
    public function dispatchItems(): HasMany
    {
        return $this->hasMany(DispatchItem::class);
    }

    /**
     * Get the destiny that owns the dispatch.
     *
     * @return BelongsTo
     */
    public function destiny(): BelongsTo
    {
        return $this->belongsTo(Destiny::class);
    }

    /**
     * Get the user that owns the dispatch.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    /**
     * Get the receiver that owns the dispatch.
     *
     * @return BelongsTo
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id')->withTrashed();
    }

    /**
     * Get the files for the dispatch.
     *
     * @return HasMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    /**
     * Get the verification mailings for the dispatch.
     *
     * @return HasMany
     */
    public function verificationMailings(): HasMany
    {
        return $this->hasMany(DispatchVerificationMailing::class);
    }

    /**
     * Get the inventory adjustment that owns the dispatch.
     *
     * @return BelongsTo
     */
    public function inventoryAdjustment(): BelongsTo
    {
        return $this->belongsTo(InventoryAdjustment::class);
    }
}
