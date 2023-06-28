<?php

namespace App\Models\Summary;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use App\Models\Establishment;
use App\Models\Summary\Event;


class Summary extends Model
{
    use SoftDeletes;

    protected $table = 'sum_summaries';

    protected $fillable = [
        'subject',
        'name',
        'status',
        'resolution_number',
        'resolution_date',
        'type',
        'start_at',
        'end_at',
        'start_date',
        'end_date',
        'observation',
        'investigator_id',
        'actuary_id',
        'creator_id',
        'establishment_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'resolution_date',
        'start_date',
        'start_at',
        'end_date',
        'end_at',
    ];

    public function investigator()
    {
        return $this->belongsTo(User::class, 'investigator_id')->withTrashed();
    }

    public function actuary()
    {
        return $this->belongsTo(User::class, 'actuary_id')->withTrashed();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id')->withTrashed();
    }

    public function establishment()
    {
        return $this->belongsTo(Establishment::class, 'establishment_id');
    }

    public function summaryEvents()
    {
        return $this->hasMany(Event::class, 'summary_id');
    }

    public function lastEvent()
    {
        return $this->hasOne(Event::class, 'summary_id')
            ->where(function ($query) {
                $query->whereHas('type', function ($query) {
                    $query->where('sub_event', 0)->orWhereNull('sub_event');
                });
            })
            ->latest();
    }
}
