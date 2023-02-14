<?php

namespace App\Rrhh;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Rrhh\OrganizationalUnit;
use App\Agreements\Agreement;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Authority extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'organizational_unit_id',
        'date',
        'position',
        'type',
        'decree',
        'from_time',
        'to_time',
        'representation_id',
    ];

    public function organizationalUnit() {
        return $this->belongsTo(OrganizationalUnit::class);
    }

    public function user() {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function creator() {
        return $this->belongsTo(User::class,'creator_id')->withTrashed();
    }
    
    public function represents() {
        return $this->belongsTo(User::class,'representation_id')->withTrashed();
    }

    public function agreement() {
        return $this->hasMany(Agreement::class);
    }

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'rrhh_authorities';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date'];


    public static function getAuthorityFromDate($ou_id, $date, $type) {
        return self::with('user','organizationalUnit')
            ->where('organizational_unit_id', $ou_id)
            ->where('date',$date->startOfDay())
            ->where('type',$type)
            ->first();
        
    }

    public static function getTodayAuthorityManagerFromDate($ou_id) {
        return self::getAuthorityFromDate($ou_id, today(), 'manager');
    }

    public static function getAuthorityFromAllTime($ou_id, $type) {

        return self::with('user','organizationalUnit')
            ->where('organizational_unit_id',$ou_id)
            ->where('type',$type)
            ->groupBy('user_id')
            ->get();
    }

    public static function getBossFromUser($user_id, $date) {
        $user = User::find($user_id);
        if($user)
        {
            return self::getAuthorityFromDate($user->organizational_unit_id, $date, 'manager');
        }
    }

    public static function getAmIAuthorityFromOu($date, $type, $user_id) {
        return self::with('user','organizationalUnit')
            ->where('user_id',$user_id)
            ->where('date',$date->startOfDay())
            ->where('type',$type)
            ->get();
    }

    public static function getAmIAuthorityOfMyOu($date, $type, $user_id) {
        $user = User::find($user_id);

        if($user AND $user->organizational_unit_id != null) {
            return self::with('user','organizationalUnit')
                ->where('user_id',$user_id)
                ->where('date',$date->startOfDay())
                ->where('type',$type)
                ->where('organizational_unit_id',$user->organizational_unit_id)
                ->exists();
        }
        else {
            return false;
        }
    }

}
