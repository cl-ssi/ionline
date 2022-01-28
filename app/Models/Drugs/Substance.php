<?php

namespace App\Models\Drugs;

use Illuminate\Database\Eloquent\Model;

class Substance extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'rama', 'unit', 'laboratory', 'isp', 'presumed'
    ];

    public function items() {
        return $this->hasMany('App\Models\Drugs\ReceptionItem');
    }

    // TODO: asociar result_substance en ReceptionItem a otro item.

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'drg_substances';
}
