<?php

namespace App\Models\Sgr;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Requirement extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject',
        'priority',
        'limit_at',
        'event_type_id',
        'user_id',
        'parte_id',
        'category_id',
        'group_number',
        'establishment_id',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sgr_requirements';

    // relaciones

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function eventType(): BelongsTo
    {
        return $this->belongsTo(EventType::class);
    }

    public function labels(): HasMany
    {
        return $this->hasMany(Label::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function firstEvent(): HasOne
    {
        return $this->hasOne(Event::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    // funciones

    // public function firstEvent(): HasOne
    // {
    //     return $this->hasOne(Event::class)->where('status','creado');
    // }

    // public function lastEvent(): HasOne
    // {
    //     return $this->hasOne(Event::class)->latest();
    // }
}
