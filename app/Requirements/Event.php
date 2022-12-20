<?php

namespace App\Requirements;

use App\Rrhh\Authority;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Event extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body', 'status','from_user_id','from_ou_id','to_user_id','to_ou_id','requirement_id','limit_at', 'to_authority'
    ];

    public function getCreationDateAttribute()
    {
      return Carbon::parse($this->created_at)->format('d-m-Y');
    }

    public function from_user() {
        return $this->belongsTo('App\User', 'from_user_id')->withTrashed();
    }

    public function from_ou() {
        return $this->belongsTo('App\Rrhh\OrganizationalUnit', 'from_ou_id')->withTrashed();
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

    public function viewed() {
        return $this->hasOne('App\Requirements\EventStatus')->where('user_id',auth()->id());
    }
    // public function documents() {
    //     return $this->belongsToMany('App\Requirements\EventDocument');
    // }
    public function documents() {
        return $this->belongsToMany('App\Models\Documents\Document','req_documents_events');
    }

    /**
     * Revisa si el evento fue enviado a una autoridad tipo manager de la ou de destino
     * @return bool
     */
    public function isSentToAuthority() :bool
    {
        $authorities = Authority::getAmIAuthorityFromOu($this->created_at, 'manager', $this->to_user_id);

        foreach ($authorities as $authority) {
            if ($authority->organizational_unit_id == $this->to_ou_id) {
                return true;
            }
        }

        return false;
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'limit_at'];

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'req_events';
}
