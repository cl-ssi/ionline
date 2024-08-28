<?php

namespace App\Models\Pharmacies;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DispatchVerificationMailing extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'frm_dispatch_verification_mailings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'dispatch_id',
        'status',
        'sender_observation',
        'delivery_date',
        'receiver_observation',
        'confirmation_date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'delivery_date' => 'datetime',
        'confirmation_date' => 'datetime',
    ];

    /**
     * Get the dispatch that owns the verification mailing.
     *
     * @return BelongsTo
     */
    public function dispatch(): BelongsTo
    {
        return $this->belongsTo(Dispatch::class);
    }
}
