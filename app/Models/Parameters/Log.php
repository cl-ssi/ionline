<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Log extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getColorAttribute()
    {
        switch($this->level_name)
        {
            case 'INFO':
            case 'NOTICE':
            case 'DEBUG':
                $color='info'; break;
            case 'WARNING':
                $color='warning'; break;
            case 'ERROR': 
                $color='danger'; break;
            default: 
                $color='danger'; break;
        }
        return $color;
    }
    
}
