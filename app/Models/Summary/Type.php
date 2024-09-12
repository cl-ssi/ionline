<?php

namespace App\Models\Summary;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sum_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'establishment_id',
    ];

    /**
     * Get the event types for the type.
     */
    public function eventTypes(): HasMany
    {
        return $this->hasMany(EventType::class, 'summary_type_id')
            ->where('establishment_id', auth()->user()->establishment_id)
            ->orderBy('summary_actor_id')
            ->orderBy('name');
    }
}
