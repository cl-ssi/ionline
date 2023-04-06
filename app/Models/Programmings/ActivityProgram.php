<?php

namespace App\Models\Programmings;

use Illuminate\Database\Eloquent\Model;

class ActivityProgram extends Model
{
    protected $table = 'pro_activity_programs';
    protected $fillable = [
        'id', 'year', 'description', 'user_id'
    ];

    public function items(){
        return $this->hasMany('App\Models\Programmings\ActivityItem', 'activity_id');
    }
}
