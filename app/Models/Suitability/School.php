<?php

namespace App\Models\Suitability;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;


    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    protected $fillable = [
        'name',
        'address',
        'rbd',
        'municipality',
        'free',
        'legal',
        'holder',
        'commune_id',
    ];

    public function commune()
    {
        return $this->belongsTo('App\Models\Commune', 'commune_id');
    }


}
