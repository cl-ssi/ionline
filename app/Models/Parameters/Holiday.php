<?php

namespace App\Models\Parameters;

use App\Models\ClRegion;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Holiday extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cfg_holidays';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'name',
        'region_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date:Y-m-d',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the region that owns the holiday.
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(ClRegion::class, 'region_id');
    }

    /**
     * Check if the given date is a holiday or a Sunday.
     */
    public static function checkDate(string $date): bool
    {
        return (date('N', strtotime($date)) > 6) ||
            Holiday::whereDate('date', $date)->get()->isNotEmpty();
    }

    /**
     * // FIXME: ver si se utiliza y porqué, basta que esté en la variable $dates
     *
     * Get the formatted date attribute.
     */
    public function getFormattedDateAttribute(): Carbon
    {
        return Carbon::parse($this->date);
    }
}
