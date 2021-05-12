<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Suitability\Result;
use App\Models\RequestForms\RequestForm;
use App\Models\ServiceRequests\ServiceRequest;
use App\Models\RequestForms\EventRequestForm;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    /**
    * El id no es incremental ya que es el run sin digito verificador
    */
    protected $primaryKey = 'id';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'dv', 'name', 'fathers_family','mothers_family','gender','address','phone_number','email',
        'password','birthday','position','active','external','country_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function organizationalUnit() {
        return $this->belongsTo('\App\Rrhh\OrganizationalUnit');
    }

    public function telephones() {
        return $this->belongsToMany('\App\Resources\Telephone', 'res_telephone_user')->withTimestamps();
    }

    public function computers() {
        return $this->belongsToMany('\App\Resources\Computer', 'res_computer_user')->withTimestamps();
    }

    public function printers() {
        return $this->belongsToMany('\App\Resources\Printer', 'res_printer_user')->withTimestamps();
    }

    public function mobile() {
        return $this->hasOne('\App\Resources\Mobile');
    }

    public function country() {
        return $this->belongsTo('\App\Models\Country');
    }

    public function bankAccount() {
        return $this->hasOne('\App\Models\Rrhh\UserBankAccount','user_id');
    }

    public function creatorRequestForms(){
      return $this->hasMany(RequestForm::class, 'creator_user_id');
    }

    public function applicantRequestForms(){
      return $this->hasMany(RequestForm::class, 'applicant_user_id');
    }

    public function supervisorRequestForms(){
      return $this->hasMany(RequestForm::class, 'supervisor_user_id');
    }

    public function eventRequestForms(){
      return $this->hasMany(EventRequestForm::class, 'signer_user_id');
    }

    public function scopeSearch($query, $name) {
        if($name != "") {
            return $query->where('name', 'LIKE', '%'.$name.'%')
                         ->orWhere('fathers_family', 'LIKE', '%'.$name.'%')
                         ->orWhere('mothers_family', 'LIKE', '%'.$name.'%');
        }
    }

    public function runFormat() {
        return number_format($this->id, 0,'.','.') . '-' . $this->dv;
    }

    public function runNotFormat() {
        return $this->id . '-' . $this->dv;
    }

    public function getFullNameAttribute()
    {
        return mb_convert_case(mb_strtolower("{$this->name} {$this->fathers_family} {$this->mothers_family}"), MB_CASE_TITLE, "UTF-8");
    }

    public function getShortNameAttribute()
    {
        return ucwords(strtolower("{$this->name} {$this->fathers_family}"));
    }

    public function getFirstNameAttribute() {
        $names = explode(' ',trim($this->name));
        return ucwords(strtolower("{$names[0]}"));
    }

    public function getInitialsAttribute()
    {
        return "{$this->name[0]}{$this->fathers_family[0]}{$this->mothers_family[0]}";
    }

    public function documentEvents() {
        return $this->hasMany('\App\Documents\DocumentEvent');
    }

    public function documents() {
        return $this->hasMany('App\Documents\Document');
    }

    public function reqCategories() {
        return $this->hasMany('App\Requirements\Category');
    }

    public function requirementStatus() {
        return $this->hasMany('App\Requirements\RequirementStatus');
    }

    public function requirements() {
        return $this->hasMany('App\Requirements\Requirement');
    }

    public function requirementsEventsFrom() {
        return $this->hasMany('App\Requirements\Event','from_user_id');
    }

    public function requirementsEventsTo() {
        return $this->hasMany('App\Requirements\Event','to_user_id');
    }

    public function purchases() {
        return $this->hasMany('App\Pharmacies\Purchase');
    }

    public function dispatches() {
        return $this->hasMany('App\Pharmacies\Dipatch');
    }

    public function receivings() {
        return $this->hasMany('App\Pharmacies\Receiving');
    }

    public function establishments() {
        return $this->belongsToMany('\App\Pharmacies\Establishment', 'frm_establishments_users')
                    ->withTimestamps();
    }

    public function requests() {
        return $this->hasMany('App\Models\ReplacementStaff\RequestReplacementStaff');
    }

    public function userResults()
    {
        return $this->hasMany(Result::class, 'user_id', 'id');
        //return $this->hasMany('App\Models\Result', 'user_id', 'id');
    }

    public function serviceRequestsMyPendingsCount()
    {
        $user_id = $this->id;

        $serviceRequestsOthersPendings = [];
        $serviceRequestsMyPendings = [];
        $serviceRequestsAnswered = [];
        $serviceRequestsCreated = [];
        $serviceRequestsRejected = [];

        $serviceRequests = ServiceRequest::whereHas("SignatureFlows", function($subQuery) use($user_id){
                                             $subQuery->where('responsable_id',$user_id);
                                             $subQuery->orwhere('user_id',$user_id);
                                           })
                                           ->orderBy('id','asc')
                                           ->get();

        foreach ($serviceRequests as $key => $serviceRequest) {
          //not rejected
          if ($serviceRequest->SignatureFlows->where('status','===',0)->count() == 0) {
            foreach ($serviceRequest->SignatureFlows->sortBy('sign_position') as $key2 => $signatureFlow) {
              //with responsable_id
              if ($user_id == $signatureFlow->responsable_id) {
                if ($signatureFlow->status == NULL) {
                  if ($serviceRequest->SignatureFlows->where('sign_position',$signatureFlow->sign_position-1)->first()->status == NULL) {
                    $serviceRequestsOthersPendings[$serviceRequest->id] = $serviceRequest;
                  }else{
                    $serviceRequestsMyPendings[$serviceRequest->id] = $serviceRequest;
                  }
                }else{
                  $serviceRequestsAnswered[$serviceRequest->id] = $serviceRequest;
                }
              }
              //with organizational unit authority
              if ($user_id == $signatureFlow->ou_id) {

              }
            }
          }
          else{
            $serviceRequestsRejected[$serviceRequest->id] = $serviceRequest;
          }
        }


        foreach ($serviceRequests as $key => $serviceRequest) {
          if (!array_key_exists($serviceRequest->id,$serviceRequestsOthersPendings)) {
            if (!array_key_exists($serviceRequest->id,$serviceRequestsMyPendings)) {
              if (!array_key_exists($serviceRequest->id,$serviceRequestsAnswered)) {
                $serviceRequestsCreated[$serviceRequest->id] = $serviceRequest;
              }
            }
          }
        }

        return count($serviceRequestsMyPendings);
    }

    public function serviceRequestsOthersPendingsCount()
    {
        $user_id = $this->id;

        $serviceRequestsOthersPendings = [];
        $serviceRequestsMyPendings = [];
        $serviceRequestsAnswered = [];
        $serviceRequestsCreated = [];
        $serviceRequestsRejected = [];

        $serviceRequests = ServiceRequest::whereHas("SignatureFlows", function($subQuery) use($user_id){
                                             $subQuery->where('responsable_id',$user_id);
                                             $subQuery->orwhere('user_id',$user_id);
                                           })
                                           ->orderBy('id','asc')
                                           ->get();

        foreach ($serviceRequests as $key => $serviceRequest) {
          //not rejected
          if ($serviceRequest->SignatureFlows->where('status','===',0)->count() == 0) {
            foreach ($serviceRequest->SignatureFlows->sortBy('sign_position') as $key2 => $signatureFlow) {
              //with responsable_id
              if ($user_id == $signatureFlow->responsable_id) {
                if ($signatureFlow->status == NULL) {
                  if ($serviceRequest->SignatureFlows->where('sign_position',$signatureFlow->sign_position-1)->first()->status == NULL) {
                    $serviceRequestsOthersPendings[$serviceRequest->id] = $serviceRequest;
                  }else{
                    $serviceRequestsMyPendings[$serviceRequest->id] = $serviceRequest;
                  }
                }else{
                  $serviceRequestsAnswered[$serviceRequest->id] = $serviceRequest;
                }
              }
              //with organizational unit authority
              if ($user_id == $signatureFlow->ou_id) {

              }
            }
          }
          else{
            $serviceRequestsRejected[$serviceRequest->id] = $serviceRequest;
          }
        }


        foreach ($serviceRequests as $key => $serviceRequest) {
          if (!array_key_exists($serviceRequest->id,$serviceRequestsOthersPendings)) {
            if (!array_key_exists($serviceRequest->id,$serviceRequestsMyPendings)) {
              if (!array_key_exists($serviceRequest->id,$serviceRequestsAnswered)) {
                $serviceRequestsCreated[$serviceRequest->id] = $serviceRequest;
              }
            }
          }
        }

        return count($serviceRequestsOthersPendings);
    }



    /**
     * Retorna Usuarios según contenido en $searchText
     * Busqueda realizada en: nombres, apellidos, rut.
     * @return Patient[]|Builder[]|Collection
     */
    public static function getUsersBySearch($searchText){
                  $users = User::query();
                  $array_search = explode(' ', $searchText);
                  foreach($array_search as $word){
                  $users->where(function($q) use($word){
                            $q->where('name', 'LIKE', '%'.$word.'%')
                            ->orwhere('fathers_family','LIKE', '%'.$word.'%')
                            ->orwhere('mothers_family','LIKE', '%'.$word.'%')
                            ->orwhere('id','LIKE', '%'.$word.'%');
                            //->orwhere('dv','LIKE', '%'.$word.'%');
                      });
                  }//End foreach
              return $users;
        }// End getPatientsBySearch


    public static function dvCalculate($num){
        if(is_numeric($num)){
          $run = intval($num);
          $s=1;
          for($m=0;$run!=0;$run/=10)
              $s=($s+$run%10*(9-$m++%6))%11;
          $dv = chr($s?$s+47:75);
          return $dv;
        }
          else{
            return "Run no Válido";
          }
    }


    /**computers
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'birthday'];
}
