<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Log extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'user_id',
        'message',
        'uri',
        'formatted',
        'context',
        'level',
        'level_name',
        'channel',
        'extra',
        'remote_addr',
        'user_agent',
        'record_datetime',
        'created_at',
    ];

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
