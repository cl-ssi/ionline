<?php

namespace App\Models\Drugs;

use App\Models\User;
use App\Observers\Drugs\CountersampleDestructionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

#[ObservedBy([CountersampleDestructionObserver::class])]
class CountersampleDestruction extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = 'drg_countersample_destructions';

    protected $fillable = [
        'number',
        'destructed_at',
        'court_id',
        'police',
        'user_id',
        'manager_id',
        'lawyer_id',
        'observer_id',
        'lawyer_observer_id',
    ];

    protected $dates = [
        'destructed_at',
    ];

    public function court(): BelongsTo
    {
        return $this->belongsTo(Court::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lawyer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function observer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lawyerObserver(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function receptionItems(): HasMany
    {
        return $this->hasMany(ReceptionItem::class);
    }
}
