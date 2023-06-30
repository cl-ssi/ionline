<?php

namespace App\Models\Summary;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Summary\Link;
use App\Models\Summary\Template;

class EventType extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'sum_event_types';

    protected $fillable = [
        'id',
        'name',
        'description',
        'duration',
        'user',
        'require_user',
        'file',
        'require_file',
        'start',
        'end',
        'investigator',
        'actuary',
        'sub_event',
        'repeat',
        'num_repeat',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getUserTextAttribute()
    {
        return $this->require_user ? 'Sí' : 'No';
    }

    public function getFileTextAttribute()
    {
        return $this->require_file ? 'Sí' : 'No';
    }

    public function getStartTextAttribute()
    {
        return $this->start ? 'Sí' : 'No';
    }

    public function getEndTextAttribute()
    {
        return $this->end ? 'Sí' : 'No';
    }

    public function getInvestigatorTextAttribute()
    {
        return $this->investigator ? 'Sí' : 'No';
    }

    public function getActuaryTextAttribute()
    {
        return $this->actuary ? 'Sí' : 'No';
    }

    public function getRepeatTextAttribute()
    {
        return $this->repeat ? 'Sí' : 'No';
    }


    

    /** Cuál es la utilidad del link before? */
    public function linksEvents()
    {
        return $this->hasMany(Link::class, 'before_event_id')->where('after_sub_event',false);
    }

    public function linksSubEvents()
    {
        return $this->hasMany(Link::class, 'before_event_id')->where('after_sub_event',true);
    }



    public function linksBefore()
    {
        return $this->hasMany(Link::class, 'after_event_id');
    }

    public function linksAfter()
    {
        return $this->hasMany(Link::class, 'before_event_id');
    }



    public function templates()
    {
        return $this->hasMany(Template::class, 'event_type_id');
    }
}
