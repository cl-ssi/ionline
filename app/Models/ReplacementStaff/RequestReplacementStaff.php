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
        'name', 'degree', 'legal_quality', 'work_day', 'other_work_day', 'start_date',
        'end_date', 'fundament', 'other_fundament', 'name_to_replace',
        'budget_item','budgetary_provision'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function organizationalUnit() {
        return $this->belongsTo('App\Rrhh\OrganizationalUnit');
    }

    public function requestSign() {
        return $this->hasMany('App\Models\ReplacementStaff\RequestSign');
    }

    public function technicalEvaluation() {
        return $this->hasOne('App\Models\ReplacementStaff\TechnicalEvaluation');
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
          case 'third_shift':
            return 'Tercer Turno';
            break;
          case 'fourth_shift':
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

    public static function getPendingRequestToSign(){
        $date = Carbon::now();
        $type = 'manager';
        $user_id = Auth::user()->id;

        $authorities = Authority::getAmIAuthorityFromOu($date, $type, $user_id);

        if(!empty($authorities)){
            foreach ($authorities as $authority) {
                $request_to_sign = RequestReplacementStaff::latest()
                    ->whereHas('requestSign', function($q) use ($authority){
                        $q->Where('organizational_unit_id', $authority->organizational_unit_id)
                        ->Where('request_status', 'pending');
                    })
                    ->paginate(10)
                    ->count();
            }
            return $request_to_sign;
        }
        else{
            return $request_to_sign = 0;
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
        'start_date','end_date'
    ];

    protected $table = 'rst_request_replacement_staff';
}
