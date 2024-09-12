<?php

namespace App\Models\Drugs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Substance extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'drg_substances';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'rama',
        'unit',
        'laboratory',
        'isp',
        'presumed',
    ];

    /**
     * Get the items for the substance.
     */
    public function items(): HasMany
    {
        return $this->hasMany(ReceptionItem::class);
    }

    /* TODO: asociar result_substance en ReceptionItem a otro item. */
}
