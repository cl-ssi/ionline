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
        'technical_competence', 'objective'
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
        return $this->belongsTo('App\Models\Parameters\StaffDecree', 'staff_decree_by_estament_id');
    }

    public function roles() {
        return $this->hasMany('App\Models\JobPositionProfiles\Role');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    // protected $dates = [
    //     ''
    // ];

    // protected $casts = [
    //     'degree' => 'integer'
    // ];

    protected $table = 'jpp_job_position_profiles';
}
