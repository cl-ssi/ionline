<?php

namespace App\Models\Documents;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParteEvent extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'action',
        'comment'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'parte_id',
        'organizational_unit_id',
        'created_at',
        'updated_at'
    ];

    public function parte()
    {
        return $this->belongsTo('\App\Models\Documents\Parte');
    }

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function organizationalUnit()
    {
        return $this->belongsTo('\App\Rrhh\OrganizationalUnit');
    }

    // public function father() {
    //     return $this->belongsTo('\App\Models\Documents\ParteEvent', 'parte_events_id');
    // }
    //
    // public function childs() {
    //     return $this->hasMany('\App\Models\Documents\ParteEvent', 'parte_events_id');
    // }
    //
    // public function ancestor($event = array()) {
    //     $event[] = $this;
    //     if($this->father) {
    //         return $this->father->ancestor($event);
    //     }
    //     return $event;
    // }
}
