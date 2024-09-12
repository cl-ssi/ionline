<?php

namespace App\Models\Summary;

use App\Helpers\DateHelper;
use App\Models\Establishment;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Summary extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sum_summaries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject',
        'name',
        'status',
        'resolution_number',
        'resolution_date',
        'type_id',
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'resolution_date' => 'date',
        'start_date'      => 'date',
        'start_at'        => 'datetime',
        'end_date'        => 'date',
        'end_at'          => 'datetime',
    ];

    /**
     * Get the type that owns the summary.
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * Get the investigator that owns the summary.
     */
    public function investigator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'investigator_id')->withTrashed();
    }

    /**
     * Get the actuary that owns the summary.
     */
    public function actuary(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actuary_id')->withTrashed();
    }

    /**
     * Get the creator that owns the summary.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id')->withTrashed();
    }

    /**
     * Get the establishment that owns the summary.
     */
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class, 'establishment_id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'summary_id')
            ->withTrashed()
            ->where(function ($query) {
                $query->whereHas('type', function ($query) {
                    $query->where('sub_event', false);
                });
            });
    }

    public function lastEvent(): HasOne
    {
        return $this->hasOne(Event::class, 'summary_id')
            ->withTrashed()
            ->where(function ($query) {
                $query->whereHas('type', function ($query) {
                    $query->where('sub_event', 0)->orWhereNull('sub_event');
                });
            })
            ->latest();
    }

    public function getBusinessDaysAttribute()
    {
        $businessDays = DateHelper::getBusinessDaysByDateRange($this->start_at, $this->end_at ?? now());

        return $businessDays;
    }

    public function getDaysPassedAttribute()
    {
        $businessDays = $this->businessDays;

        $endDate = now();

        $index = 0;

        $found = 0;

        while ($index < $businessDays->count()) {
            $date = Carbon::parse($businessDays[$index]);

            if ($endDate->gt($date)) {
                $found++;
            }
            $index++;
        }

        return $found;
    }

    public function getTotalDaysAttribute()
    {
        $businessDays = DateHelper::getBusinessDaysByDateRange($this->start_at, $this->end_at ?? now());

        return $businessDays->count();
    }
}
