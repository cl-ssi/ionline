<?php

namespace App\Models\Drugs;

use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address', 'commune', 'status'
    ];

    public function Receptions() {
        return $this->hasMany('App\Models\Drugs\Reception');
    }

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'drg_courts';
}
