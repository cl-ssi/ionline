<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Family extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'wre_families';

    protected $fillable = [
        'name',
        'code',
        'experies_at',
        'segment_id',
    ];

    protected $dates = [
        'experies_at'
    ];

    public function classes()
    {
        return $this->hasMany(Clase::class, 'family_id')->select('id', 'name', 'code');
    }

    public function segment()
    {
        return $this->belongsTo(Segment::class);
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
