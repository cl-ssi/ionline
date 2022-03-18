<?php

namespace App\Requirements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Event extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body', 'status','from_user_id','from_ou_id','to_user_id','to_ou_id','requirement_id','limit_at'
    ];

    public function getCreationDateAttribute()
    {
      return Carbon::parse($this->created_at)->format('d-m-Y');
    }

    public function from_user() {
        return $this->belongsTo('App\User', 'from_user_id')->withTrashed();
    }

    public function from_ou() {
        return $this->belongsTo('App\Rrhh\OrganizationalUnit', 'from_ou')->withTrashed();
    }

    public function to_user() {
        return $this->belongsTo('App\User', 'to_user_id')->withTrashed();
    }

    public function to_ou() {
        return $this->belongsTo('App\Rrhh\OrganizationalUnit', 'to_ou_id')->withTrashed();
    }

    public function requirement() {
        return $this->belongsTo('App\Requirements\Requirement');
    }

    public function files() {
        return $this->hasMany('App\Requirements\File');
    }

    public function eventStatus() {
        return $this->hasMany('App\Requirements\EventStatus');
    }

    // public function documents() {
    //     return $this->belongsToMany('App\Requirements\EventDocument');
    // }
    public function documents() {
        return $this->belongsToMany('App\Documents\Document','req_documents_events');
    }


    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at, limit_at'];

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'req_events';
}
