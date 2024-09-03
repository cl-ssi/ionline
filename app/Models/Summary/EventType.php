<?php

namespace App\Models\Summary;

use App\Helpers\DateHelper;
use App\Models\Summary\Actor;
use App\Models\Summary\Link;
use App\Models\Summary\Template;
use App\Models\Summary\Type;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

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
        'establishment_id'
    ];

    /**
     * Get the summary type that owns the event type.
     *
     * @return BelongsTo
     */
    public function summaryType(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * Get the templates for the event type.
     *
     * @return HasMany
     */
    public function templates(): HasMany
    {
        return $this->hasMany(Template::class, 'event_type_id');
    }

    /**
     * Get the actor that owns the event type.
     *
     * @return BelongsTo
     */
    public function actor(): BelongsTo
    {
        return $this->belongsTo(Actor::class, 'summary_actor_id');
    }

    /**
     * Cuál es la utilidad del link before?
     * Get the links for the event type where it is the before event.
     *
     * @return HasMany
     */
    public function linksEvents(): HasMany
    {
        return $this->hasMany(Link::class, 'before_event_id')
            ->where('after_sub_event', false);
    }

    /**
     * Get the links for the event type where it is the before sub-event.
     *
     * @return HasMany
     */
    public function linksSubEvents(): HasMany
    {
        return $this->hasMany(Link::class, 'before_event_id')
            ->where('after_sub_event', true);
    }

    /**
     * Get the links for the event type where it is the after event.
     *
     * @return HasMany
     */
    public function linksBefore(): HasMany
    {
        return $this->hasMany(Link::class, 'after_event_id');
    }

    /**
     * Get the links for the event type where it is the before event.
     *
     * @return HasMany
     */
    public function linksAfter(): HasMany
    {
        return $this->hasMany(Link::class, 'before_event_id');
    }

    /**
     * Get the user text attribute.
     *
     * @return string
     */
    public function getUserTextAttribute(): string
    {
        return $this->require_user ? 'Sí' : 'No';
    }

    /**
     * Get the file text attribute.
     *
     * @return string
     */
    public function getFileTextAttribute(): string
    {
        return $this->require_file ? 'Sí' : 'No';
    }

    /**
     * Get the start text attribute.
     *
     * @return string
     */
    public function getStartTextAttribute(): string
    {
        return $this->start ? 'Sí' : 'No';
    }

    /**
     * Get the end text attribute.
     *
     * @return string
     */
    public function getEndTextAttribute(): string
    {
        return $this->end ? 'Sí' : 'No';
    }

    /**
     * Get the investigator text attribute.
     *
     * @return string
     */
    public function getInvestigatorTextAttribute(): string
    {
        return $this->investigator ? 'Sí' : 'No';
    }

    /**
     * Get the actuary text attribute.
     *
     * @return string
     */
    public function getActuaryTextAttribute(): string
    {
        return $this->actuary ? 'Sí' : 'No';
    }

    /**
     * Get the repeat text attribute.
     *
     * @return string
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
     *
     * @return int
     */
    public function getDaysPassedAttribute(): int
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

    /**
     * Get the left days attribute.
     *
     * @return int
     */
    public function getLeftDaysAttribute(): int
    {
        $leftDays = $this->totalDays - $this->daysPassed;
        return $leftDays;
    }

    /**
     * Get the total days attribute.
     *
     * @return int|null
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
     *
     * @return int
     */
    public function getProgressPercentageAttribute(): int
    {
        $total = $this->businessDays->count();
        $percentage = ($this->daysPassed * 100) / $total;
        return intval($percentage);
    }
}