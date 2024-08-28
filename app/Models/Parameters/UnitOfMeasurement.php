<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitOfMeasurement extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cfg_unit_of_measurements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'prefix'
    ];

    /**
     * Get the request services for the unit of measurement.
     *
     * @return HasMany
     */
    // public function RequestServices() {
    //     return $this->hasMany(RequestService::class);
    // }

}
