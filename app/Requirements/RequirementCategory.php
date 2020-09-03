<?php

namespace App\Requirements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequirementCategory extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'requirement_id', 'category_id'
  ];

  public function categories() {
      return $this->belongsToMany('App\Requirements\Category');
  }

  public function Requirements() {
      return $this->belongsToMany('App\Requirements\Requirement','req_requirements_categories');
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
  protected $table = 'req_requirements_categories';
}
