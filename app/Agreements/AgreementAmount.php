<?php

namespace App\Agreements;

use Illuminate\Database\Eloquent\Model;

class AgreementAmount extends Model
{
    public function agreement() {
        return $this->belongsTo('App\Agreements\Agreement');
    }

    public function program_component() {
        return $this->belongsTo('App\Agreements\ProgramComponent');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'subtitle', 'agreement_id', 'program_component_id'
    ];

    protected $table = 'agr_amounts';
}
