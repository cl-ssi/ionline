<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vaccination extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'run','dv','name','fathers_family','mothers_family','email','personal_email',
        'establishment_id','organizational_unit_id','organizationalUnit',
        'inform_method','arrival_at','dome_at',
        'first_dose','first_dose_at','second_dose','second_dose_at',
        'fd_observation','sd_observation'
    ];

    protected $dates = [
        'arrival_at','dome_at','first_dose','second_dose','first_dose_at','second_dose_at'
    ];

    public function establishment() {
        return $this->belongsTo('App\Models\Establishment');
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
                });
            }
        }
    }

    public function getAliasEstabAttribute(){
        switch ($this->establishment_id) {
            case 1:
                return 'HETG';
                break;

            case 38:
                return 'DSSI';
                break;
        }
    }
    public function getAliasInformMethodAttribute(){
        switch ($this->inform_method) {
            case 1:
                return 'Clave Única';
                break;

            case 2:
                return 'Teléfono';
                break;
            case 3:
                return 'Correo';
                break;
            default:
                return '';
                break;
        }
    }

    public function getRunFormatAttribute() {
        return $this->run.'-'.$this->dv;
    }
}
