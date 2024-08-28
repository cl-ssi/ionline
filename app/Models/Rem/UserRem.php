<?php

namespace App\Models\Rem;

use App\Models\Establishment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRem extends Model
{
    use HasFactory;    
    use SoftDeletes;

    public $table = 'rem_users';
    protected $fillable = [
        'id',
        'establishment_id',
        'user_id',
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the establishment that owns the place.
     *
     * @return BelongsTo
     */
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }
}
