<?php

namespace App\Models\Programmings;

use App\Models\Programmings\CommuneFile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class Review extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pro_programming_reviews';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'revisor',
        'general_features',
        'score',
        'answer',
        'observation',
        'active',
        'user_id',
        'updated_by',
        'programming_id'
    ];

    /**
     * Get the commune file that owns the review.
     *
     * @return BelongsTo
     */
    public function communeFile(): BelongsTo
    {
        return $this->belongsTo(CommuneFile::class);
    }

    /**
     * Get the user that owns the review.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the user who updated the review.
     *
     * @return BelongsTo
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by')->withTrashed();
    }
}