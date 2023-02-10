<?php

namespace App\Models\Lobby;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Lobby\Meeting;

class Compromise extends Model
{
    use HasFactory;

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
