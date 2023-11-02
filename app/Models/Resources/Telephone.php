<?php

namespace App\Models\Resources;

use App\Models\Parameters\Place;
use Illuminate\Database\Eloquent\Model;
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
     * The attributes that should be mutated to dates.
     *
     * @var array
     */

    protected $casts = [
        'deleted_at' => 'datetime'
    ];
     

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number', 'minsal', 'mac', 'place_id'
    ];

    public function users()
    {
        return $this->belongsToMany('\App\User', 'res_telephone_user')->withTimestamps();
    }

    public function scopeSearch($query, $field, $value)
    {
        switch($field) {
            case 'minsal':
                $query->where('number', 'LIKE', '%' . $value . '%')
                    ->orWhere('minsal', 'LIKE', '%' . $value . '%');
                break;
            case 'establishment_id':
                if($value) {
                    $query->whereRelation('place','establishment_id', $value);
                }
                else {
                    $query->whereDoesntHave('place.establishment');
                }
                break;
        }
        return $query;
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
