<?php

namespace App\Models\ReplacementStaff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Rrhh\Authority;
use Carbon\Carbon;

class RequestReplacementStaff extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'name', 'profile_manage_id', 'degree', 'start_date', 'end_date',
        'legal_quality_manage_id', 'salary', 'fundament_manage_id', 'fundament_detail_manage_id',
        'name_to_replace', 'other_fundament', 'work_day', 'other_work_day',
        'charges_number','job_profile_file', 'request_verification_file',
        'ou_of_performance_id'
    ];

    public function requestFather() {
        return $this->belongsTo('App\Models\ReplacementStaff\RequestReplacementStaff', 'request_id');
    }

    public function profile_manage() {
        return $this->belongsTo('App\Models\ReplacementStaff\ProfileManage');
    }

    public function legalQualityManage() {
        return $this->belongsTo('App\Models\ReplacementStaff\LegalQualityManage');
    }

    public function fundamentManage() {
        return $this->belongsTo('App\Models\ReplacementStaff\RstFundamentManage')->withTrashed();
    }

    public function fundamentDetailManage() {
        return $this->belongsTo('App\Models\ReplacementStaff\FundamentDetailManage');
    }

    public function user() {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function organizationalUnit() {
        return $this->belongsTo('App\Rrhh\OrganizationalUnit');
    }

    public function ouPerformance() {
        return $this->belongsTo('App\Rrhh\OrganizationalUnit', 'ou_of_performance_id');
    }

    public function requestSign() {
        return $this->hasMany('App\Models\ReplacementStaff\RequestSign');
    }

    public function technicalEvaluation() {
        return $this->hasOne('App\Models\ReplacementStaff\TechnicalEvaluation');
    }

    public function assignEvaluations() {
        return $this->hasMany('App\Models\ReplacementStaff\AssignEvaluation');
    }

    public function getLegalQualityValueAttribute() {
        switch($this->legal_quality) {
          case 'to hire':
            return 'Contrata';
            break;
          case 'fee':
            return 'Honorarios';
            break;
        }
    }

    public function getWorkDayValueAttribute() {
        switch($this->work_day) {
          case 'diurnal':
            return 'Diurno';
            break;
          case 'third shift':
            return 'Tercer Turno';
            break;
          case 'fourth shift':
            return 'Cuarto Turno';
            break;
          case 'other':
            return 'Otro';
            break;
        }
    }

    public function getFundamentValueAttribute() {
        switch($this->fundament) {
          case 'replacement':
            return 'Reemplazo o Suplencia';
            break;
          case 'quit':
            return 'Renuncia';
            break;
          case 'allowance without payment':
            return 'Permiso sin goce de sueldo';
            break;
          case 'regularization work position':
            return 'Regulación de cargos';
            break;
          case 'expand work position':
            return 'Cargo expansión';
            break;
          case 'vacations':
            return 'Feriado legal';
            break;
          case 'other':
            return 'Otro';
            break;
        }
    }

    public function getStatusValueAttribute() {
        switch($this->request_status) {
          case 'pending':
            return 'Pendiente';
            break;
          case 'complete':
            return 'Completa';
            break;
          case 'rejected':
            return 'Rechazada';
            break;
        }
    }

    public static function getPendingRequestToSign(){
        $date = Carbon::now();
        $type = 'manager';
        $user_id = Auth::user()->id;

        $authorities = Authority::getAmIAuthorityFromOu($date, $type, $user_id);

        foreach ($authorities as $authority){
            $iam_authorities_in[] = $authority->organizational_unit_id;
        }

        if(!empty($authorities)){
            foreach ($authorities as $authority) {
                $request_to_sign = RequestReplacementStaff::latest()
                    ->whereHas('requestSign', function($q) use ($authority, $iam_authorities_in){
                        $q->Where('organizational_unit_id', $iam_authorities_in)
                        ->Where('request_status', 'pending');
                    })
                    ->paginate(10)
                    ->count();
            }
            return $request_to_sign;
        }
        elseif (Auth::user()->hasRole('Replacement Staff: personal sign')) {

            $request_to_sign = RequestReplacementStaff::latest()
                ->whereHas('requestSign', function($q){
                    $q->Where('organizational_unit_id', 46)
                    ->Where('request_status', 'pending');
                })
                ->paginate(10)
                ->count();

            return $request_to_sign;
        }
        else{
            return $request_to_sign = 0;
        }
    }

    public function getNumberOfDays() {
        $numberDays = 1 + $this->end_date->diff($this->start_date)->format("%a");
        return $numberDays;
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
        'start_date','end_date'
    ];

    protected $table = 'rst_request_replacement_staff';
}
