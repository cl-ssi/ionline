<?php

namespace App\Models\Drugs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceptionItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'substance_id', 'nue', 'sample_number', 'document_weight',
        'gross_weight', 'net_weight', 'estimated_net_weight', 'sample', 'countersample', 'destruct',
        'equivalent', 'result_number', 'result_date', 'result_substance_id'
    ];

    public function reception() {
        return $this->belongsTo('App\Models\Drugs\Reception');
    }

    public function substance() {
        return $this->belongsTo('App\Models\Drugs\Substance');
    }

    public function resultSubstance() {
        return $this->belongsTo('App\Models\Drugs\Substance', 'result_substance_id');
    }

    public function protocols() {
        return $this->hasMany('App\Models\Drugs\Protocol');
    }

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['result_date', 'deleted_at'];

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'drg_reception_items';
}
