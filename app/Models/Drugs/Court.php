<?php

namespace App\Models\Drugs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Court extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'drg_courts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'emails',
        'address',
        'commune',
        'status',
    ];

    /**
     * Get the receptions for the court.
     */
    public function receptions(): HasMany
    {
        return $this->hasMany(Reception::class);
    }
}
