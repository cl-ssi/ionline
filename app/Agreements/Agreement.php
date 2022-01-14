<?php

namespace App\Agreements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agreement extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number', 'date', 'period', 'file', 'commune_id', 'program_id', 'quotas', 'referente', 'director_signer_id', 'referrer_id', 'file_to_endorse_id', 'file_to_sign_id'
    ];

    protected $casts = [
        'establishment_list' => 'array'
    ];

    /**
     * Get all of the posts for the country.
     */
    // public function amounts()
    // {
    //     return $this->hasMany('App\Agreements\ComponentAmount', 'App\Agreements\AgreementComponent');
    // }

    public function program() {
        return $this->belongsTo('App\Agreements\Program');
    }

    public function commune() {
        return $this->belongsTo('App\Models\Commune');
    }

    public function referrer() {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function municipality() {
        return $this->belongsTo('App\Municipality');
    }

    public function agreement_amounts() {
        return $this->hasMany('App\Agreements\AgreementAmount');
    }

    public function agreement_quotas() {
        return $this->hasMany('App\Agreements\AgreementQuota');
    }

    public function addendums() {
        return $this->hasMany('App\Agreements\Addendum')->orderBy('created_at','desc');
    }

    public function stages() {
        return $this->hasMany('App\Agreements\Stage');
    }

    public function director_signer(){
        return $this->belongsTo('App\Agreements\Signer');
    }

    public function fileToEndorse() {
        return $this->belongsTo('App\Models\Documents\SignaturesFile', 'file_to_endorse_id');
    }

    public function fileToSign() {
        return $this->belongsTo('App\Models\Documents\SignaturesFile', 'file_to_sign_id');
    }

    public function getEndorseStateAttribute(){
        if($this->fileResEnd) return 'success';
        return (!$this->fileToEndorse) ? 'secondary' : ( ($this->fileToEndorse->hasRejectedFlow) ? 'danger' : ( ($this->fileToEndorse->hasAllFlowsSigned) ? 'success' : 'warning' ) );
    }

    public function getSignStateAttribute(){
        if($this->fileResEnd) return 'success';
        return (!$this->fileToSign) ? 'secondary' : ( ($this->fileToSign->hasRejectedFlow) ? 'danger' : ( ($this->fileToSign->hasAllFlowsSigned) ? 'success' : 'warning' ) );
    }

    public function getResSignStateAttribute(){
        if($this->fileResEnd) return 'success';
        return ($this->fileToSign && $this->fileToSign->hasAllFlowsSigned && $this->fileResEnd) ? 'success' : ( ($this->fileToSign && $this->fileToSign->hasAllFlowsSigned && !$this->fileResEnd) ? 'warning' : 'secondary' );
    }

    public function getEndorseStateBySignPos($i){
        foreach($this->fileToEndorse->signaturesFlows as $signatureFlow)
            if($signatureFlow->sign_position == $i)
                return ($signatureFlow->status === 0) ? 'fa-times text-danger' : ( ($signatureFlow->status === 1) ? 'fa-check text-success' : 'fa-check text-warning' );
        return 'fa-ellipsis-h';
    }

    public function getEndorseObservationBySignPos($i){
        foreach($this->fileToEndorse->signaturesFlows as $signatureFlow)
            if($signatureFlow->sign_position == $i)
                return ($signatureFlow->status === 0) ? 'Motivo del rechazo: '.$signatureFlow->observation : ( ($signatureFlow->status === 1) ? 'Aceptado el '.$signatureFlow->signature_date->format('d-m-Y H:i') : 'Visación actual' );
        return 'En espera';
    }

    public function isEndorsePendingBySignPos($i){
        foreach($this->fileToEndorse->signaturesFlows as $signatureFlow)
            if($signatureFlow->sign_position == $i) return $signatureFlow->status == null;
        return false;
    }
    

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = 'agr_agreements';
}
