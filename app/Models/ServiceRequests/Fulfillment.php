<?php

namespace App\Models\ServiceRequests;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fulfillment extends Model implements Auditable
{
  use \OwenIt\Auditing\Auditable;
  use HasFactory;
  use SoftDeletes;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'id', 'service_request_id', 'year', 'month', 'type', 'start_date', 'end_date', 'observation',
      'responsable_approbation','responsable_approbation_date','responsable_approver_id',
      'rrhh_approbation','rrhh_approbation_date','rrhh_approver_id',
      'finances_approbation','finances_approbation_date','finances_approver_id', 'invoice_path', 'user_id',
      'bill_number','total_hours_to_pay','total_to_pay','total_hours_paid','total_paid','payment_date','contable_month'
  ];

  public function MonthOfPayment() {
    if ($this->contable_month) {
      if ($this->contable_month == 1) {
        return "Enero";
      }elseif ($this->contable_month == 2) {
        return "Febrero";
      }elseif ($this->contable_month == 3) {
        return "Marzo";
      }elseif ($this->contable_month == 4) {
        return "Abril";
      }elseif ($this->contable_month == 5) {
        return "Mayo";
      }elseif ($this->contable_month == 6) {
        return "Junio";
      }elseif ($this->contable_month == 7) {
        return "Julio";
      }elseif ($this->contable_month == 8) {
        return "Agosto";
      }elseif ($this->contable_month == 9) {
        return "Septiembre";
      }elseif ($this->contable_month == 10) {
        return "Octubre";
      }elseif ($this->contable_month == 11) {
        return "Noviembre";
      }elseif ($this->contable_month == 12) {
        return "Diciembre";
      }
    }
  }

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
  protected $dates = ['start_date', 'end_date','payment_date'];
}
