<?php

namespace App\Models\Unspsc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clase extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'unspsc_classes';

    protected $fillable = [
        'name',
        'code',
        'experies_at',
        'family_id',
    ];

    protected $dates = [
        'experies_at'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'class_id')->select('id', 'name', 'code');
    }

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function getStatusAttribute()
    {
        return ($this->experies_at == null) ? 'Activo' : 'Inactivo' ;
    }

    public function getStatusColorAttribute()
    {
        return ($this->experies_at == null) ? 'success' : 'danger' ;
    }
}
