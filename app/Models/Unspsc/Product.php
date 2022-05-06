<?php

namespace App\Models\Unspsc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'unspsc_products';

    protected $fillable = [
        'name',
        'code',
        'experies_at',
        'class_id',
    ];

    protected $dates = [
        'experies_at'
    ];

    protected $appends = [
        'short_name'
    ];


    public function class()
    {
        return $this->belongsTo(Clase::class);
    }

    public function getStatusAttribute()
    {
        return ($this->experies_at == null) ? 'Activo' : 'Inactivo' ;
    }

    public function getStatusColorAttribute()
    {
        return ($this->experies_at == null) ? 'success' : 'danger' ;
    }

    public function getShortNameAttribute()
    {
        return Str::limit($this->name, 80);
    }
}
