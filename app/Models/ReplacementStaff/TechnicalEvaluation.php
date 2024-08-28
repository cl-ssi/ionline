<?php

namespace App\Models\ReplacementStaff;

use App\Models\ReplacementStaff\Applicant;
use App\Models\ReplacementStaff\Commission;
use App\Models\ReplacementStaff\RequestReplacementStaff;
use App\Models\ReplacementStaff\TechnicalEvaluationFile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class TechnicalEvaluation extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rst_technical_evaluations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date_end'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date_end' => 'datetime'
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
     * Get the user that owns the document.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the request replacement staff that owns the technical evaluation.
     *
     * @return BelongsTo
     */
    public function requestReplacementStaff(): BelongsTo
    {
        return $this->belongsTo(RequestReplacementStaff::class);
    }

    /**
     * Get the commissions for the technical evaluation.
     *
     * @return HasMany
     */
    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class);
    }

    /**
     * Get the applicants for the technical evaluation.
     *
     * @return HasMany
     */
    public function applicants(): HasMany
    {
        return $this->hasMany(Applicant::class);
    }

    /**
     * Get the technical evaluation files for the technical evaluation.
     *
     * @return HasMany
     */
    public function technicalEvaluationFiles(): HasMany
    {
        return $this->hasMany(TechnicalEvaluationFile::class);
    }

    /**
     * Get the status value attribute.
     *
     * @return string
     */
    public function getStatusValueAttribute(): string
    {
        switch ($this->technical_evaluation_status) {
            case 'pending':
                return 'Pendiente';
            case 'complete':
                return 'Completa';
            case 'rejected':
                return 'Rechazada';
            default:
                return '';
        }
    }

    /**
     * Get the reason value attribute.
     *
     * @return string
     */
    public function getReasonValueAttribute(): string
    {
        switch ($this->reason) {
            case 'falta oferta laboral':
                return 'Falta de oferta laboral';
            case 'rechazo oferta laboral':
                return 'Rechazo de oferta laboral';
            case 'other':
                return 'Otro';
            default:
                return '';
        }
    }
}