<?php

namespace App\Rrhh;

use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo('App\User');
    }

    public function creator() {
        return $this->belongsTo('App\User','creator_id');
    }

    public function agreement() {
        return $this->hasMany('App\Agreements\Agreement');
    }

    public static function getAuthorityFromDate($ou_id, $date, $type) {
        return Authority::with('user','organizationalUnit')
            ->where('organizational_unit_id', $ou_id)
            ->where('type', $type)
            ->where('from','<=',$date)->where('to','>=',$date)->get()->last();
    }
    
    public static function getAmIAuthorityFromOu($date, $type, $user_id) {
        // return Authority::with('user','organizationalUnit')
        //                 ->where('user_id', $user_id)
        //                 ->where('type', $type)
        //                 ->where('from','<=',$date)->where('to','>=',$date)->get();
        
        $ous = OrganizationalUnit::All();
        $authorities = array();
        foreach($ous as $ou) {
            $authority = Authority::with('user','organizationalUnit')
                ->where('organizational_unit_id', $ou->id)
                ->where('type', $type)
                ->where('from','<=',$date)->where('to','>=',$date)->get()->last();
            if($authority) {
                if($authority->user_id == $user_id){
                        $authorities[] = $authority;
                }
            }
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
