<?php

namespace App\Models;

use App\Models\HealthService;
use App\Models\Commune;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClRegion extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cl_regions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // Add any date attributes here if needed
    ];

    /**
     * Get the health services for the region.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function healthServices(): HasMany
    {
        return $this->hasMany(HealthService::class);
    }

    /**
     * TODO: fixear, dejar sólo una tabla comunas
     * Get the communes for the region.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function communes(): HasMany
    {
        return $this->hasMany(Commune::class);
    }
}