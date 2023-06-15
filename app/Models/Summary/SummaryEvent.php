<?php

namespace App\Models\Summary;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Summary\Event;
use App\Models\Summary\Summary;

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
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function summary()
    {
        return $this->belongsTo(Summary::class, 'summary_id');
    }

}
