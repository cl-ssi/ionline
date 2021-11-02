<?php

namespace App\Programmings;

use Illuminate\Database\Eloquent\Model;

class ActivityProgram extends Model
{
    protected $table = 'pro_activity_programs';
    protected $fillable = [
        'id', 'year', 'description', 'user_id'
    ];

    public function items(){
        return $this->hasMany('App\Programmings\ActivityItem', 'activity_id');
    }
}
