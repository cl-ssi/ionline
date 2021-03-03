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
      'id', 'service_request_id', 'year', 'month', 'type', 'start_date', 'end_date', 'observation',
      'responsable_approbation','responsable_approbation_date','responsable_approver_id',
      'rrhh_approbation','rrhh_approbation_date','rrhh_approver_id',
      'finances_approbation','finances_approbation_date','finances_approver_id', 'invoice_path', 'user_id'
  ];

  public function FulfillmentItems() {
      return $this->hasMany('\App\Models\ServiceRequests\FulfillmentItem');
  }

  public function ServiceRequest() {
      return $this->belongsTo('\App\Models\ServiceRequests\ServiceRequest');
  }

  public function responsableUser() {
      return $this->belongsTo('App\User','responsable_approver_id');
  }

  public function rrhhUser() {
      return $this->belongsTo('App\User','rrhh_approver_id');
  }

  public function financesUser() {
      return $this->belongsTo('App\User','finances_approver_id');
  }

  protected $table = 'doc_fulfillments';

  /**
   * The attributes that should be mutated to dates.
   *
   * @var array
   */
  protected $dates = ['start_date', 'end_date'];
}
