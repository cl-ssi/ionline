<?php

namespace App\Models\Summary;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Summary\Event;

class Link extends Model
{
    use SoftDeletes;

    protected $table = 'sum_links';

    protected $fillable = [
        'before_event_id',
        'after_event_id'
    ];

    public function beforeEvent()
    {
        return $this->belongsTo(Event::class, 'before_event_id');
    }

    public function afterEvent()
    {
        return $this->belongsTo(Event::class, 'after_event_id');
    }
}
