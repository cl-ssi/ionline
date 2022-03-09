<?php

namespace App\Pharmacies;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receiving extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'id', 'date', 'establishment_id', 'pharmacy_id', 'notes', 'user_id', 'created_at'
  ];

  use SoftDeletes;

  protected $table = 'frm_receivings';

  //relaciones
  public function pharmacy()
  {
    return $this->belongsTo('App\Pharmacies\Pharmacy');
  }

  public function receivingItems()
  {
    return $this->hasMany('App\Pharmacies\ReceivingItem');
  }

  public function establishment()
  {
    return $this->belongsTo('App\Pharmacies\Establishment');
  }

  public function user()
  {
    return $this->belongsTo('App\User')->withTrashed();
  }

  protected $dates = ['date'];

}
