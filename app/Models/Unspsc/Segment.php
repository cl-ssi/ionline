<?php

namespace App\Models\Unspsc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Segment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'unspsc_segments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'experies_at',
        'name',
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
     * Get the families for the segment.
     */
    public function families(): HasMany
    {
        return $this->hasMany(Family::class)->select('id', 'name', 'code');
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