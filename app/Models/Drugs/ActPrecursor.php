<?php

namespace App\Models\Drugs;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActPrecursor extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'drg_act_precursors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'full_name_receiving',
        'run_receiving',
        'note',
        'delivery_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * Get the delivery user that owns the act precursor.
     */
    public function delivery(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the precursors for the act precursor.
     */
    public function precursors(): HasMany
    {
        return $this->hasMany(ActPrecursorItem::class);
    }

    /**
     * Get the formatted date attribute.
     */
    public function getFormatDateAttribute(): string
    {
        return $this->date->day.' de '.$this->date->monthName.' del '.$this->date->year;
    }
}
