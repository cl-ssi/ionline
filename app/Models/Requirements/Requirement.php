<?php

namespace App\Models\Requirements;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Rrhh\Authority;
use App\Models\Requirements\LabelRequirement;
use App\Models\Requirements\EventStatus;
use App\Models\Requirements\Event;
use App\Models\Requirements\Category;


class Requirement extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'id',
        'subject',
        'priority',
        'status',
        'limit_at',
        'user_id',
        'parte_id',
        'to_authority',
        'category_id'
    ];

    public function events() {
        return $this->hasMany('App\Models\Requirements\Event');
    }

    public function eventsWithoutCC() {
        return $this->hasMany('App\Models\Requirements\Event')->where('status','<>','en copia');
    }

    public function ccEvents() {
        return $this->hasMany('App\Models\Requirements\Event')->where('status','en copia');
    }

    public function user() {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function parte() {
        return $this->belongsTo('App\Models\Documents\Parte');
    }

    public function labels() {
        return $this->belongsToMany('App\Models\Requirements\Label','req_labels_requirements');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function firstEvent()
    {
        return $this->hasOne(Event::class)->where('status','creado');
    }

    public function eventsViewed() {
        return $this->hasMany('App\Models\Requirements\EventStatus')->where('user_id',auth()->id());
    }

    /** Setea las labels de un requerimiento en base a un array de ids de labels */
    public function setLabels($labels) {
        if(is_array($labels)){
            foreach($labels as $label) {
                LabelRequirement::create([
                    'user_id' => auth()->id(),
                    'requirement_id' => $this->id,
                    'label_id' => $label,
                ]);
            }
        }
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

    public function getUnreadedEventsAttribute(){
        $ct = $this->eventsWithoutCC->count() - $this->eventsViewed->count();
        return ($ct > 0) ? $ct : null;
    }

    /* FIXME: viewed hace referencia a los archivados y no a los vistos
     */
    public function archived() {
        return $this->hasMany('App\Models\Requirements\RequirementStatus')
            ->where('status','viewed');
    }

    public function scopeSearch($query, $request) {

        if($request != "") {
            $query->where('id','LIKE','%'.$request.'%')
                  ->OrWhere('subject','LIKE','%'.$request.'%');
        }

        return $query;
    }

    /* FIXME: no debería llamarse RequirementStatus, status directamente 
     * sin embargo esa popiedad ya existe
     */
    public function requirementStatus() {
        return $this->hasMany('App\Models\Requirements\RequirementStatus');
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
    protected $table = 'req_requirements';
}
