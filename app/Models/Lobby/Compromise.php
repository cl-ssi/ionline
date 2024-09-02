<?php

namespace App\Models\Lobby;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Compromise extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
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
     */
    protected $table = 'lobby_compromises';

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'date' => 'datetime',
    ];

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class);
    }

    public function getStatusIconAttribute()
    {
        switch ($this->status) {
            case 'pendiente': echo 'bi bi-hourglass';
                break;
            case 'en curso': echo 'bi bi-hourglass-bottom';
                break;
            case 'terminado': echo 'bi bi-check';
                break;
        }
    }
}
