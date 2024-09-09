<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HealthService extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'region_id',
    ];

    /**
     * Get the region that owns the health service.
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(ClRegion::class);
    }

    /**
     * Get the establishments for the health service.
     */
    public function establishments(): HasMany
    {
        return $this->hasMany(Establishment::class);
    }
}
