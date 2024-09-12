<?php

namespace App\Models\Summary;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sum_summary_events';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_type_id',
        'body',
        'start_date',
        'end_date',
        'user_id',
        'summary_id',
        'creator_id',
        'father_event_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    /**
     * Get the event type that owns the event.
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(EventType::class, 'event_type_id');
    }

    /**
     * Get the user that owns the event.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the creator of the event.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id')->withTrashed();
    }

    /**
     * Get the summary that owns the event.
     */
    public function summary(): BelongsTo
    {
        return $this->belongsTo(Summary::class, 'summary_id');
    }

    /**
     * Get the files for the event.
     */
    public function files(): HasMany
    {
        return $this->hasMany(SummaryEventFile::class, 'summary_event_id');
    }

    /**
     * Get the father event.
     */
    public function father(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'father_event_id');
    }

    /**
     * Get the child events.
     */
    public function childs(): HasMany
    {
        return $this->hasMany(Event::class, 'father_event_id');
    }
}
