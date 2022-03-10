<?php

namespace App\Pharmacies;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pharmacy extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address'
    ];

    use SoftDeletes;

    protected $table = 'frm_pharmacies';

    //relaciones
    public function disptachs()
    {
      return $this->hasMany('App\Pharmacies\Dispatch');
    }

    public function purchases()
    {
      return $this->hasMany('App\Pharmacies\Purchase');
    }

    public function receivings()
    {
      return $this->hasMany('App\Pharmacies\Receiving');
    }

    public function establishments()
    {
      return $this->hasMany('App\Pharmacies\Establishment');
    }

    public function suppliers()
    {
      return $this->hasMany('App\Pharmacies\Supplier');
    }

    public function products()
    {
      return $this->hasMany('App\Pharmacies\Product');
    }

    public function users()
    {
      // return $this->belongsToMany('App\User');
      return $this->belongsToMany('App\User', 'frm_pharmacy_user')->withTimestamps();
    }
}
