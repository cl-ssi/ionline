<?php

namespace App\Models\Resources;

use App\Models\Parameters\Place;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Telephone extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'res_telephones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mac',
        'minsal',
        'number',
        'place_id',
        'visualization',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // Add any other attributes that need casting here
    ];

    /**
     * Get the users associated with the telephone.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'res_telephone_user')->withTimestamps();
    }

    /**
     * Get the place associated with the telephone.
     */
    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
    }

    /**
     * Scope a query to search telephones.
     */
    public function scopeSearch($query, $field, $value)
    {
        switch ($field) {
            case 'minsal':
                $query->where('number', 'LIKE', '%'.$value.'%')
                    ->orWhere('minsal', 'LIKE', '%'.$value.'%');
                break;
            case 'establishment_id':
                if ($value) {
                    $query->whereRelation('place', 'establishment_id', $value);
                } else {
                    $query->whereDoesntHave('place.establishment');
                }
                break;
        }

        return $query;
    }
}
