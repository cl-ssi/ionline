<?php

namespace App\Rrhh;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

use App\Users;

class OrganizationalUnit extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','level', 'organizational_unit_id','establishment_id'
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

    public function authorities() {
        return $this->hasMany('\App\Rrhh\Authority');
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

    public function requestForms(){
      return $this->hasMany(RequestForm::class, 'applicant_ou_id');
    }

    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);
        $initials = '';
        foreach ($words as $word) {
            if ($word != 'de' && $word != 'y' && $word != 'la' && $word != 'e' && $word != 'las' && $word != 'del'
                && $word != 'al' && $word != 'en' && $word != 'el') {
                if ($word === 'Subdirección') {
                    $initials .= 'SD';
                } elseif ($word === 'S.A.M.U.' || $word === 'P.E.S.P.I.' || $word === 'P.R.A.I.S.' || $word === 'O.I.R.S.' ||
                    $word === 'GES/PPV') {
                    $initials .= $word;
                } else {
                    $initials .= $word[0];
                }
            }
        }
        return $initials;
    }

    protected $table = 'organizational_units';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];
}
