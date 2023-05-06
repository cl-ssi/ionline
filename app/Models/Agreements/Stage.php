<?php

namespace App\Models\Agreements;

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
        return $this->belongsTo('App\Models\Agreements\Agreement');
    }

    public function getDateEndTextAttribute()
    {
        return $this->dateEnd ? 'Aceptado el '.$this->dateEnd->format('d-m-Y') : ($this->date ? 'Enviado el '.$this->date->format('d-m-Y') : 'En espera');
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
