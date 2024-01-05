<?php

namespace App\Models\Agreements;

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
        'number', 'date', 'period', 'file', 'commune_id', 'program_id', 'quotas', 'total_amount', 'referente', 
        'director_signer_id', 'referrer_id', 'file_to_endorse_id', 'file_to_sign_id', 'fileResEnd'
    ];

    protected $casts = [
        'establishment_list' => 'array'
    ];

    /**
     * Get all of the posts for the country.
     */
    // public function amounts()
    // {
    //     return $this->hasMany('App\Models\Agreements\ComponentAmount', 'App\Models\Agreements\AgreementComponent');
    // }

    public function program() {
        return $this->belongsTo('App\Models\Agreements\Program');
    }

    public function commune() {
        return $this->belongsTo('App\Models\Commune');
    }

    public function referrer() {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function municipality() {
        return $this->belongsTo('App\Models\Parameters\Municipality');
    }

    public function agreement_amounts() {
        return $this->hasMany('App\Models\Agreements\AgreementAmount');
    }

    public function agreement_quotas() {
        return $this->hasMany('App\Models\Agreements\AgreementQuota');
    }

    public function addendums() {
        return $this->hasMany('App\Models\Agreements\Addendum')->orderBy('created_at','desc');
    }

    public function continuities() {
        return $this->hasMany('App\Models\Agreements\ContinuityResolution')->orderBy('created_at','desc');
    }

    public function stages() {
        return $this->hasMany('App\Models\Agreements\Stage');
    }

    public function director_signer(){
        return $this->belongsTo('App\Models\Agreements\Signer');
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

    public function isTypeMandate(){
        return $this->program_id == 44 && $this->agreement_amounts->count() == 1 && $this->agreement_amounts->first()->program_component_id == 48; //Programa CAPACITACION con el unico COMPONENTE DESARROLLO RRHH
    }

    public function getSignObservation(){
        if($this->fileToSign)
            foreach($this->fileToSign->signaturesFlows as $signatureFlow)
                if($signatureFlow->sign_position == 0)
                    return ($signatureFlow->status === 0) ? 'Motivo del rechazo: '.$signatureFlow->observation : ( ($signatureFlow->status === 1) ? 'Aceptado el '.$signatureFlow->signature_date->format('d-m-Y H:i') : 'Visación actual' );
        return 'En espera';
    }

    public function getSignState(){
        if($this->fileToSign)
            foreach($this->fileToSign->signaturesFlows as $signatureFlow)
                if($signatureFlow->sign_position == 0)
                    return ($signatureFlow->status === 0) ? 'fa-times text-danger' : ( ($signatureFlow->status === 1) ? 'fa-check text-success' : 'fa-check text-warning' );
        return 'fa-ellipsis-h';
    }

    public function rowspan(){
        return $this->addendums->count() > 0 ? $this->addendums->count() : 1;
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
