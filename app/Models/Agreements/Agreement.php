<?php

namespace App\Models\Agreements;

use App\Models\Commune;
use App\Models\Documents\Document;
use App\Models\Documents\SignaturesFile;
use App\Models\Parameters\Municipality;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agreement extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'agr_agreements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agreement_id',
        'date',
        'period',
        'file',
        // 'fileAgreeEnd',
        'fileResEnd',
        'program_id',
        'commune_id',
        'quotas',
        'total_amount',
        'referente',
        'referrer_id',
        'referrer2_id',
        'director_signer_id',
        // 'representative',
        // 'representative_rut',
        // 'representative_appellative',
        // 'representative_decree',
        // 'municipality_address',
        // 'municipality_rut',
        'number',
        'resolution_date',
        'res_exempt_number',
        'res_exempt_date',
        'establishment_list',
        'file_to_endorse_id',
        'file_to_sign_id',
        'document_id',
        'res_document_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
        'resolution_date' => 'date',
        'res_exempt_date' => 'date',
        'res_resource_date' => 'date',
        'establishment_list' => 'array',
    ];

    /**
     * Get the previous agreement.
     */
    public function previous(): BelongsTo
    {
        return $this->belongsTo(Agreement::class, 'agreement_id');
    }

    /**
     * Get the document.
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    /**
     * Get the resolution document.
     */
    public function res_document(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'res_document_id');
    }

    /**
     * Get the program.
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the commune.
     */
    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class);
    }

    /**
     * Get the referrer.
     */
    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the second referrer.
     */
    public function referrer2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referrer2_id')->withTrashed();
    }

    /**
     * Get the municipality.
     */
    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class);
    }

    /**
     * Get the agreement amounts.
     */
    public function agreement_amounts(): HasMany
    {
        return $this->hasMany(AgreementAmount::class);
    }

    /**
     * Get the agreement quotas.
     */
    public function agreement_quotas(): HasMany
    {
        return $this->hasMany(AgreementQuota::class);
    }

    /**
     * Get the addendums.
     */
    public function addendums(): HasMany
    {
        return $this->hasMany(Addendum::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get the continuities.
     */
    public function continuities(): HasMany
    {
        return $this->hasMany(ContinuityResolution::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get the stages.
     */
    public function stages(): HasMany
    {
        return $this->hasMany(Stage::class);
    }

    /**
     * Get the director signer.
     */
    public function director_signer(): BelongsTo
    {
        return $this->belongsTo(Signer::class);
    }

    /**
     * Get the file to endorse.
     */
    public function fileToEndorse(): BelongsTo
    {
        return $this->belongsTo(SignaturesFile::class, 'file_to_endorse_id');
    }

    /**
     * Get the file to sign.
     */
    public function fileToSign(): BelongsTo
    {
        return $this->belongsTo(SignaturesFile::class, 'file_to_sign_id');
    }

    /**
     * Get the endorse state attribute.
     */
    public function getEndorseStateAttribute()
    {
        if ($this->fileResEnd) return 'success';
        if ($this->period >= 2024) return (!$this->document?->fileToSign) ? 'secondary' : (($this->document->fileToSign->hasRejectedFlow) ? 'danger' : (($this->document->fileToSign->hasAllFlowsSigned) ? 'success' : 'warning'));
        return (!$this->fileToEndorse) ? 'secondary' : (($this->fileToEndorse->hasRejectedFlow) ? 'danger' : (($this->fileToEndorse->hasAllFlowsSigned) ? 'success' : 'warning'));
    }

    /**
     * Get the sign state attribute.
     */
    public function getSignStateAttribute()
    {
        if ($this->fileResEnd) return 'success';
        return (!$this->fileToSign) ? 'secondary' : (($this->fileToSign->hasRejectedFlow) ? 'danger' : (($this->fileToSign->hasAllFlowsSigned) ? 'success' : 'warning'));
    }

    /**
     * Get the resolution sign state attribute.
     */
    public function getResSignStateAttribute()
    {
        if ($this->fileResEnd) return 'success';
        return ($this->fileToSign && $this->fileToSign->hasAllFlowsSigned && $this->fileResEnd) ? 'success' : (($this->fileToSign && $this->fileToSign->hasAllFlowsSigned && !$this->fileResEnd) ? 'warning' : 'secondary');
    }

    /**
     * Get the endorse state by sign position.
     */
    public function getEndorseStateBySignPos($i)
    {
        if ($this->period >= 2024 ? $this->document->fileToSign : $this->fileToEndorse)
            foreach ($this->period >= 2024 ? $this->document->fileToSign->signaturesFlows : $this->fileToEndorse->signaturesFlows as $signatureFlow)
                if ($signatureFlow->sign_position == $i)
                    return ($signatureFlow->status === 0) ? 'fa-times text-danger' : (($signatureFlow->status === 1) ? 'fa-check text-success' : 'fa-check text-warning');
        return 'fa-ellipsis-h';
    }

    /**
     * Get the endorse observation by sign position.
     */
    public function getEndorseObservationBySignPos($i)
    {
        if ($this->period >= 2024 ? $this->document->fileToSign : $this->fileToEndorse)
            foreach ($this->period >= 2024 ? $this->document->fileToSign->signaturesFlows : $this->fileToEndorse->signaturesFlows as $signatureFlow)
                if ($signatureFlow->sign_position == $i)
                    return ($signatureFlow->status === 0) ? 'Motivo del rechazo: ' . $signatureFlow->observation : (($signatureFlow->status === 1) ? 'Aceptado el ' . $signatureFlow->signature_date->format('d-m-Y H:i') : 'Visación actual');
        return 'En espera';
    }

    /**
     * Check if endorse is pending by sign position.
     */
    public function isEndorsePendingBySignPos($i)
    {
        if ($this->period >= 2024 ? $this->document->fileToSign : $this->fileToEndorse)
            foreach ($this->period >= 2024 ? $this->document->fileToSign->signaturesFlows : $this->fileToEndorse->signaturesFlows as $signatureFlow)
                if ($signatureFlow->sign_position == $i) return $signatureFlow->status == null;
        return false;
    }

    /**
     * Check if the agreement is of type mandate.
     */
    public function isTypeMandate()
    {
        return $this->program_id == 44 && $this->agreement_amounts->count() == 1 && $this->agreement_amounts->first()->program_component_id == 48; //Programa CAPACITACION con el unico COMPONENTE DESARROLLO RRHH
    }

    /**
     * Get the sign observation.
     */
    public function getSignObservation()
    {
        if ($this->fileToSign)
            foreach ($this->fileToSign->signaturesFlows as $signatureFlow)
                if ($signatureFlow->sign_position == 0)
                    return ($signatureFlow->status === 0) ? 'Motivo del rechazo: ' . $signatureFlow->observation : (($signatureFlow->status === 1) ? 'Aceptado el ' . $signatureFlow->signature_date->format('d-m-Y H:i') : 'Visación actual');
        return 'En espera';
    }

    /**
     * Get the sign state.
     */
    public function getSignState()
    {
        if ($this->fileToSign)
            foreach ($this->fileToSign->signaturesFlows as $signatureFlow)
                if ($signatureFlow->sign_position == 0)
                    return ($signatureFlow->status === 0) ? 'fa-times text-danger' : (($signatureFlow->status === 1) ? 'fa-check text-success' : 'fa-check text-warning');
        return 'fa-ellipsis-h';
    }

    /**
     * Get the rowspan.
     */
    public function rowspan()
    {
        return $this->addendums->count() > 0 ? $this->addendums->count() : 1;
    }
}