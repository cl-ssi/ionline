<?php

namespace App\Models\Lobby;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Lobby\Meeting;

class Compromise extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */


    protected $fillable = [
        'id',
        'meeting_id',
        'name',
        'date',
        'status',
    ];

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'lobby_compromises';
    

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }
    
}
