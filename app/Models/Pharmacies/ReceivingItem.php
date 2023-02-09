<?php

namespace App\Models\Pharmacies;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceivingItem extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'id', 'barcode', 'receiving_id', 'product_id', 'amount', 'unity', 'due_date',
      //'serial_number',
      'batch','batch_id','created_at'
  ];

  use SoftDeletes;

  protected $table = 'frm_receiving_items';

  //relaciones
  public function receiving()
  {
    return $this->belongsTo('App\Models\Pharmacies\Receiving','receiving_id');
  }

  public function product()
  {
    return $this->belongsTo('App\Models\Pharmacies\Product','product_id')->withTrashed();
  }

  /**
   * The attributes that should be mutated to dates.
   *
   * @var array
   */
  protected $dates = ['due_date'];

}
