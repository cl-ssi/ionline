<?php

namespace App\Documents;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParteEvent extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'action', 'comment'
    ];

    public function parte() {
        return $this->belongsTo('\App\Documents\Parte');
    }

    public function user() {
        return $this->belongsTo('\App\User');
    }

    public function organizationalUnit() {
        return $this->belongsTo('\App\Rrhh\OrganizationalUnit');
    }

    // public function father() {
    //     return $this->belongsTo('\App\Documents\ParteEvent', 'parte_events_id');
    // }
    //
    // public function childs() {
    //     return $this->hasMany('\App\Documents\ParteEvent', 'parte_events_id');
    // }
    //
    // public function ancestor($event = array()) {
    //     $event[] = $this;
    //     if($this->father) {
    //         return $this->father->ancestor($event);
    //     }
    //     return $event;
    // }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'parte_id', 'organizational_unit_id', 'created_at', 'updated_at'
    ];

    use SoftDeletes;
}
