<?php

namespace App\Agreements;

use Illuminate\Database\Eloquent\Model;

class ProgramResolutionAmount extends Model
{
    public function program_resolution() {
        return $this->belongsTo('App\Agreements\ProgramResolution');
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
        'amount', 'subtitle', 'program_component_id', 'program_resolution_id'
    ];

    protected $table = 'agr_amounts';
}
