<?php

namespace App\Models\Programmings;

use App\Models\Indicators\Value;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;

class Task extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pro_tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'date',
        'activity_id',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the activity that owns the task.
     *
     * @return BelongsTo
     */
    public function activity(): BelongsTo
    {
        return $this->belongsTo(Value::class, 'activity_id');
    }

    /**
     * Get the reschedulings for the task.
     *
     * @return HasMany
     */
    public function reschedulings(): HasMany
    {
        return $this->hasMany(TaskRescheduling::class);
    }

    /**
     * Get the user who created the task.
     *
     * @return BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by')
                    ->select(['id', 'dv', 'name', 'fathers_family', 'mothers_family'])
                    ->withTrashed();
    }

    /**
     * Get the user who updated the task.
     *
     * @return BelongsTo
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by')
                    ->select(['id', 'dv', 'name', 'fathers_family', 'mothers_family'])
                    ->withTrashed();
    }

    /**
     * Get the rowspan count attribute.
     *
     * @return int
     */
    public function getRowspanCountAttribute(): int
    {
        return $this->reschedulings->count() > 0 ? $this->reschedulings->count() : 1;
    }

    /**
     * Boot the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::id();
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });

        static::deleting(function ($model) {
            $model->updated_by = Auth::id();
            $model->save();
        });
    }
}