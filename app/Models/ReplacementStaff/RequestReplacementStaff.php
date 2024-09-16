<?php

namespace App\Models\ReplacementStaff;

use App\Models\Documents\Approval;
use App\Models\Establishment;
use App\Models\Parameters\BudgetItem;
use App\Models\ReplacementStaff\AssignEvaluation;
use App\Models\ReplacementStaff\FundamentDetailManage;
use App\Models\ReplacementStaff\LegalQualityManage;
use App\Models\ReplacementStaff\Position;
use App\Models\ReplacementStaff\ProfileManage;
use App\Models\ReplacementStaff\RequestSign;
use App\Models\ReplacementStaff\RstFundamentManage;
use App\Models\ReplacementStaff\TechnicalEvaluation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class RequestReplacementStaff extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rst_request_replacement_staff';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'form_type',
        'name',
        'profile_manage_id',
        'law',
        'degree',
        'start_date',
        'end_date',
        'legal_quality_manage_id',
        'salary',
        'fundament_manage_id',
        'fundament_detail_manage_id',
        'name_to_replace',
        'run',
        'dv',
        'other_fundament',
        'work_day',
        'other_work_day',
        'charges_number',
        'job_profile_file',
        'request_verification_file',
        'ou_of_performance_id',
        'replacement_staff_id',
        'user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    /**
     * Get the user that owns the document.
     * //user_id ORIGINALMENTE QUIEN REGISTRA SOLICITUD
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the profile manage that owns the request.
     * // FIXME: This method should be named `profileManage` to follow the Laravel naming convention.
     * @return BelongsTo
     */
    public function profile_manage(): BelongsTo
    {
        return $this->belongsTo(ProfileManage::class);
    }

    /**
     * Get the legal quality manage that owns the request.
     *
     * @return BelongsTo
     */
    public function legalQualityManage(): BelongsTo
    {
        return $this->belongsTo(LegalQualityManage::class);
    }

    /**
     * Get the fundament manage that owns the request.
     *
     * @return BelongsTo
     */
    public function fundamentManage(): BelongsTo
    {
        return $this->belongsTo(RstFundamentManage::class)->withTrashed();
    }

    /**
     * Get the fundament detail manage that owns the request.
     *
     * @return BelongsTo
     */
    public function fundamentDetailManage(): BelongsTo
    {
        return $this->belongsTo(FundamentDetailManage::class);
    }

    /**
     * Get the organizational unit that owns the request.
     *
     * @return BelongsTo
     */
    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Rrhh\OrganizationalUnit::class)->withTrashed();
    }

    /**
     * Get the establishment that owns the request.
     *
     * @return BelongsTo
     */
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    /**
     * Get the requester user that owns the request.
     *
     * @return BelongsTo
     */
    public function requesterUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id')->withTrashed();
    }

    /**
     * Get the organizational unit of performance.
     *
     * @return BelongsTo
     */
    public function ouPerformance(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Rrhh\OrganizationalUnit::class, 'ou_of_performance_id')->withTrashed();
    }

    /**
     * Get the replacement staff that owns the request.
     *
     * @return BelongsTo
     */
    public function replacementStaff(): BelongsTo
    {
        return $this->belongsTo(ReplacementStaff::class);
    }

    /**
     * Get the request signs for the request.
     *
     * @return HasMany
     */
    public function requestSign(): HasMany
    {
        return $this->hasMany(RequestSign::class);
    }

    /**
     * Get the request signs for the request.
     *
     * @return HasMany
     */
    public function requestChilds(): HasMany
    {
        return $this->hasMany(RequestReplacementStaff::class, 'request_id');
    }

    public function requestFather(): BelongsTo 
    {
        return $this->belongsTo(RequestReplacementStaff::class, 'request_id');
    }

    /**
     * Get the technical evaluation for the request.
     *
     * @return HasOne
     */
    public function technicalEvaluation(): HasOne
    {
        return $this->hasOne(TechnicalEvaluation::class);
    }

    /**
     * Get the assign evaluations for the request.
     *
     * @return HasMany
     */
    public function assignEvaluations(): HasMany
    {
        return $this->hasMany(AssignEvaluation::class);
    }

    /**
     * Get the positions for the request.
     *
     * @return HasMany
     */
    public function positions(): HasMany
    {
        return $this->hasMany(Position::class);
    }

    /**
     * Get the budget item that owns the request.
     *
     * @return BelongsTo
     */
    public function budgetItem(): BelongsTo
    {
        return $this->belongsTo(BudgetItem::class);
    }

    /**
     * Get the signatures file that owns the request.
     *
     * @return BelongsTo
     */
    public function signaturesFile(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Documents\SignaturesFile::class);
    }

    /**
     * Get all of the ModificationRequest's approvations.
     *
     * @return MorphMany
     */
    public function approvals(): MorphMany
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

    public function getLegalQualityValueAttribute()
    {
        switch ($this->legal_quality) {
            case 'to hire':
                return 'Contrata';
            case 'fee':
                return 'Honorarios';
            default:
                return '';
        }
    }

    public function getWorkDayValueAttribute()
    {
        switch ($this->work_day) {
            case 'diurnal':
                return 'Diurno';
            case 'third shift':
                return 'Tercer Turno';
            case 'fourth shift':
                return 'Cuarto Turno';
            case 'other':
                return 'Otro';
            default:
                return '';
        }
    }

    public function getFundamentValueAttribute()
    {
        switch ($this->fundament) {
            case 'replacement':
                return 'Reemplazo o Suplencia';
            case 'quit':
                return 'Renuncia';
            case 'allowance without payment':
                return 'Permiso sin goce de sueldo';
            case 'regularization work position':
                return 'Regulación de cargos';
            case 'expand work position':
                return 'Cargo expansión';
            case 'vacations':
                return 'Feriado legal';
            case 'other':
                return 'Otro';
            default:
                return '';
        }
    }

    public function getStatusValueAttribute()
    {
        switch ($this->request_status) {
            case 'pending':
                return 'Pendiente';
            case 'complete':
                return 'Finalizada';
            case 'rejected':
                return 'Rechazada';
            case 'to assign':
                return 'Pendiente';
            case 'finance sign':
                return 'Pendiente';
            default:
                return '';
        }
    }

    public function getFormTypeValueAttribute()
    {
        switch ($this->form_type) {
            case 'replacement':
                return 'Reemplazo';
            case 'announcement':
                return 'Convocatoria';
            default:
                return '';
        }
    }

    public function getNumberOfDays()
    {
        return (int) $this->start_date->startOfDay()->diffInDays($this->end_date->endOfDay()->addDays());
    }

    public static function getCurrentContinuity($requestReplacementStaff)
    {
        if ($requestReplacementStaff->requestChilds->count() > 0) {
            if ($requestReplacementStaff->requestChilds->last()->request_status == 'complete' &&
                $requestReplacementStaff->requestChilds->last()->end_date < now()->toDateString()) {
                return 'no current';
            }
            if ($requestReplacementStaff->requestChilds->last()->request_status == 'rejected') {
                return 'no current';
            }
        } else {
            return 'no childs';
        }
    }

    public function scopeSearch($query, $form_type_search, $status_search, $id_search, $start_date_search, 
        $end_date_search, $name_search, $fundament_search, $fundament_detail_search, $name_to_replace_search,
        $sub_search)
    {
        if ($form_type_search || $status_search || $id_search || $start_date_search || $end_date_search || $name_search || 
            $fundament_search || $fundament_detail_search || $name_to_replace_search || $sub_search) {
            if ($form_type_search != '') {
                $query->where(function($q) use($form_type_search) {
                    $q->where('form_type', $form_type_search);
                });
            }
            if ($status_search != '') {
                $query->where(function($q) use($status_search) {
                    $q->where('request_status', $status_search);
                });
            }
            if ($id_search != '') {
                $query->where(function($q) use($id_search) {
                    $q->where('id', 'LIKE', '%'.$id_search.'%');
                });
            }
            if ($start_date_search != '' && $end_date_search != '') {
                $query->where(function($q) use($start_date_search, $end_date_search) {
                    $q->whereBetween('created_at', [$start_date_search, $end_date_search." 23:59:59"])->get();
                });
            }
            if ($name_search != '') {
                $query->where(function($q) use($name_search) {
                    $q->where('name', 'LIKE', '%'.$name_search.'%');
                });
            }
            if ($fundament_search != 0) {
                $query->whereHas('fundamentManage', function($q) use ($fundament_search) {
                    $q->Where('fundament_manage_id', $fundament_search);
                });
            }
            if ($fundament_detail_search != 0) {
                $query->whereHas('fundamentDetailManage', function($q) use ($fundament_detail_search) {
                    $q->Where('fundament_detail_manage_id', $fundament_detail_search);
                });
            }
            if ($name_to_replace_search != '') {
                $query->where(function($q) use($name_to_replace_search) {
                    $q->where('name_to_replace', 'LIKE', '%'.$name_to_replace_search.'%')
                        ->orwhere('run','LIKE', '%'.$name_to_replace_search.'%');
                });
            }
            if (!empty($sub_search)) {
                $query->where(function($q) use($sub_search) {
                    $q->whereIn('organizational_unit_id', $sub_search);
                });
            }
        }
    }
}