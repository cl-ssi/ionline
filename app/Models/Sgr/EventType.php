<?php

namespace App\Models\Sgr;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    use HasFactory;
    protected $table = 'sgr_event_types';
    
    protected $fillable = [
        'name',
    ];

    // relaciones
}
