<?php

namespace App\Models\Summary;

use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class EventType extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'sum_event_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
        'establishment_id',
    ];

    /**
     * Get the summary type that owns the event type.
     */
    public function summaryType(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * Get the templates for the event type.
     */
    public function templates(): HasMany
    {
        return $this->hasMany(Template::class, 'event_type_id');
    }

    /**
     * Get the actor that owns the event type.
     */
    public function actor(): BelongsTo
    {
        return $this->belongsTo(Actor::class, 'summary_actor_id');
    }

    /**
     * Cuál es la utilidad del link before?
     * Get the links for the event type where it is the before event.
     */
    public function linksEvents(): HasMany
    {
        return $this->hasMany(Link::class, 'before_event_id')
            ->where('after_sub_event', false);
    }

    /**
     * Get the links for the event type where it is the before sub-event.
     */
    public function linksSubEvents(): HasMany
    {
        return $this->hasMany(Link::class, 'before_event_id')
            ->where('after_sub_event', true);
    }

    /**
     * Get the links for the event type where it is the after event.
     */
    public function linksBefore(): HasMany
    {
        return $this->hasMany(Link::class, 'after_event_id');
    }

    /**
     * Get the links for the event type where it is the before event.
     */
    public function linksAfter(): HasMany
    {
        return $this->hasMany(Link::class, 'before_event_id');
    }

    /**
     * Get the user text attribute.
     */
    public function getUserTextAttribute(): string
    {
        return $this->require_user ? 'Sí' : 'No';
    }

    /**
     * Get the file text attribute.
     */
    public function getFileTextAttribute(): string
    {
        return $this->require_file ? 'Sí' : 'No';
    }

    /**
     * Get the start text attribute.
     */
    public function getStartTextAttribute(): string
    {
        return $this->start ? 'Sí' : 'No';
    }

    /**
     * Get the end text attribute.
     */
    public function getEndTextAttribute(): string
    {
        return $this->end ? 'Sí' : 'No';
    }

    /**
     * Get the investigator text attribute.
     */
    public function getInvestigatorTextAttribute(): string
    {
        return $this->investigator ? 'Sí' : 'No';
    }

    /**
     * Get the actuary text attribute.
     */
    public function getActuaryTextAttribute(): string
    {
        return $this->actuary ? 'Sí' : 'No';
    }

    /**
     * Get the repeat text attribute.
     */
    public function getRepeatTextAttribute(): string
    {
        return $this->repeat ? 'Sí' : 'No';
    }

    /**
     * Get the business days attribute.
     */
    public function getBusinessDaysAttribute(): Collection
    {
        if (isset($this->duration)) {
            $businessDays = DateHelper::getBusinessDaysByDuration($this->created_at, $this->duration);
        } else {
            $businessDays = DateHelper::getBusinessDaysByDateRange($this->created_at, now());
        }

        return $businessDays;
    }

    /**
     * Get the days passed attribute.
     */
    public function getDaysPassedAttribute(): int
    {
        $businessDays = $this->businessDays;
        $endDate      = now();
        $index        = 0;
        $found        = 0;
        while ($index < $businessDays->count()) {
            $date = Carbon::parse($businessDays[$index]);
            if ($endDate->gt($date)) {
                $found++;
            }
            $index++;
        }

        return $found;
    }

    /**
     * Get the left days attribute.
     */
    public function getLeftDaysAttribute(): int
    {
        $leftDays = $this->totalDays - $this->daysPassed;

        return $leftDays;
    }

    /**
     * Get the total days attribute.
     */
    public function getTotalDaysAttribute(): ?int
    {
        if (isset($this->duration)) {
            return $this->businessDays->count();
        }

        return null;
    }

    /**
     * Get the progress percentage attribute.
     */
    public function getProgressPercentageAttribute(): int
    {
        $total      = $this->businessDays->count();
        $percentage = ($this->daysPassed * 100) / $total;

        return intval($percentage);
    }
}
