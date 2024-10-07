<?php

namespace App\Models\Documents\ActivityReports;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_at',
        'end_at',
        'description',
        'status',
    ];

    protected $table = 'act_activities';

    protected $casts = [
        'start_at' => 'datetime',
        'end_at'   => 'datetime',
        'status'   => 'boolean',
    ];

    public function binnacle(): BelongsTo
    {
        return $this->belongsTo(Binnacle::class);
    }
}
