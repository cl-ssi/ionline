<?php

namespace App\Models\ReplacementStaff;

use App\Models\Documents\Approval;
use App\Models\Rrhh\OrganizationalUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Applicant extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rst_applicants';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'replacement_staff_id',
        'psycholabor_evaluation_score',
        'technical_evaluation_score',
        'observations',
        'selected',
        'desist',
        'desist_observation',
        'reason',
        'start_date',
        'end_date',
        'name_to_replace',
        'sirh_contract',
        'replacement_reason',
        'ou_of_performance_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date'    => 'date',
        'end_date'      => 'date',
        'sirh_contract' => 'date'
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
     * Get the replacement staff that owns the applicant.
     *
     * @return BelongsTo
     */
    public function replacementStaff(): BelongsTo
    {
        return $this->belongsTo(ReplacementStaff::class);
    }

    /**
     * Get the technical evaluation that owns the applicant.
     *
     * @return BelongsTo
     */
    public function technicalEvaluation(): BelongsTo
    {
        return $this->belongsTo(TechnicalEvaluation::class);
    }

    /**
     * Get the organizational unit of performance.
     *
     * @return BelongsTo
     */
    public function ouPerformance(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'ou_of_performance_id');
    }

    /**
     * Get the approval model.
     *
     * @return MorphOne
     */
    public function approval(): MorphOne
    {
        return $this->morphOne(Approval::class, 'approvable');
    }

    /**
     * Get the psycholabor evaluation score attribute.
     *
     * @return string
     */
    public function getPsyEvaScoreAttribute(): string
    {
        if ( $this->psycholabor_evaluation_score >= 10 && $this->psycholabor_evaluation_score <= 59 ) {
            return 'No recomendable';
        }
        if ( $this->psycholabor_evaluation_score >= 60 && $this->psycholabor_evaluation_score <= 79 ) {
            return 'Recomendable con observaciones';
        }
        if ( $this->psycholabor_evaluation_score >= 80 ) {
            return 'Recomendable';
        }
        return '';
    }

    /**
     * Get the technical evaluation score attribute.
     *
     * @return string
     */
    public function getTechEvaScoreAttribute(): string
    {
        if ( $this->technical_evaluation_score >= 10 && $this->technical_evaluation_score <= 59 ) {
            return 'Mínimas competencias Técnicas';
        }
        if ( $this->technical_evaluation_score >= 60 && $this->technical_evaluation_score <= 70 ) {
            return 'Regulares competencias Técnicas';
        }
        if ( $this->technical_evaluation_score >= 71 && $this->technical_evaluation_score <= 80 ) {
            return 'Destacadas Competencias Técnicas';
        }
        if ( $this->technical_evaluation_score >= 81 ) {
            return 'Sobresalientes competencias Técnicas';
        }
        return '';
    }
}