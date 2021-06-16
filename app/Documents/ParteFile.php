<?php

namespace App\Documents;

use Illuminate\Database\Eloquent\Model;

class ParteFile extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
    protected $fillable = [
      'id','file','name','parte_id'
    ];


    //relaciones
    public function event() {
        return $this->belongsTo('App\Documents\Parte');
    }

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'parte_files';
}
