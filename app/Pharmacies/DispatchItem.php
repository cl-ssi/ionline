<?php

namespace App\Pharmacies;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DispatchItem extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'id', 'barcode', 'dispatch_id', 'product_id', 'amount', 'unity', 'due_date','batch', 'created_at'
  ];

  use SoftDeletes;

  protected $table = 'frm_dispatch_items';

  //relaciones
  public function dispatch()
  {
    return $this->belongsTo('App\Pharmacies\Dispatch');
  }

  public function product()
  {
    return $this->belongsTo('App\Pharmacies\Product')->withTrashed();
  }

  /**
   * The attributes that should be mutated to dates.
   *
   * @var array
   */
  protected $dates = ['due_date'];
}
