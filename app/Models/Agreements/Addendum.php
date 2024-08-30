<?php

namespace App\Models\Agreements;

use App\Models\Documents\Document;
use App\Models\Documents\SignaturesFile;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Addendum extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'agr_addendums';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'file',
        'res_number',
        'res_date',
        'res_file',
        'agreement_id',
        'file_to_endorse_id',
        'file_to_sign_id',
        'referrer_id',
        'director_signer_id',
        'representative',
        'representative_rut',
        'representative_appellative',
        'representative_decree',
        'document_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
        'res_date' => 'date',
    ];

    /**
     * Get the agreement that owns the addendum.
     */
    public function agreement(): BelongsTo
    {
        return $this->belongsTo(Agreement::class);
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
     * Get the referrer.
     */
    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referrer_id')->withTrashed();
    }

    /**
     * Get the director signer.
     */
    public function director_signer(): BelongsTo
    {
        return $this->belongsTo(Signer::class, 'director_signer_id');
    }

    /**
     * Get the document.
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    /**
     * Get the endorse state by sign position.
     */
    public function getEndorseStateBySignPos($i)
    {
        if ($this->fileToEndorse) {
            foreach ($this->fileToEndorse->signaturesFlows as $signatureFlow) {
                if ($signatureFlow->sign_position == $i) {
                    return ($signatureFlow->status === 0) ? 'fa-times text-danger' : (($signatureFlow->status === 1) ? 'fa-check text-success' : 'fa-check text-warning');
                }
            }
        }
        return 'fa-ellipsis-h';
    }

    /**
     * Get the endorse observation by sign position.
     */
    public function getEndorseObservationBySignPos($i)
    {
        if ($this->fileToEndorse) {
            foreach ($this->fileToEndorse->signaturesFlows as $signatureFlow) {
                if ($signatureFlow->sign_position == $i) {
                    return ($signatureFlow->status === 0) ? 'Motivo del rechazo: ' . $signatureFlow->observation : (($signatureFlow->status === 1) ? 'Aceptado el ' . $signatureFlow->signature_date->format('d-m-Y H:i') : 'Visación actual');
                }
            }
        }
        return 'En espera';
    }

    /**
     * Check if endorse is pending by sign position.
     */
    public function isEndorsePendingBySignPos($i)
    {
        if ($this->fileToEndorse) {
            foreach ($this->fileToEndorse->signaturesFlows as $signatureFlow) {
                if ($signatureFlow->sign_position == $i) {
                    return $signatureFlow->status == null;
                }
            }
        }
        return false;
    }

    /**
     * Get the sign observation.
     */
    public function getSignObservation()
    {
        if ($this->fileToSign) {
            foreach ($this->fileToSign->signaturesFlows as $signatureFlow) {
                if ($signatureFlow->sign_position == 0) {
                    return ($signatureFlow->status === 0) ? 'Motivo del rechazo: ' . $signatureFlow->observation : (($signatureFlow->status === 1) ? 'Aceptado el ' . $signatureFlow->signature_date->format('d-m-Y H:i') : 'Visación actual');
                }
            }
        }
        return 'En espera';
    }

    /**
     * Get the sign state.
     */
    public function getSignState()
    {
        if ($this->fileToSign) {
            foreach ($this->fileToSign->signaturesFlows as $signatureFlow) {
                if ($signatureFlow->sign_position == 0) {
                    return ($signatureFlow->status === 0) ? 'fa-times text-danger' : (($signatureFlow->status === 1) ? 'fa-check text-success' : 'fa-check text-warning');
                }
            }
        }
        return 'fa-ellipsis-h';
    }
}