<?php

namespace App\Models\Pharmacies;

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
        'name','email'
    ];

    use SoftDeletes;

    protected $table = 'frm_establishments';

    //relaciones
    public function pharmacy()
    {
      return $this->belongsTo('App\Models\Pharmacies\Pharmacy');
    }

    public function dispatches()
    {
      return $this->hasMany('App\Models\Pharmacies\Dispatch');
    }

    public function products()
    {
      return $this->belongsToMany('App\Models\Pharmacies\Product', 'frm_establishments_products')
                              ->withPivot('id', 'stock', 'critic_stock', 'max_stock')
                              ->withTimestamps();
    }

    public function users() {
      return $this->belongsToMany('\App\User', 'frm_establishments_users')
                  ->withTimestamps();
  }
}
