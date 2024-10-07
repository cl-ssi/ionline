<?php

namespace App\Models\Documents\ActivityReports;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
