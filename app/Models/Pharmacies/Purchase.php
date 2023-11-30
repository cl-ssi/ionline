<?php

namespace App\Models\Pharmacies;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'id',
      'date',
      'supplier_id',
      'purchase_order',
      'order_number',
      'notes',
      'invoice',
      'despatch_guide',
      'invoice_date',
      'pharmacy_id',
      'destination' ,
      'from' ,
      //'acceptance_certificate' ,
      'purchase_order_date' ,
      'doc_date' ,
      'purchase_order_amount' ,
      //'content' ,
      'invoice_amount',
      'user_id',
      'created_at'
  ];

  use SoftDeletes;

  protected $table = 'frm_purchases';

  //relaciones
  public function pharmacy()
  {
    return $this->belongsTo('App\Models\Pharmacies\Pharmacy');
  }

  public function purchaseItems()
  {
    return $this->hasMany('App\Models\Pharmacies\PurchaseItem');
  }

  public function supplier()
  {
    return $this->belongsTo('App\Models\Pharmacies\Supplier');
  }

  public function user()
  {
    return $this->belongsTo('App\User')->withTrashed();
  }

  public function signedRecord()
  {
      return $this->belongsTo('App\Models\Documents\SignaturesFile', 'signed_record_id');
  }

  protected $dates = ['date','invoice_date', 'purchase_order_date', 'doc_date'];

}
