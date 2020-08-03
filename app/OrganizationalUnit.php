<?php

namespace App;

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
        'name', 'organizational_units_id'
    ];

    public function users() {
        return $this->hasMany('\App\User');
    }

    public function father() {
        return $this->belongsTo('\App\rrhh\OrganizationalUnit', 'organizational_unit_id');
    }

    public function childs() {
        return $this->hasMany('\App\rrhh\OrganizationalUnit', 'organizational_unit_id');
    }

    public function documents() {
        return $this->hasMany('\App\Documents\Document');
    }

    public function documentEvents() {
        return $this->hasMany('\App\Documents\DocumentEvent');
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];
}
