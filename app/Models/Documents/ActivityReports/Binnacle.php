<?php

namespace App\Models\Documents\ActivityReports;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Binnacle extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'activity_id',
        'user_id',
        'description'
    ];

    protected $table = 'act_binnacles';

    protected $casts = [
        'date' => 'date'
    ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }
}
