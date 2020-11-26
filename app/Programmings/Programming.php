<?php

namespace App\Programmings;

use Illuminate\Database\Eloquent\Model;

class Programming extends Model
{
    protected $table = 'pro_programmings';
    protected $fillable = [
        'id','year', 'description'
    ];

    public function establishment() {
        return $this->belongsTo('App\Establishment');
    }

    protected $casts = [
        'access' => 'array'
    ];

    // public function programming_reviews() {
    //     return $this->hasMany('App\Models\Programmings\Review');
    // }
}
