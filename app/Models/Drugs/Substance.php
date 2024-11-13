<?php

namespace App\Models\Drugs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'presumed',
        'name',
        'rama',
        'unit',
        'laboratory',
        'isp',
        'result_id'
    ];

    //cast
    protected $casts = [
        'isp' => 'boolean',
        'presumed' => 'boolean',
    ];

    /**
     * Get the items for the substance.
     */
    public function items(): HasMany
    {
        return $this->hasMany(ReceptionItem::class);
    }

    /* TODO: asociar result_substance en ReceptionItem a otro item. */
    public function result(): BelongsTo
    {
        return $this->belongsTo(Substance::class);
    }

}
