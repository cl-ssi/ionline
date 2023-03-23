<?php

namespace App\Models\ReplacementStaff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Rrhh\Authority;
use Carbon\Carbon;
use OwenIt\Auditing\Contracts\Auditable;


class Position extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'profile_manage_id', 'degree', 'legal_quality_manage_id', 'salary', 'fundament_manage_id', 
        'fundament_detail_manage_id', 'other_fundament', 'work_day', 'other_work_day',
        'charges_number','job_profile_file', 'request_replacement_staff_id'
    ];

    public function profile_manage() {
        return $this->belongsTo(ProfileManage::class);
    }

    public function legalQualityManage() {
        return $this->belongsTo(LegalQualityManage::class);
    }

    public function fundamentManage() {
        return $this->belongsTo(RstFundamentManage::class)->withTrashed();
    }

    public function fundamentDetailManage() {
        return $this->belongsTo(FundamentDetailManage::class);
    }

    public function requestReplacementStaff() {
        return $this->belongsTo(ResquestReplacementStaff::class);
    }

    public function selectedPositions() {
      return $this->hasMany('App\Models\ReplacementStaff\SelectedPosition');
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

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'rst_positions';
}
