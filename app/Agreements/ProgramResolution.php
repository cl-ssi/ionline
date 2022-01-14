<?php

namespace App\Agreements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramResolution extends Model
{
    use SoftDeletes;

    public function program() {
        return $this->belongsTo('App\Agreements\Program');
    }

    public function referrer() {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function director_signer(){
        return $this->belongsTo('App\Agreements\Signer');
    }

    public function resolution_amounts() {
        return $this->hasMany('App\Agreements\ProgramResolutionAmount');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number', 'date', 'file', 'program_id', 'director_signer_id', 'referrer_id', 'res_exempt_number', 'res_exempt_date', 'res_resource_number', 'res_resource_date', 'establishment'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at','date', 'res_exempt_date', 'res_resource_date'];

    protected $table = 'agr_program_resolutions';
}
