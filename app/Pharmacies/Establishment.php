<?php

namespace App\Pharmacies;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Establishment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    use SoftDeletes;

    protected $table = 'frm_establishments';

    //relaciones
    public function pharmacy()
    {
      return $this->belongsTo('App\Pharmacies\Pharmacy');
    }

    public function dispatches()
    {
      return $this->hasMany('App\Pharmacies\Dispatch');
    }

    public function products()
    {
      return $this->belongsToMany('App\Pharmacies\Product', 'frm_establishments_products')
                              ->withPivot('id', 'stock', 'critic_stock', 'max_stock')
                              ->withTimestamps();
    }

    public function users() {
      return $this->belongsToMany('\App\User', 'frm_establishments_users')
                  ->withTimestamps();
  }
}
