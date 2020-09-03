<?php

namespace App\Requirements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'id','file','name'
  ];

  /**
  * The table associated with the model.
  *
  * @var string
  */
  protected $table = 'req_files';

  //relaciones
  public function event() {
      return $this->belongsTo('App\Requirements\Event');
  }
}
