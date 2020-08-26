<?php

namespace App\Pharmacies;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'rut', 'address', 'commune', 'telephone', 'fax', 'contact'
    ];

    protected $table = 'frm_suppliers';

    //relaciones
    public function pharmacy()
    {
      return $this->belongsTo('App\Pharmacies\Pharmacy');
    }

    public function receivings()
    {
      return $this->hasMany('App\Pharmacies\Receiving');
    }

    public function purchases()
    {
      return $this->hasMany('App\Pharmacies\Purchase');
    }
}
