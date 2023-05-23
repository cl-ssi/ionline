<?php

namespace App\Models\ReplacementStaff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


class ReplacementStaff extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'run', 'dv', 'birthday', 'name', 'fathers_family',
        'mothers_family', 'gender', 'email', 'telephone',
        'telephone2', 'region_id','commune_id', 'address', 'observations',
        'status', 'cv_file'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public function getFullNameAttribute()
    {
        return $this->name.' '.$this->fathers_family.' '.$this->mothers_family;
    }

    public function getIdentifierAttribute()
    {
        return strtoupper("{$this->run}-{$this->dv}");
    }

    public function region() {
        return $this->belongsTo('\App\Models\ClRegion');
    }

    public function clCommune() {
        return $this->belongsTo('\App\Models\ClCommune', 'commune_id');
    }

    public function profiles() {
        return $this->hasMany('\App\Models\ReplacementStaff\Profile');
    }

    public function experiences() {
        return $this->hasMany('\App\Models\ReplacementStaff\Experience');
    }

    public function trainings() {
        return $this->hasMany('\App\Models\ReplacementStaff\Training');
    }

    public function languages() {
        return $this->hasMany('\App\Models\ReplacementStaff\Language');
    }

    public function applicants() {
        return $this->hasMany('\App\Models\ReplacementStaff\Applicant');
    }

    public function staffManages() {
        return $this->hasMany('\App\Models\ReplacementStaff\StaffManage');
    }

    public function getStatusValueAttribute(){
        switch ($this->status) {
            case 'immediate_availability':
              return 'Disponibilidad Inmediata';
              break;
            case 'working_external':
              return 'Trabajando';
              break;
            case 'selected':
              return 'Seleccionado';
              break;
            default:
              return '';
              break;
        }
    }

    public function getGenderValueAttribute()
    {
        switch ($this->gender) {
            case 'male':
              return 'Masculino';
              break;
            case 'female':
              return 'Femenino';
              break;
            case 'other':
              return 'Otro';
              break;
            case 'unknown':
              return 'Desconocido';
              break;
            default:
              return '';
              break;
        }
      }

    public function scopeSearch($query, $search, $profile_search, $profession_search, $staff_search, $status_search)
    {
          if ($search OR $profile_search OR $profession_search OR $staff_search OR $status_search) {
              $array_name_search = explode(' ', $search);
              foreach($array_name_search as $word){
                  $query->where(function($query) use($word){
                      $query->where('name', 'LIKE', '%'.$word.'%')
                          ->orwhere('fathers_family','LIKE', '%'.$word.'%')
                          ->orwhere('mothers_family','LIKE', '%'.$word.'%')
                          ->orwhere('run','LIKE', '%'.$word.'%');
                  });
              }

              if($profile_search != 0){
                  $query->whereHas('profiles', function($q) use ($profile_search){
                      $q->Where('profile_manage_id', $profile_search);
                  });
              }

              if($profession_search != 0){
                  $query->whereHas('profiles', function($q) use ($profession_search){
                      $q->Where('profession_manage_id', $profession_search);
                  });
              }

              if($staff_search != 0){
                  $query->whereHas('staffManages', function($q) use ($staff_search){
                      $q->Where('organizational_unit_id', $staff_search);
                  });
              }

              if($status_search != "0"){
                  $query->where(function($q) use($status_search){
                      $q->where('status', $status_search);
                  });
              }
          }
    }

    protected $dates = [
        'birthday'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'rst_replacement_staff';
}
