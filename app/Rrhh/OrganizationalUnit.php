<?php

namespace App\Rrhh;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationalUnit extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','root', 'organizational_unit_id','establishment_id'
    ];

    public function users() {
        return $this->hasMany('\App\User');
    }

    public function father() {
        return $this->belongsTo('\App\Rrhh\OrganizationalUnit', 'organizational_unit_id');
    }

    public function childs() {
        return $this->hasMany('\App\Rrhh\OrganizationalUnit', 'organizational_unit_id');
    }

    public function documents() {
        return $this->hasMany('\App\Documents\Document');
    }

    public function documentEvents() {
        return $this->hasMany('\App\Documents\DocumentEvent');
    }

    public function establishment() {
        return $this->belongsTo('\App\Establishment', 'establishment_id');
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];
}
