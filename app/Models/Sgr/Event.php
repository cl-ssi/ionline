<?php

namespace App\Models\Sgr;

use App\Models\Establishment;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\User;
use App\Observers\Sgr\EventObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([EventObserver::class])]
class Event extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'requirement_id',
        'body',
        'event_type_id',
        'limit_at',
        'creator_id',
        'creator_ou_id',
        'sent_to_establishment_id',
        'sent_to_ou_id',
        'sent_to_user_id',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sgr_events';

    // relaciones

    public function requirement(): BelongsTo
    {
        return $this->belongsTo(Requirement::class);
    }

    public function eventType(): BelongsTo
    {
        return $this->belongsTo(EventType::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function creatorOu(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'creator_ou_id');
    }

    public function sentToEstablishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class, 'sent_to_establishment_id');
    }

    public function sentToOu(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'sent_to_ou_id');
    }

    public function sentToUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sent_to_user_id')->withTrashed();
    }
}
