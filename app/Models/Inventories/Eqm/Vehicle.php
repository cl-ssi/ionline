<?php

namespace App\Models\Inventories\Eqm;

use App\Models\ClRegion;
use App\Models\Establishment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'eqm_vehicles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'region_id',
        'establishment_id',
        'body_type',
        'ambulance_type',
        'ambulance_class',
        'samu',
        'function',
        'brand_id',
        'model',
        'license_plate',
        'engine_number',
        'mileage',
        'ownership_status',
        'conservation_status',
        'acquisition_year',
        'useful_life',
        'residual_useful_life',
        'critical',
        'under_warranty',
        'warranty_expiry_year',
        'under_maintenance_plan',
        'year_entered_maintenance_plan',
        'internal_or_external_maintenance',
        'provider_or_internal_maintenance',
        'maintenance_agreement_id_or_reference',
        'annual_maintenance_cost',
        'annual_maintenance_frequency'
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(ClRegion::class);
    }

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }
}
