<?php

namespace App\Models\Drugs;

use App\Models\Documents\Approval;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Protocol extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'drg_protocols';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sample',
        'result',
        'user_id',
        'reception_item_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // No attributes to cast
    ];

    /**
     * Get the reception item that owns the protocol.
     */
    public function receptionItem(): BelongsTo
    {
        return $this->belongsTo(ReceptionItem::class);
    }

    /**
     * Get the user that owns the protocol.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the approval model.
     */
    public function approval(): MorphOne
    {
        return $this->morphOne(Approval::class, 'approvable');
    }
}
