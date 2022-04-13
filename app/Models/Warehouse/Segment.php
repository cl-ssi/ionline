<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Segment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'wre_segments';

    protected $fillable = [
        'name',
        'code',
        'experies_at',
    ];

    protected $dates = [
        'experies_at'
    ];

    public function families()
    {
        return $this->hasMany(Family::class)->select('id', 'name', 'code');
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
