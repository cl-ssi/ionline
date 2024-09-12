<?php

namespace App\Models\Summary;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SummaryEventFile extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sum_summary_event_files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'file',
    ];

    /**
     * Get the summary that owns the summary event file.
     */
    public function summary(): BelongsTo
    {
        return $this->belongsTo(Summary::class, 'summary_id');
    }

    /**
     * Get the summary event that owns the summary event file.
     */
    public function summaryEvent(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'summary_event_id');
    }
}
