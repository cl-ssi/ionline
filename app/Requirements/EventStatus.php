<?php

namespace App\Requirements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class EventStatus extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'event_id', 'user_id', 'status'
  ];

  public function Events() {
      return $this->belongsTo('App\Requirements\Event');
  }

  public function User() {
      return $this->belongsTo('\App\User');
  }

  /**
   * The attributes that should be mutated to dates.
   *
   * @var array
   */
  protected $dates = ['deleted_at', 'limit_at'];

  /**
  * The table associated with the model.
  *
  * @var string
  */
  protected $table = 'req_events_status';
}
