<?php

namespace App\Models\Vaccination;

use App\Models\Vaccination\Slot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Day extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vac_days';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'day',
        'first_dose_available',
        'first_dose_used'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'day' => 'date'
    ];

    /**
     * Get the slots for the day.
     *
     * @return HasMany
     */
    public function slots(): HasMany
    {
        return $this->hasMany(Slot::class);
    }
}