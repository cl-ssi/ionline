<?php

namespace App\Programmings;

use Illuminate\Database\Eloquent\Model;

class ActivityProgram extends Model
{
    protected $table = 'pro_activity_programs';
    protected $fillable = [
        'year', 'description'
    ];
}
