<?php

namespace App\Models\Inventories\Eqm;

use App\Models\Inventories\Eqm\Brand;
use App\Models\Inventories\Eqm\Category;
use App\Models\Inventories\Eqm\Supplier;
use App\Models\Inventories\Eqm\Subcategory;
use App\Models\Parameters\Place;
use App\Models\Parameters\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'eqm_equipments';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'id',
        'type',
        'location_id',
        'place_id',
        'category_id',
        'subcategory_id',
        'name',
        'brand_id',
        'model',
        'serial_number',
        'inventory_number',
        'acquisition_year',
        'useful_life',
        'residual_useful_life',
        'property',
        'condition',
        'importance',
        'compilance',
        'assurance',
        'warranty_expiry_year',
        'under_maintenance_plan',
        'year_entered_maintenance_plan',
        'type_of_maintenance',
        'supplier_id',
        'maintenance_reference',
        'annual_cost',
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}
