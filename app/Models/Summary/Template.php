<?php

namespace App\Models\Summary;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Summary\EventType;

class Template extends Model
{
    use SoftDeletes;
    protected $table = 'sum_templates';

    protected $fillable = [
        'name',
        'description',
        'fields',
        'file',
        'event_type_id',
    ];

    protected $casts = [
        'fields' => 'array'
    ];

    public function eventType()
    {
        return $this->belongsTo(EventType::class, 'event_type_id');
    }
}
