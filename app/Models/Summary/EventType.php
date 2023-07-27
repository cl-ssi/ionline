<?php

namespace App\Models\Summary;

use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Summary\Type;
use App\Models\Summary\Template;
use App\Models\Summary\Link;
use Illuminate\Support\Carbon;

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
        'summary_type_id',
        'num_repeat',
        'summary_actor_id',
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

    public function getBusinessDaysAttribute()
    {
        if(isset($this->duration))
        {
            $businessDays = DateHelper::getBusinessDaysByDuration($this->created_at, $this->duration);
        }
        else
        {
            $businessDays = DateHelper::getBusinessDaysByDateRange($this->created_at, now());
        }

        return $businessDays;
    }

    public function getDaysPassedAttribute()
    {
        $businessDays = $this->businessDays;

        $endDate = now();

        $index = 0;

        $found = 0;

        while($index < $businessDays->count())
        {
            $date = Carbon::parse($businessDays[$index]);

            if($endDate->gt($date))
            {
                $found++;
            }
            $index++;
        }

        return $found;
    }

    public function getLeftDaysAttribute()
    {
        $leftDays = $this->totalDays - $this->daysPassed;

        return $leftDays;
    }

    public function getTotalDaysAttribute()
    {
        if(isset($this->duration))
        {
            return $this->businessDays->count();
        }
        return null;
    }

    public function getProgressPercentageAttribute()
    {
        $total = $this->businessDays->count();

        $percentage = ($this->daysPassed * 100) / $total;

        return intval($percentage);
    }

    /** Cuál es la utilidad del link before? */
    public function linksEvents()
    {
        return $this->hasMany(Link::class, 'before_event_id')
            ->where('after_sub_event',false);
    }

    public function linksSubEvents()
    {
        return $this->hasMany(Link::class, 'before_event_id')
            ->where('after_sub_event',true);
    }

    public function linksBefore()
    {
        return $this->hasMany(Link::class, 'after_event_id');
    }

    public function linksAfter()
    {
        return $this->hasMany(Link::class, 'before_event_id');
    }

    public function summaryType()
    {
        return $this->belongsTo(Type::class);
    }

    public function templates()
    {
        return $this->hasMany(Template::class, 'event_type_id');
    }

    public function actor()
    {
        return $this->belongsTo(Actor::class, 'summary_actor_id');
    }
}
