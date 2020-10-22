<?php

namespace App\Programmings;

use Illuminate\Database\Eloquent\Model;

class Programming extends Model
{
    protected $table = 'pro_programmings';
    protected $fillable = [
        'year', 'description'
    ];

    public function establishment() {
        return $this->belongsTo('App\Establishment');
    }

    protected $casts = [
        'access' => 'array'
    ];
}
