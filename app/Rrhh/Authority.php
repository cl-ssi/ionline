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
            // ->where('type', $type)
            ->when(is_array($type), function ($q) use ($type) {
              return $q->whereIn('type', $type);
            })
            ->when(!is_array($type), function ($q) use ($type) {
              return $q->where('type', $type);
            })
            ->where('from','<=',$date)->where('to','>=',$date)->get()->last();
    }

    public static function getAmIAuthorityFromOu($date, $type, $user_id) {

        // $authorities =  Authority::with('organizationalUnit')
        //                 ->where('user_id', $user_id)
        //                 ->where('type', $type)
        //                 ->where('from','<=',$date)->where('to','>=',$date)
        //                 ->get();

        // $ous = array();
        // foreach($authorities as $authority) {
        //     $ous[] = $authority->organizationalUnit;
        // }

        // Pregunto por cada unidad organizacional que autoridad/es está/n a cargo segun el tipo y fecha de la consulta ordenados desde el mas nuevo
        $ous = OrganizationalUnit::with(['authorities' => function($q) use ($type, $date){
                                    $q->when($type, function ($q) use ($type) {
                                        is_array($type) ? $q->whereIn('type', $type) : $q->where('type', $type);
                                      })
                                      ->where('from','<=',$date)->where('to','>=',$date)
                                      ->orderBy('id', 'desc');
                                 }])->get();        
        
        // Ahora que se que autoridad/es esta/n a cargo en cada unidad organizacional pregunto por el user_id al primero de la lista de autoridad/es, de ser correcto guardo en un array de autoridades a retornar
        $authorities = array();
        foreach($ous as $ou)
            if($ou->authorities->isNotEmpty() && $ou->authorities->first()->user_id == $user_id)
                $authorities[] = $ou->authorities->first()->load('user', 'organizationalUnit');
        
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
