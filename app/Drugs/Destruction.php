<?php

namespace App\Drugs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Destruction extends Model
{

    public function reception() {
        return $this->belongsTo('App\Drugs\Reception');
    }

    public function user() {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function manager() {
        return $this->belongsTo('App\User', 'manager_id')->withTrashed();
    }

    public function lawyer() {
        return $this->belongsTo('App\User', 'lawyer_id')->withTrashed();
    }

    public function observer() {
        return $this->belongsTo('App\User', 'observer_id')->withTrashed();
    }

    public function lawyer_observer() {
        return $this->belongsTo('App\User', 'lawyer_observer_id')->withTrashed();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reception_id', 'police', 'destructed_at', 'user_id',
    ];

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['destructed_at', 'deleted_at'];

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'drg_destructions';
}
