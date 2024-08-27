<?php

namespace App\Models\Unspsc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Family extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'unspsc_families';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'experies_at',
        'name',
        'segment_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'experies_at' => 'datetime',
    ];

    /**
     * Get the classes for the family.
     */
    public function classes(): HasMany
    {
        return $this->hasMany(Clase::class, 'family_id')->select('id', 'name', 'code');
    }

    /**
     * Get the segment that owns the family.
     */
    public function segment(): BelongsTo
    {
        return $this->belongsTo(Segment::class);
    }

    /**
     * Get the status attribute.
     */
    public function getStatusAttribute()
    {
        return ($this->experies_at == null) ? 'Activo' : 'Inactivo';
    }

    /**
     * Get the status color attribute.
     */
    public function getStatusColorAttribute()
    {
        return ($this->experies_at == null) ? 'success' : 'danger';
    }
}