<?php

namespace App\Requirements;

use Illuminate\Database\Eloquent\Model;

class RequirementStatus extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'requirement_id', 'user_id', 'status'
  ];

  public function Requirements() {
      return $this->belongsTo('App\Requirements\Requirement');
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
  protected $table = 'req_requirements_status';
}
