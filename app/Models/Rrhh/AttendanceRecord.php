<?php

namespace App\Models\Rrhh;

use App\Models\Establishment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'record_at',
        'type',
        'observation',
        'establishment_id',
        'rrhh_user_id',
        'sirh_at',
    ];

    protected $casts = [
        'record_at' => 'datetime',
        'type' => 'boolean',
        'sirh_at' => 'datetime',
    ];

    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function establishment(): BelongsTo 
    {
        return $this->belongsTo(Establishment::class);
    }

    public function rrhhUser(): BelongsTo 
    {
        return $this->belongsTo(User::class, 'rrhh_user_id')->withTrashed();
    }
}
