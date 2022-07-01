<?php

namespace App\Resources;

use App\Models\Parameters\Place;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Telephone extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number', 'minsal', 'mac', 'place_id'
    ];

    public function users() {
        return $this->belongsToMany('\App\User','res_telephone_user')->withTimestamps();
    }

    public function scopeSearch($query, $search) {
        if($search != "") {
            return $query->where('number', 'LIKE', '%'.$search.'%')
                         ->orWhere('minsal', 'LIKE', '%'.$search.'%');
        }
    }

    public function place() {
        return $this->belongsTo(Place::class);
    }


    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'res_telephones';
}
