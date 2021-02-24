<?php

namespace App\Models\ServiceRequests;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Fulfillment extends Model implements Auditable
{
  use \OwenIt\Auditing\Auditable;
  use HasFactory;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'id', 'service_request_id', 'year', 'month', 'type', 'start_date', 'end_date', 'observation'
  ];

  public function FulfillmentAbsences() {
      return $this->hasMany('\App\Models\ServiceRequests\FulfillmentAbsence');
  }

  public function ServiceRequest() {
      return $this->belongsTo('\App\Models\ServiceRequests\ServiceRequest');
  }

  protected $table = 'doc_fulfillments';

  /**
   * The attributes that should be mutated to dates.
   *
   * @var array
   */
  protected $dates = ['start_date', 'end_date'];
}
