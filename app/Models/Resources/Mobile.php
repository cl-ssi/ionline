<?php

namespace App\Models\Resources;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mobile extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'res_mobiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand',
        'model',
        'number',
        'owner',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'owner' => 'boolean',
    ];

    /**
     * Get the user that owns the mobile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to search mobiles.
     */
    public function scopeSearch($query, $search)
    {
        if ($search != '') {
            return $query->where('number', 'LIKE', '%'.$search.'%')
                ->orWhere('brand', 'LIKE', '%'.$search.'%');
        }
    }
}
