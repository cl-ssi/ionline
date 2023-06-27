<?php

namespace App\Models\Summary;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Summary\Summary;
use App\Models\Summary\Event;

class SummaryEventFile extends Model
{
    use SoftDeletes;
    protected $table = 'sum_summaries_events_files';

    protected $fillable = [
        'name',
        'file'
    ];


    public function summary()
    {
        return $this->belongsTo(Summary::class, 'summary_id');
    }

    public function summaryEvent()
    {
        return $this->belongsTo(Event::class, 'summary_event_id');
    }
}
