<?php

namespace App\Models\Drugs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RosterAnalisisToAdminItem extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'drg_roster_analisis_to_admin_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'roster_id',
        'reception_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // No attributes to cast
    ];

    /**
     * Get the roster that owns the RosterAnalisisToAdminItem.
     */
    public function roster(): BelongsTo
    {
        return $this->belongsTo(RosterAnalisisToAdmin::class, 'roster_id');
    }

    /**
     * Get the receptions for the RosterAnalisisToAdminItem.
     */
    public function receptions(): HasMany
    {
        return $this->hasMany(Reception::class, 'reception_id');
    }
}
