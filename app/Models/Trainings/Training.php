<?php

namespace App\Models\Trainings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Models\File;

class Training extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'status', 
        'user_training_id', 
        'estament_id', 
        'degree', 
        'contractual_condition_id', 
        'organizational_unit_id', 
        'establishment_id',
        'email', 
        'telephone', 
        'strategic_axes_id', 
        'objective',
        'activity_name',
        'activity_type',
        'other_activity_type',
        'mechanism',
        'schuduled',
        'activity_date_start_at',
        'activity_date_end_at',
        'total_hours',
        'permission_date_start_at',
        'permission_date_end_at',
        'place',
        'working_day',
        'technical_reasons',
        'feedback_type',
        'user_creator_id'
    ];

    public function userTraining() {
        if(auth()->guard('external')->check() == true){
            return $this->belongsTo('App\Models\UserExternal', 'user_training_id');
        }
        else{
            return $this->belongsTo('App\User', 'user_training_id')->withTrashed();
        }
    }

    public function userTrainingOu() {
        return $this->belongsTo('App\Rrhh\OrganizationalUnit', 'organizational_unit_id')->withTrashed();
    }

    public function userTrainingEstablishment() {
        return $this->belongsTo('App\Models\Establishment', 'establishment_id');
    }

    public function file(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable');
    }

    public function getStatusValueAttribute() {
        switch($this->status) {
            case 'saved':
                return 'Guardado';
                break;

            case 'pending':
                return 'Pendiente';
                break;
        }
    }

    protected $table = 'tng_trainings';
}
