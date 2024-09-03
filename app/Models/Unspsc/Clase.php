<?php

namespace App\Models\Unspsc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clase extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'unspsc_classes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'experies_at',
        'family_id',
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
     * Get the products for the class.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'class_id')->select('id', 'name', 'code');
    }

    /**
     * Get the family that owns the class.
     */
    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
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
