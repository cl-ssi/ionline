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
        'number', 'date', 'period', 'file', 'commune_id', 'program_id', 'quotas', 'referente', 'authority_id', 'referrer_id'
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
        return $this->belongsTo('App\User');
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
        return $this->hasMany('App\Agreements\Addendum');
    }

    public function stages() {
        return $this->hasMany('App\Agreements\Stage');
    }

    public function authority(){
        return $this->belongsTo('App\Rrhh\Authority');
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
