<?php

namespace App\Models\Unspsc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'unspsc_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'class_id',
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
     * The attributes that should be appended to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'short_name',
    ];

    /**
     * Get the class that owns the product.
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(Clase::class);
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

    /**
     * Get the short name attribute.
     */
    public function getShortNameAttribute()
    {
        return Str::limit($this->name, 80);
    }
}