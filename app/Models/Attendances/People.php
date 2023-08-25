<?php

namespace App\Models\Attendances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;
    
    protected $table = 'att_people';
}
