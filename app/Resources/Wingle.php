<?php

namespace App\Resources;

use Illuminate\Database\Eloquent\Model;

class Wingle extends Model
{
  protected $fillable = [
    'brand', 'model', 'company', 'imei', 'password'
  ];

  /**
  * The table associated with the model.
  *
  * @var string
  */
  protected $table = 'res_wingles';
}
