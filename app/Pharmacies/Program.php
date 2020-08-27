<?php

namespace App\Pharmacies;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    //
    protected $fillable = [
        'name'
    ];

    protected $table = 'frm_programs';

    //relaciones
    public function products()
    {
      return $this->hasMany('App\Pharmacies\Product');
    }
}
