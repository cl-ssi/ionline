<?php

namespace App\Models\Summary;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Summary\Event;
use App\Models\Summary\Summary;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\User;

class SummaryEvent extends Model
{
    use SoftDeletes;

    protected $table = 'sum_summaries_events';

    protected $fillable = [
        'event_id',
        'body',
        'start_date',
        'end_date',
        'summary_id',
        'creator_id',
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function summary()
    {
        return $this->belongsTo(Summary::class, 'summary_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(SummaryEventFile::class, 'summary_event_id');
    }

}
