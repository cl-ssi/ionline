<?php

namespace App\Requirements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabelRequirement extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'requirement_id',
      'label_id'
  ];

  public function labels() {
      return $this->belongsToMany('App\Requirements\Label');
  }

  public function requirements() {
      return $this->belongsToMany('App\Requirements\Requirement');
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
  protected $table = 'req_labels_requirements';
}
