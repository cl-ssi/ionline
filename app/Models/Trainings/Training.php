<?php

namespace App\Models\Trainings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Models\File;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Documents\Approval;

class Training extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'status', 
        'user_training_id', 
        'estament_id',
        'law',
        'degree',
        'work_hours',
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
        'online_type',
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
        'municipal_profile',
        'user_creator_id'
    ];

    public function userTraining() {
        if(auth()->guard('external')->check() == true){
            return $this->belongsTo('App\Models\UserExternal', 'user_training_id');
        }
        else{
            
            return $this->belongsTo('App\Models\User', 'user_training_id')->withTrashed();
        }
    }

    public function userTrainingOu() {
        return $this->belongsTo('App\Rrhh\OrganizationalUnit', 'organizational_unit_id')->withTrashed();
    }

    public function userTrainingEstablishment() {
        return $this->belongsTo('App\Models\Establishment', 'establishment_id');
    }

    public function estament() {
        return $this->belongsTo('App\Models\Parameters\Estament');
    }

    public function contractualCondition() {
        return $this->belongsTo('App\Models\Parameters\ContractualCondition');
    }

    public function StrategicAxes() {
        return $this->belongsTo('App\Models\Trainings\StrategicAxes');
    }

    /**
     * Get all of the files of a model.
     */
    public function files(): MorphMany{
        return $this->morphMany(File::class, 'fileable');
    }

    /**
     * Get all of the ModificationRequest's approvations.
     */
    public function approvals(): MorphMany{
        return $this->morphMany(Approval::class, 'approvable');
    }

    public function getStatusValueAttribute() {
        switch($this->status) {
            case 'saved':
                return 'Guardado';
                break;
            
            case 'sent':
                return 'Enviado';
                break;

            case 'complete':
                return 'Finalizado';
                break;
            
            case 'rejected':
                return 'Rechazado';
                break;
        }
    }

    public function getActivityTypeValueAttribute() {
        switch($this->activity_type) {
            case 'curso':
                return 'Curso';
                break;
            
            case 'taller':
                return 'Taller';
                break;

            case 'jornada':
                return 'Jornada';
                break;
            
            case 'estadía pasantía':
                return 'Estadía Pasantía';
                break;
            
            case 'perfeccionamiento diplomado':
                return 'Perfeccionamiento Diplomado';
                break;
            
            case 'otro':
                return 'Otro';
                break;
        }
    }

    public function getMechanismValueAttribute() {
        switch($this->mechanism) {
            case 'online':
                return 'Online';
                break;
            
            case 'presencial':
                return 'Presencial';
                break;
        }
    }

    public function getOnlineTypeValueAttribute() {
        switch($this->online_type) {
            case 'sincronico':
                return 'Sincrónico';
                break;
            
            case 'asincronico':
                return 'Asincrónico';
                break;

            case 'mixta':
                return 'Mixta';
                break;
        }
    }

    public function getSchuduledValueAttribute() {
        switch($this->schuduled) {
            case 'pac':
                return 'Programada en PAC';
                break;
            
            case 'no planificada':
                return 'No planificada';
                break;
        }
    }

    public function getWorkingDayValueAttribute() {
        switch($this->working_day) {
            case 'completa':
                return 'Jornada Completa';
                break;
            
            case 'mañana':
                return 'Jornada Mañana';
                break;
            
            case 'tarde':
                return 'Jornada Tarde';
                break;
        }
    }

    protected $casts = [
        'activity_date_start_at'    => 'date:Y-m-d',
        'activity_date_end_at'      => 'date:Y-m-d',
        'permission_date_start_at'  => 'date:Y-m-d',
        'permission_date_end_at'    => 'date:Y-m-d'
    ];

    protected $table = 'tng_trainings';
}
