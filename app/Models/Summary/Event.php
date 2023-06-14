<?php

namespace App\Models\Summary;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Summary\Link;

class Event extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'sum_events';

    protected $fillable = [
        'id',
        'name',
        'duration',
        'user',
        'file',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getUserTextAttribute()
    {
        return $this->user ? 'Sí' : 'No';
    }

    public function getFileTextAttribute()
    {
        return $this->file ? 'Sí' : 'No';
    }

    public function linksBefore()
    {
        return $this->hasMany(Link::class, 'after_event_id');
    }

    public function linksAfter()
    {
        return $this->hasMany(Link::class, 'before_event_id');
    }
}
