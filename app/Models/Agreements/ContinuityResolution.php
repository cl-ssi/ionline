<?php

namespace App\Models\Agreements;

use App\Models\Documents\Document;
use App\Models\Documents\SignaturesFile;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContinuityResolution extends Model
{
    use SoftDeletes;

    public function agreement() {
        return $this->belongsTo(Agreement::class);
    }

    public function fileToEndorse() {
        return $this->belongsTo(SignaturesFile::class, 'file_to_endorse_id');
    }

    public function document() {
        return $this->belongsTo(Document::class, 'document_id');
    }

    // public function fileToSign() {
    //     return $this->belongsTo(SignaturesFile::class, 'file_to_sign_id');
    // }

    public function referrer() {
        return $this->belongsTo(User::class, 'referrer_id')->withTrashed();
    }

    public function director_signer() {
        return $this->belongsTo(Signer::class, 'director_signer_id');
    }

    public function getEndorseStateBySignPos($i){
        if($this->fileToEndorse)
            foreach($this->fileToEndorse->signaturesFlows as $signatureFlow)
                if($signatureFlow->sign_position == $i)
                    return ($signatureFlow->status === 0) ? 'fa-times text-danger' : ( ($signatureFlow->status === 1) ? 'fa-check text-success' : 'fa-check text-warning' );
        return 'fa-ellipsis-h';
    }

    public function getEndorseObservationBySignPos($i){
        if($this->fileToEndorse)
            foreach($this->fileToEndorse->signaturesFlows as $signatureFlow)
                if($signatureFlow->sign_position == $i)
                    return ($signatureFlow->status === 0) ? 'Motivo del rechazo: '.$signatureFlow->observation : ( ($signatureFlow->status === 1) ? 'Aceptado el '.$signatureFlow->signature_date->format('d-m-Y H:i') : 'Visación actual' );
        return 'En espera';
    }

    public function isEndorsePendingBySignPos($i){
        if($this->fileToEndorse)
            foreach($this->fileToEndorse->signaturesFlows as $signatureFlow)
                if($signatureFlow->sign_position == $i) return $signatureFlow->status == null;
        return false;
    }

    // public function getSignObservation(){
    //     if($this->fileToSign)
    //         foreach($this->fileToSign->signaturesFlows as $signatureFlow)
    //             if($signatureFlow->sign_position == 0)
    //                 return ($signatureFlow->status === 0) ? 'Motivo del rechazo: '.$signatureFlow->observation : ( ($signatureFlow->status === 1) ? 'Aceptado el '.$signatureFlow->signature_date->format('d-m-Y H:i') : 'Visación actual' );
    //     return 'En espera';
    // }

    // public function getSignState(){
    //     if($this->fileToSign)
    //         foreach($this->fileToSign->signaturesFlows as $signatureFlow)
    //             if($signatureFlow->sign_position == 0)
    //                 return ($signatureFlow->status === 0) ? 'fa-times text-danger' : ( ($signatureFlow->status === 1) ? 'fa-check text-success' : 'fa-check text-warning' );
    //     return 'fa-ellipsis-h';
    // }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date', 'file', 'res_number', 'res_date', 'res_file', 'agreement_id', 'file_to_endorse_id', 'file_to_sign_id', 'referrer_id', 'director_signer_id', 'amount', 'document_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date', 'res_date'];

    protected $table = 'agr_continuity_resolutions';
}
