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
        'event_type_id',
        'name',
        'file'
    ];

    public function type()
    {
        return $this->belongsTo(EventType::class, 'event_type_id');
    }
}
