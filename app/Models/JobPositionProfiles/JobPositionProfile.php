<?php

namespace App\Models\JobPositionProfiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class JobPositionProfile extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name', 'charges_number', 'degree', 'subordinates', 'salary', 'law', 'dfl3', 'dfl29',
        'other_legal_framework', 'working_day', 'specific_requirement', 'training', 'experience',
        'technical_competence', 'objective', 'working_team'
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_creator_id')->withTrashed();
    }

    public function organizationalUnit() {
        return $this->belongsTo('App\Rrhh\OrganizationalUnit', 'ou_creator_id')->withTrashed();
    }

    public function estament() {
        return $this->belongsTo('App\Models\Parameters\Estament');
    }

    public function area() {
        return $this->belongsTo('App\Models\Parameters\Area');
    }

    public function contractualCondition() {
        return $this->belongsTo('App\Models\Parameters\ContractualCondition');
    }

    public function staffDecreeByEstament() {
        return $this->belongsTo('App\Models\Parameters\StaffDecreeByEstament', 'staff_decree_by_estament_id');
    }

    public function roles() {
        return $this->hasMany('App\Models\JobPositionProfiles\Role');
    }

    public function jppLiabilities() {
        return $this->hasMany('App\Models\JobPositionProfiles\JobPositionProfileLiability', 'job_position_profile_id');
    }

    public function jppExpertises() {
        return $this->hasMany('App\Models\JobPositionProfiles\ExpertiseProfile', 'job_position_profile_id');
    }

    public function jobPositionProfileSigns() {
        return $this->hasMany('App\Models\JobPositionProfiles\JobPositionProfileSign');
    }

    public function getSubordinatesValueAttribute() {
        switch($this->subordinates) {
          case '0':
            return 'No';
            break;
          case '1':
            return 'Sí';
            break;
        }
    }

    public function getLawValueAttribute() {
        switch($this->law) {
          case '18834':
            return 'Ley N°18.834';
            break;
          case '19664':
            return 'Ley N°19.664';
            break;
        }
    }

    public function getDfl3ValueAttribute() {
        switch($this->dfl3) {
          case '0':
            return '';
            break;
          case '1':
            return 'DFL N°03/17';
            break;
        }
    }

    public function getDfl29ValueAttribute() {
        switch($this->dfl29) {
          case '0':
            return '';
            break;
          case '1':
            return 'DFL N°29 (Estatuto Administrativo)';
            break;
        }
    }

    public function getOtherLegalFrameworkValueAttribute() {
        switch($this->other_legal_framework) {
          case '0':
            return '';
            break;
          case '1':
            return 'Otros (Ley N° 15.076) Urgencia 28 hrs.';
            break;
        }
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $dates = [
        'year'
    ];

    // protected $casts = [
    //     'degree' => 'integer'
    // ];

    protected $table = 'jpp_job_position_profiles';
}
