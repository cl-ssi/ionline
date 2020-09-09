<?php

namespace App\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mobile extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'brand', 'model', 'number'
  ];

  public function user() {
      return $this->belongsTo('\App\User');
  }

  public function scopeSearch($query, $search) {
      if($search != "") {
          return $query->where('number', 'LIKE', '%'.$search.'%')
                       ->orWhere('brand', 'LIKE', '%'.$search.'%');
      }
  }

  use SoftDeletes;
  /**
   * The attributes that should be mutated to dates.
   *
   * @var array
   */
  protected $dates = ['deleted_at'];

  /**
  * The table associated with the model.
  *
  * @var string
  */
  protected $table = 'res_mobiles';
}
