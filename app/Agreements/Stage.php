<?php

namespace App\Agreements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','type','group','date','dateEnd','date_addendum','dateEnd_addendum','observation','agreement_id'
    ];

    public function agreement() {
        return $this->belongsTo('App\Agreements\Agreement');
    }

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date','dateEnd'];

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'agr_stages';
}
