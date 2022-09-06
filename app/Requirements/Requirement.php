<?php

namespace App\Requirements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Rrhh\Authority;
use Carbon\Carbon;
use OwenIt\Auditing\Contracts\Auditable;


class Requirement extends Model implements Auditable
{

    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'id', 'subject', 'priority', 'status', //'archived',
        'limit_at', 'user_id','parte_id', 'to_authority'
    ];

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

    public function getUnreadedEventsAttribute(){
        $ct = $this->eventsWithoutCC->count() - $this->eventsViewed->count();
        return ($ct > 0) ? $ct : null;
    }

    /** FIX viewed hace referencia a los archivados y no a los vistos
     */
    public function archived() {
        return $this->hasMany('App\Requirements\RequirementStatus')
            ->where('status','viewed');
    }

    public function scopeSearch($query, $request) {

        if($request != "") {
            $query->where('id','LIKE','%'.$request.'%')
                  ->OrWhere('subject','LIKE','%'.$request.'%');
        }

        return $query;
    }

    /** FIX no debería llamarse RequirementStatus, status directamente 
     * sin embargo esa popiedad ya existe
     */
    public function requirementStatus() {
        return $this->hasMany('App\Requirements\RequirementStatus');
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

    use SoftDeletes;

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
