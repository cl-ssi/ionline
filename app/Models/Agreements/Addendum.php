<?php

namespace App\Models\Agreements;

use App\Models\Documents\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Addendum extends Model
{
    use SoftDeletes;

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
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'date', 'res_date'];

    protected $table = 'agr_addendums';

    public function agreement()
    {
        return $this->belongsTo('App\Models\Agreements\Agreement');
    }

    public function fileToEndorse()
    {
        return $this->belongsTo('App\Models\Documents\SignaturesFile', 'file_to_endorse_id');
    }

    public function fileToSign()
    {
        return $this->belongsTo('App\Models\Documents\SignaturesFile', 'file_to_sign_id');
    }

    public function referrer()
    {
        return $this->belongsTo('App\Models\User', 'referrer_id')->withTrashed();
    }

    public function director_signer()
    {
        return $this->belongsTo('App\Models\Agreements\Signer', 'director_signer_id');
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    public function getEndorseStateBySignPos($i)
    {
        if ( $this->fileToEndorse )
            foreach ( $this->fileToEndorse->signaturesFlows as $signatureFlow )
                if ( $signatureFlow->sign_position == $i )
                    return ($signatureFlow->status === 0) ? 'fa-times text-danger' : (($signatureFlow->status === 1) ? 'fa-check text-success' : 'fa-check text-warning');
        return 'fa-ellipsis-h';
    }

    public function getEndorseObservationBySignPos($i)
    {
        if ( $this->fileToEndorse )
            foreach ( $this->fileToEndorse->signaturesFlows as $signatureFlow )
                if ( $signatureFlow->sign_position == $i )
                    return ($signatureFlow->status === 0) ? 'Motivo del rechazo: ' . $signatureFlow->observation : (($signatureFlow->status === 1) ? 'Aceptado el ' . $signatureFlow->signature_date->format('d-m-Y H:i') : 'Visación actual');
        return 'En espera';
    }

    public function isEndorsePendingBySignPos($i)
    {
        if ( $this->fileToEndorse )
            foreach ( $this->fileToEndorse->signaturesFlows as $signatureFlow )
                if ( $signatureFlow->sign_position == $i )
                    return $signatureFlow->status == null;
        return false;
    }

    public function getSignObservation()
    {
        if ( $this->fileToSign )
            foreach ( $this->fileToSign->signaturesFlows as $signatureFlow )
                if ( $signatureFlow->sign_position == 0 )
                    return ($signatureFlow->status === 0) ? 'Motivo del rechazo: ' . $signatureFlow->observation : (($signatureFlow->status === 1) ? 'Aceptado el ' . $signatureFlow->signature_date->format('d-m-Y H:i') : 'Visación actual');
        return 'En espera';
    }

    public function getSignState()
    {
        if ( $this->fileToSign )
            foreach ( $this->fileToSign->signaturesFlows as $signatureFlow )
                if ( $signatureFlow->sign_position == 0 )
                    return ($signatureFlow->status === 0) ? 'fa-times text-danger' : (($signatureFlow->status === 1) ? 'fa-check text-success' : 'fa-check text-warning');
        return 'fa-ellipsis-h';
    }
}
