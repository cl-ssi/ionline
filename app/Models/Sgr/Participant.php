<?php

namespace App\Models\Sgr;

use App\Models\Rrhh\OrganizationalUnit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Participant extends Model
{
    use HasFactory;

    protected $table = 'sgr_participants';

    protected $fillable = [
        'requirement_id',
        'user_id',
        'organizational_unit_id',
        'event_id',
        'in_copy',
        'following',
        'events_pending_view',
        'archived',
    ];

    protected $casts = [
        'in_copy'   => 'boolean',
        'following' => 'boolean',
        'archived'  => 'boolean',
    ];

    public function requirement(): BelongsTo
    {
        return $this->belongsTo(Requirement::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
