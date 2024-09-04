<?php

namespace App\Models\Parameters;

use App\Models\Establishment;
use App\Models\Inv\Inventory;
use App\Models\Inv\InventoryMovement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Place extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cfg_places';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'architectural_design_code',
        'location_id',
        'establishment_id',
        'floor_number',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //
    ];

    /**
     * Get the location that owns the place.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the establishment that owns the place.
     */
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    /**
     * Get the computers for the place.
     */
    public function computers(): HasMany
    {
        return $this->hasMany(\App\Models\Resources\Computer::class);
    }

    /**
     * Get the inventories for the place.
     */
    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class, 'place_id');
    }

    /**
     * Get the inventory movements for the place.
     */
    public function inventoryMovements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class, 'place_id');
    }

    /**
     * Get the QR code attribute.
     */
    public function getQrAttribute(): string
    {
        return QrCode::size(150)
            ->generate(route('parameters.places.board', [
                'establishment' => $this->establishment_id,
                'place' => $this->id,
            ]));
    }

    /**
     * Get the small QR code attribute.
     */
    public function getQrSmallAttribute(): string
    {
        return QrCode::size(74)
            ->generate(route('parameters.places.board', [
                'establishment' => $this->establishment_id,
                'place' => $this->id,
            ]));
    }
}
