<?php

namespace App\Models\Inventories\Eqm;

use App\Models\Parameters\Place;
use App\Models\Parameters\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Infrastructure extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'eqm_infrastructures';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'place_id',
        'location_id',
        'infrastructure_element_or_specialty',
        'intervention_type_description',
        'quantity',
        'condition',
        'norm_accreditation_or_not_applicable',
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

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
    }
}
