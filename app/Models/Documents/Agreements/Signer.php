<?php

namespace App\Models\Documents\Agreements;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Signer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'agr_signers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'appellative',
        'decree',
        'user_id'
    ];

    /**
     * Get the user that owns the signer.
     */
    public function user(): BelongsTo|Builder
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
