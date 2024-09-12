<?php

namespace App\Models\Summary;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Link extends Model
{
    use SoftDeletes;

    protected $table = 'sum_event_links';

    protected $fillable = [
        'before_event_id',
        'before_sub_event',
        'after_event_id',
        'after_sub_event',
    ];

    public function beforeEvent()
    {
        return $this->belongsTo(EventType::class, 'before_event_id');
    }

    public function afterEvent()
    {
        return $this->belongsTo(EventType::class, 'after_event_id');
    }
}
