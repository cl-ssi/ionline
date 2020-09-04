<?php

namespace App\Requirements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Rrhh\Authority;
use Carbon\Carbon;

class Requirement extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'subject', 'priority', 'status', //'archived',
        'limit_at', 'user_id','parte_id'
    ];

    public function events() {
        return $this->hasMany('App\Requirements\Event');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function parte() {
        return $this->belongsTo('App\Documents\Parte');
    }

    public function categories() {
        return $this->belongsToMany('App\Requirements\Category','req_requirements_categories');//->withPivot('requirement_id','category_id');;
    }

    public function requirementStatus() {
        return $this->hasMany('App\Requirements\RequirementStatus');
    }

    public function scopeSearch($query, $request) {

        if($request != "") {
            $query->where('id','LIKE','%'.$request.'%')
                  ->OrWhere('subject','LIKE','%'.$request.'%');
        }

        return $query;
    }

    public static function getPendingRequirements()
    {
      $users[0] = Auth::user()->id;
      $ous_secretary = Authority::getAmIAuthorityFromOu(date('Y-m-d'),'secretary', Auth::user()->id);
      foreach($ous_secretary as $secretary){
          $users[] = Authority::getAuthorityFromDate($secretary->OrganizationalUnit->id, date('Y-m-d'), 'manager')->user_id;
      }

      $archived_requirements = Requirement::with('events')
                                        ->whereHas('events', function ($query) use ($users) {
                                             $query->whereIn('from_user_id',$users)
                                                   ->orWhereIn('to_user_id',$users);
                                        })->whereHas('RequirementStatus', function ($query) use ($users) {
                                             $query->where('status','viewed')
                                                   ->whereIn('user_id',$users);
                                        })->get();

      //se obtienen los id de requerimientos archivados
      $archivados[] = null;
      foreach ($archived_requirements as $key => $req) {
        $archivados[$key] =$req->id;
      }

      //dd($archivados);

      $created_requirements = Requirement::whereHas('events', function ($query) use ($users) {
                                               $query->whereIn('from_user_id',$users)
                                                     ->orWhereIn('to_user_id',$users);
                                          })
                                          ->when($archivados, function ($query, $archivados) {
                                            return $query->WhereNotIn('id',$archivados); //<--- esta clausula permite traer todos los requerimientos que no esten archivados
                                          })
                                          ->count();

      if($created_requirements > 0)
      {
          return $created_requirements;
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
