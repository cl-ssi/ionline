<?php

namespace App\Requirements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;
use App\Requirements\EventStatus;
use App\User;

class Requirement extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'req_requirements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'subject', 'priority', 'status', //'archived',
        'limit_at', 'user_id','parte_id', 'to_authority', 'label_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'limit_at'];

    public function events() {
        return $this->hasMany('App\Requirements\Event');
    }

    public function eventsWithoutCC() {
        return $this->hasMany('App\Requirements\Event')->where('status','<>','en copia');
    }

    public function ccEvents() {
        return $this->hasMany('App\Requirements\Event')->where('status','en copia');
    }

    public function user() {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function parte() {
        return $this->belongsTo('App\Documents\Parte');
    }

    public function categories() {
        return $this->belongsToMany('App\Requirements\Category','req_requirements_categories');//->withPivot('requirement_id','category_id');;
    }

    public function eventsViewed() {
        return $this->hasMany('App\Requirements\EventStatus')->where('user_id',auth()->id());
    }

    /** FIX no debería llamarse RequirementStatus, status directamente
     * sin embargo esa popiedad ya existe
     */
    public function requirementStatus() {
        return $this->hasMany('App\Requirements\RequirementStatus');
    }

    /** FIX viewed hace referencia a los archivados y no a los vistos
     */
    public function archived() {
        return $this->hasMany('App\Requirements\RequirementStatus')
            ->where('status','viewed');
    }

    public function getSetEventsAsViewedAttribute() {
        $eventsWithoutCC = $this->eventsWithoutCC->pluck('id')->toArray();
        $eventsViewed = $this->eventsViewed->pluck('id')->toArray();

        foreach($eventsWithoutCC as $event)
        {
            if(!in_array($event,$eventsViewed))
            {
                $eventStatus = EventStatus::create([
                    'event_id' => $event,
                    'user_id' => auth()->id(),
                    'requirement_id' => $this->id,
                    'status' => 'viewed'
                ]);
            }
        }
    }

    public function getUnreadedEventsAttribute() {
        $ct = $this->eventsWithoutCC->count() - $this->eventsViewed->count();
        return ($ct > 0) ? $ct : null;
    }

    public function scopeSearch($query, $request) {

        if($request != "") {
            $query->where('id','LIKE','%'.$request.'%')
                  ->OrWhere('subject','LIKE','%'.$request.'%');
        }

        return $query;
    }

    public function isCopy($user)
    {
        return $this->user_id != $user->id && $this->events->where('to_user_id', $user->id)->count() == $this->ccEvents->where('to_user_id', $user->id)->count();
    }

    public static function eventsCopy(User $user)
    {
        $reqs = Requirement::with('archived','categories','events','ccEvents','parte','events.from_user','events.to_user','events.from_ou', 'events.to_ou')
        ->whereHas('events', function ($query) use($user) {
            $query->where('from_user_id', $user->id)->orWhere('to_user_id', $user->id);
        });

        $reqs = $reqs->get();

        $idEventsCopy = collect([]);
        foreach($reqs as $req)
        {
            $totalEvents = $req->events->where('to_user_id', $user->id)->count();
            $totalCcEvents = $req->ccEvents->where('to_user_id', $user->id)->count();

            if($totalEvents == $totalCcEvents && $req->user_id != $user->id)
                $idEventsCopy->push($req->id);
        }

        return $idEventsCopy;
    }

    /**
     * Obtiene los requirements marcados "como enviados al manager (to_authority)" de sus UO
     * @param $query
     * @param $secretaryOuIds
     * @param $users
     * @param $getArchived
     * @return mixed
     */
    public function scopeGetSentToAuthority($query, $secretaryOuIds, $users, $getArchived)
    {
        $query->orWhere('to_authority', true)
            ->where(function ($query) use ($secretaryOuIds) {
                $query->whereHas('events', function ($query) use ($secretaryOuIds) {
                    $query->where('to_authority', true)
                        ->whereIn('to_ou_id', $secretaryOuIds);
                });
            })->when($getArchived, function ($query) use ($users) {
                $query->whereHas('RequirementStatus', function ($query) use ($users) {
                    $query->where('status', 'viewed')
                        ->whereIn('user_id', $users);
                });
            });

        return $query;
    }

    public static function getPendingRequirements()
    {
        $users[0] = Auth::user()->id;
        $ous_secretary = [];
        //   14/06/2022: Esteban Rojas - Quitar requerimientos como secretaria (Se creó una nueva bandeja para ello)
        //   $ous_secretary = Authority::getAmIAuthorityFromOu(date('Y-m-d'),'secretary', Auth::user()->id);
        //   foreach($ous_secretary as $secretary){
        //     if (Authority::getAuthorityFromDate($secretary->OrganizationalUnit->id, date('Y-m-d'), 'manager')) {
        //       $users[] = Authority::getAuthorityFromDate($secretary->OrganizationalUnit->id, date('Y-m-d'), 'manager')->user_id;
        //     }
        //   }

        $archived_requirements = Requirement::with('events')
                                ->whereHas('events', function ($query) use ($users) {
                                        $query->whereIn('from_user_id',$users)
                                            ->orWhereIn('to_user_id',$users);
                                })->whereHas('RequirementStatus', function ($query) use ($users) {
                                        $query->where('status','viewed')
                                            ->whereIn('user_id',$users);
                                })->count();

        $created_requirements = Requirement::whereHas('events', function ($query) use ($users) {
                                    $query->whereIn('from_user_id',$users)
                                            ->orWhereIn('to_user_id',$users);
                                })
                                ->count();

        $total = $created_requirements - $archived_requirements;

        if($total > 0)
        {
            return $total;
        }
    }
}
