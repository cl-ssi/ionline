<?php

namespace App\Models\Summary;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Summary\EventType;
use App\Models\Summary\Summary;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\User;

class Event extends Model
{
    use SoftDeletes;

    protected $table = 'sum_summary_events';

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

    protected $dates = [
        'start_date',
        'end_date',
    ];

    public function subEvents()
    {
        /** TODO: */
    }

    public function type()
    {
        return $this->belongsTo(EventType::class, 'event_type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id')->withTrashed();
    }

    public function summary()
    {
        return $this->belongsTo(Summary::class, 'summary_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(SummaryEventFile::class, 'summary_event_id');
    }

    public function father()
    {
        return $this->belongsTo(Event::class, 'father_event_id');
    }

}
