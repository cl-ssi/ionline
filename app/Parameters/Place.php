<?php

namespace App\Parameters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Place extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'location_id'];

    public function location() {
        return $this->belongsTo('App\Parameters\Location');
    }

    public function computers() {
        return $this->hasMany('App\Resources\Computer');
    }

    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = 'cfg_places';

}
