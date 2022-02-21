<?php

namespace App\Rrhh;

use Illuminate\Database\Eloquent\Model;
use App\Rrhh\OrganizationalUnit;
use App\User;

class Authority extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'from', 'to', 'position', 'type',
        'decree', 'organizational_unit_id', 'creator_id'
    ];

    public function organizationalUnit() {
        return $this->belongsTo('App\Rrhh\OrganizationalUnit');
    }

    public function user() {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function creator() {
        return $this->belongsTo('App\User','creator_id')->withTrashed();
    }

    public function agreement() {
        return $this->hasMany('App\Agreements\Agreement');
    }

    public static function getAuthorityFromDate($ou_id, $date, $type) {
        if (!is_string($date)) {
          $date = $date->format('Y-m-d');
        }

        return Authority::with('user','organizationalUnit')
            ->where('organizational_unit_id', $ou_id)
            ->when($type, function ($q) use ($type) {
                is_array($type) ? $q->whereIn('type', $type) : $q->where('type', $type);
              })
            ->where('from','<=',$date)->where('to','>=',$date)->get()->last();
    }

    public static function getBossFromUser($rut, $date) {
        if (!is_string($date)) {
          $date = $date->format('Y-m-d');
        }

        $u1 = User::find($rut);

        $result = Authority::with('user','organizationalUnit')
            ->where('organizational_unit_id', $u1->organizational_unit_id)
            ->where('type','manager')            
            ->where('from','<=',$date)->where('to','>=',$date)->get()->last();
        if($result == null)
        {
            $oujefe = OrganizationalUnit::find($u1->organizational_unit_id);
            return Authority::with('user','organizationalUnit')
            ->where('organizational_unit_id', $oujefe->father->id)
            ->where('type','manager')            
            ->where('from','<=',$date)->where('to','>=',$date)->get()->last();            
        }
        else
        {
            return $result;   

        }
        
    }

    public static function getAmIAuthorityFromOu($date, $type, $user_id) {
        if (!is_string($date)) {
          $date = $date->format('Y-m-d');
        }

        // Pregunto por cada unidad organizacional si el user_id existe segun el tipo y fecha de la consulta
        $ous = OrganizationalUnit::whereHas('authorities', function($q) use ($type, $date, $user_id){
                                    $q->where('user_id', $user_id)
                                      ->when($type, function ($q) use ($type) {
                                        is_array($type) ? $q->whereIn('type', $type) : $q->where('type', $type);
                                      })
                                      ->where('from','<=',$date)->where('to','>=',$date);
                                })
                                ->orderBy('organizational_unit_id','ASC')
                                ->get();

        // Ahora que se que unidades organizacionales pertenece uder_id pregunto si por cada unidad organizacional se encuetra primero en la lista de autoridad/es, de ser correcto guardo en un array de autoridades a retornar
        $authorities = array();
        foreach($ous as $ou){
            $authority = self::getAuthorityFromDate($ou->id, $date, $type);
            if($authority->user_id == $user_id) $authorities[] = $authority;
        }

        return $authorities;
    }

    protected $table = 'rrhh_authorities';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['from','to'];
}
