<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'run','dv','name','fathers_family','mothers_family','email','personal_email',
        'establishment_id','organizational_unit_id','organizationalUnit',
        'inform_method',
        'first_dose','first_dose_at','second_dose','second_dose_at',
        'fd_observation','sd_observation'
    ];

    protected $dates = [
        'first_dose','second_dose','first_dose_at','second_dose_at'
    ];

    public function establishment() {
        return $this->belongsTo('App\Establishment');
    }

    public function ortanizationalUnit() {
        return $this->belongsTo('App\Rrhh\OrganizationalUnit');
    }

    public function fullName() {
        return $this->name.' '.
            $this->fathers_family.' '.
            $this->mothers_family;
    }

    public function scopeSearch($query, $search)
    {
          if ($search) {
                $array_search = explode(' ', $search);
                foreach($array_search as $word){
                    $query->where(function($query) use($word){
                          $query->where('name', 'LIKE', '%'.$word.'%')
                          ->orwhere('fathers_family','LIKE', '%'.$word.'%')
                          ->orwhere('mothers_family','LIKE', '%'.$word.'%')
                          ->orwhere('run','LIKE', '%'.$word.'%');
                          //->orwhere('other_identification','LIKE', '%'.$word.'%');
                    });
                }
              }
          //dd($query->get()->toArray);
    }
}
