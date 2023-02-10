<?php

namespace App\Models\Lobby;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\User;
use App\Models\Lobby\MeetingUser;
use App\Models\Lobby\Compromise;

class Meeting extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'responsible_id',
        'petitioner',
        'date',
        'start_at',
        'end_at',
        'mecanism',
        'subject',
        'exponents',
        'details',
        'status',
        'request_file',
        'acta_file',
        'signature_id',
    ];

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'lobby_meetings';
    
    public function responsible()
    {
        return $this->belongsTo(User::class,'responsible_id');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'lobby_meeting_user');
    }

    public function compromises()
    {
        return $this->hasMany(Compromise::class);
    }
    
}
