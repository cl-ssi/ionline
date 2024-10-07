<?php

namespace App\Models\Documents\ActivityReports;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'date',
        'period_id'
    ];

    protected $table = 'act_activities';

    protected $casts = [
        'date' => 'date'
    ];

    public function binnacle(): BelongsTo
    {
        return $this->belongsTo(Binnacle::class);
    }
}
