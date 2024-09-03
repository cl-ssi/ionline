<?php

namespace App\Models\His;

use App\Models\Documents\Approval;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ModificationRequest extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table = 'his_modification_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'type',
        'subject',
        'body',
        'status',
        'creator_id',
        'observation',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id')->withTrashed();
    }

    /**
     * Get all of the ModificationRequest's approvations.
     */
    public function approvals(): MorphMany
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

    public function files(): HasMany
    {
        return $this->hasMany(ModificationRequestFile::class, 'request_id');
    }

    /**
     * Get the color attribute based on the status.
     */
    protected function color(): Attribute
    {
        return Attribute::get(
            fn () => match ($this->status) {
                false => 'danger',
                true => 'success',
                default => '',
            }
        );
    }
}
