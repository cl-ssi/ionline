<?php

namespace App\Models\IdentifyNeeds;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrategicAxis extends Model
{
    use HasFactory;

    protected $fillable = [
        'axis', 'topic', 'subject', 'objective', 'result'
    ];

    protected $table = 'dnc_strategic_axes';
}
