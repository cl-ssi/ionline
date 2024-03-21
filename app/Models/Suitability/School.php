<?php

namespace App\Models\Suitability;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
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

    public function psirequests()
    {
        return $this->hasMany('App\Models\Suitability\PsiRequest');
    }


}
