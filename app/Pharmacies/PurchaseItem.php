<?php

namespace App\Pharmacies;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseItem extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'id', 'barcode', 'purchase_id', 'product_id', 'amount', 'unity', 'unit_cost', 'due_date',
      'establishments_id',
      //'serial_number' ,
      'batch', 'created_at'
  ];

  use SoftDeletes;

  protected $table = 'frm_purchases_items';

  //relaciones
  public function purchase()
  {
    return $this->belongsTo('App\Pharmacies\Purchase');
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
