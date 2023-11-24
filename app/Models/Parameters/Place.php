<?php

namespace App\Models\Parameters;

use App\Models\Establishment;
use App\Models\Inv\Inventory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Place extends Model
{
    use SoftDeletes;

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
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function computers()
    {
        return $this->hasMany('App\Models\Resources\Computer');
    }

    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'place_id');
    }


}
