<?php

namespace App\Pharmacies;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dispatch extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'id', 'date', 'pharmacy_id', 'establishment_id', 'notes', 'user_id', 'sendC19', 'created_at'
  ];

  use SoftDeletes;

  protected $table = 'frm_dispatches';

  //relaciones
  public function pharmacy()
  {
    return $this->belongsTo('App\Pharmacies\Pharmacy');
  }

  public function dispatchItems()
  {
    return $this->hasMany('App\Pharmacies\DispatchItem');
  }

  public function establishment()
  {
    return $this->belongsTo('App\Pharmacies\Establishment');
  }

  public function user()
  {
    return $this->belongsTo('App\User')->withTrashed();
  }

  public function files()
  {
    return $this->hasMany('App\Pharmacies\File');
  }

  protected $dates = ['date'];
}
