<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Suitability\Result;
use App\Models\RequestForms\RequestForm;
use App\Models\ServiceRequests\ServiceRequest;
use App\Models\Warehouse\Store;
use App\Models\Warehouse\StoreUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Profile\Subrogation;
use App\Models\Parameters\AccessLog;

class User extends Authenticatable implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use Notifiable, HasRoles, SoftDeletes, HasFactory;

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
        'id', 
        'dv', 
        'name', 
        'fathers_family',
        'mothers_family',
        'gender',
        'address',
        'phone_number',
        'email',
        'password',
        'birthday',
        'position',
        'active',
        'gravatar',
        'external',
        'country_id',
        'organizational_unit_id',
        'email_personal',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function organizationalUnit() 
    {
        return $this->belongsTo('\App\Rrhh\OrganizationalUnit');
    }

    public function telephones()
    {
        return $this->belongsToMany('\App\Resources\Telephone', 'res_telephone_user')->withTimestamps();
    }

    public function computers()
    {
        return $this->belongsToMany('\App\Resources\Computer', 'res_computer_user')->withTimestamps();
    }

    public function printers()
    {
        return $this->belongsToMany('\App\Resources\Printer', 'res_printer_user')->withTimestamps();
    }

    public function mobile()
    {
        return $this->hasOne('\App\Resources\Mobile');
    }

    public function country()
    {
        return $this->belongsTo('\App\Models\Country');
    }

    public function pharmacies() 
    {
        // return $this->belongsToMany('\App\Models\Pharmacies\Pharmacy');
        return$this->belongsToMany('\App\Pharmacies\Pharmacy', 'frm_pharmacy_user')->withTimestamps();
    }

    public function bankAccount()
    {
        return $this->hasOne('\App\Models\Rrhh\UserBankAccount','user_id');
    }

    public function requestForms()
    {
        return $this->belongsToMany(RequestForm::class, 'arq_request_forms_users', 'purchaser_user_id', 'request_form_id')
            ->withTimestamps();
    }

    public function supervisorRequestForms()
    {
        return $this->hasMany(RequestForm::class, 'supervisor_user_id');
    }

    public function eventRequestForms()
    {
        return $this->hasMany(EventRequestForm::class, 'signer_user_id');
    }

    /* TODO: buscar en que se usa y eliminar */
    public function getPosition(){
      if(is_null($this->position)){
        return "";}
      else{
        return $this->position;}
      }


    public function scopeSearch($query, $name) 
    {
        if($name != "") {
            return $query->where('name', 'LIKE', '%'.$name.'%')
                         ->orWhere('fathers_family', 'LIKE', '%'.$name.'%')
                         ->orWhere('mothers_family', 'LIKE', '%'.$name.'%');
        }
    }

    /**
     * Retorna Usuarios según contenido en $searchText
     * Busqueda realizada en: nombres, apellidos, rut.
     * @return Patient[]|Builder[]|Collection
     */
    public static function scopeFullSearch($query, $searchText){
        $query->withTrashed();
        $array_search = explode(' ', $searchText);
        foreach($array_search as $word){
            $query->where(function($q) use($word){
                $q->where('name', 'LIKE', '%'.$word.'%')
                  ->orwhere('fathers_family','LIKE', '%'.$word.'%')
                  ->orwhere('mothers_family','LIKE', '%'.$word.'%')
                  ->orwhere('id','LIKE', '%'.$word.'%');
            });
        }//End foreach
        return $query;
    }// End getPatientsBySearch


    public function runFormat()
    {
        return number_format($this->id, 0,'.','.') . '-' . $this->dv;
    }

    public function runNotFormat()
    {
        return $this->id . '-' . $this->dv;
    }

    public function getRunFormatAttribute()
    {
      return number_format($this->id, 0, '.', '.') . '-' . $this->dv;
    }

    public function getFullNameAttribute()
    {
        return mb_convert_case(mb_strtolower("{$this->name} {$this->fathers_family} {$this->mothers_family}"), MB_CASE_TITLE, "UTF-8");
    }

    public function getFullNameUpperAttribute()
    {
        return mb_convert_case(mb_strtoupper("{$this->name} {$this->fathers_family} {$this->mothers_family}"), MB_CASE_UPPER, "UTF-8");
    }

    /* TODO: Dejar solo una, ShortName (Nombre Apellido1) y eliminar tinnyName*/
    public function getShortNameAttribute()
    {
        return ucwords(strtolower("{$this->name} {$this->fathers_family}"));
    }

    /* TODO: Fusionar con la de arriba */
    public function getTinnyNameAttribute()
    {
        if(!is_null($this->name))
        {
            $name = explode(" ", $this->name)[0];
            return $name.' '.$this->fathers_family;
        }
        else
            return "";
    }

    public function getFirstNameAttribute()
    {
        $names = explode(' ',trim($this->name));
        return ucwords(strtolower("{$names[0]}"));
    }

    public function getInitialsAttribute()
    {
        $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
        $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
        $name = str_replace($a, $b, $this->name);
        $fathers = str_replace($a, $b, $this->fathers_family);
        $mothers = str_replace($a, $b, $this->mothers_family);

        return $name[0].$fathers[0].$mothers[0];
    }

    public function accessLogs()
    {
        return $this->hasMany(AccessLog::class);
    }

    public function switchLogs()
    {
        return $this->hasMany(AccessLog::class,'switch_id');
    }

    public function serviceRequests()
    {
        return $this->hasMany('\App\Models\ServiceRequests\ServiceRequest');
    }

    public function documentEvents()
    {
        return $this->hasMany('\App\Documents\DocumentEvent');
    }

    public function documents()
    {
        return $this->hasMany('App\Documents\Document');
    }

    public function reqCategories()
    {
        return $this->hasMany('App\Requirements\Category');
    }

    public function requirementStatus()
    {
        return $this->hasMany('App\Requirements\RequirementStatus');
    }

    public function requirements()
    {
        return $this->hasMany('App\Requirements\Requirement');
    }

    public function requirementsEventsFrom()
    {
        return $this->hasMany('App\Requirements\Event','from_user_id');
    }

    public function requirementsEventsTo()
    {
        return $this->hasMany('App\Requirements\Event','to_user_id');
    }

    public function purchases()
    {
        return $this->hasMany('App\Pharmacies\Purchase');
    }

    public function dispatches()
    {
        return $this->hasMany('App\Pharmacies\Dipatch');
    }

    public function receivings()
    {
        return $this->hasMany('App\Pharmacies\Receiving');
    }

    public function establishments()
    {
        return $this->belongsToMany('\App\Pharmacies\Establishment', 'frm_establishments_users')
                    ->withTimestamps();
    }

    public function requests()
    {
        return $this->hasMany('App\Models\ReplacementStaff\RequestReplacementStaff');
    }

    public function remEstablishments()
    {
        return $this->hasMany('App\Models\Rem\UserRem');
    }

    public function stores()
    {
        return $this->belongsToMany(Store::class, 'wre_store_user')
          ->using(StoreUser::class)
          ->withPivot(['role_id', 'status'])
          ->withTimestamps();
    }

    public function getActiveStoreAttribute()
    {
        $storeActive = $this->stores->where('pivot.status', '=', 1)->first();
        if($storeActive)
            return $storeActive;
        else
            return null;
    }

    public function userResults()
    {
        return $this->hasMany(Result::class, 'user_id', 'id');
        //return $this->hasMany('App\Models\Result', 'user_id', 'id');
    }

    /* FIXME: @sickiqq Ordenar la indentación, evaluar si este código se puede mejorar */
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

    /* FIXME: @sickiqq Ordenar la indentación, evaluar si este código se puede mejorar */
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
    public static function getUsersBySearch($searchText)
    {
        $users = User::query()->withTrashed();
        $array_search = explode(' ', $searchText);
        foreach($array_search as $word)
        {
            $users->where(function($q) use($word){
                $q->where('name', 'LIKE', '%'.$word.'%')
                ->orwhere('fathers_family','LIKE', '%'.$word.'%')
                ->orwhere('mothers_family','LIKE', '%'.$word.'%')
                ->orwhere('id','LIKE', '%'.$word.'%');
                //->orwhere('dv','LIKE', '%'.$word.'%');
            });
        }
        return $users;
    }

    public static function dvCalculate($num)
    {
        if(is_numeric($num))
        {
            $run = intval($num);
            $s=1;
            for($m=0;$run!=0;$run/=10)
                $s=($s+$run%10*(9-$m++%6))%11;
            $dv = chr($s?$s+47:75);
            return $dv;
        }
        else
        {
            return "Run no Válido";
        }
    }

    /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return array|string
     */
    public function routeNotificationForMail($notification)
    {
        return $this->email_personal;
    }

    public function scopeFindByUser($query, $searchText)
    {
        $array_search = explode(' ', $searchText);
        foreach($array_search as $word)
        {
            $query->where(function($q) use($word){
                $q->where('name', 'LIKE', '%'.$word.'%')
                ->orwhere('fathers_family','LIKE', '%'.$word.'%')
                ->orwhere('mothers_family','LIKE', '%'.$word.'%')
                ->orwhere('id','LIKE', '%'.$word.'%');
                });
        }
        return $query;
    }

    public function subrogations()
    {
        return $this->hasMany(Subrogation::class)->orderBy('level');
    }

    public function getSubrogantAttribute()
    {
        if($this->absent) {
            return $this->subrogations->where('subrogant.absent','false')->first()->subrogant ?? collect();
        }
        else {
            return $this;
        }
    }

    public function getIAmSubrogantOfAttribute()
    {
        $users = collect();

        $subrogations = Subrogation::with('user')
                        ->where('subrogant_id',$this->id)
                        ->whereRelation('user','absent',true)
                        ->get();
        foreach($subrogations as $subrogation)
        {
            if($subrogation->user->subrogant == $this) {
                unset($subrogation->user->subrogations);
                $users[] = $subrogation->user;
            }
        }
        return $users;
    }

    /**
     * Get either a Gravatar URL for a specified email address.
     *
     * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mp | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * example:
     * <img src="{{ auth()->user()->gravatarUrl }}" class="img-thumbnail rounded-circle" alt="Avatar">
     * example with params:
     * <img src="{{ auth()->user()->gravatarUrl }}?s=80&d=mp&r=g" class="img-thumbnail rounded-circle" alt="Avatar">
     */
    public function getGravatarUrlAttribute()
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "https://www.gravatar.com/avatar/$hash";
    }

    function getCheckGravatarAttribute()
    {
        $hash = md5($this->email);
        $uri = 'https://www.gravatar.com/avatar/' . $hash . '?d=404';
        $headers = @get_headers($uri);

        if ( preg_match("|200|", $headers[0]) )
        {
            if(!$this->gravatar)
            {
                $this->gravatar = true;
                $this->save();
            }
        } 
        else 
        {
            if($this->gravatar)
            {
                $this->gravatar = false;
                $this->save();
            }
        }
    }

    /**
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

    /**
     * Attributes to exclude from the Audit.
     *
     * @var array
     */
    protected $auditExclude = [
        'remember_token', 'password'
    ];
}
