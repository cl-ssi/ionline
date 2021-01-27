<?php

namespace App\Models\ServiceRequests;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;

class ServiceRequest extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'responsable_id','user_id','subdirection_ou_id', 'responsability_center_ou_id','type', 'rut', 'name', 'request_date', 'start_date', 'end_date', 'contract_type', 'service_description',
        'programm_name', 'other', 'normal_hour_payment', 'amount', 'program_contract_type', 'daily_hours', 'nightly_hours', 'estate', 'estate_other',
        'working_day_type', 'working_day_type_other', 'subdirection_id', 'responsability_center_id','budget_cdp_number', 'budget_item', 'budget_amount', 'budget_date',
        'contract_number','month_of_payment','establishment_id','nationality','digera_strategy','rrhh_team','gross_amount','sirh_contract_registration','resolution_number',
        'bill_number','total_hours_paid','total_paid','payment_date','address','phone_number','email','verification_code'

    ];

    public function MonthOfPayment() {
    	 if ($this->month_of_payment == 1) {
         return "Enero";
       }elseif ($this->month_of_payment == 2) {
         return "Febrero";
       }elseif ($this->month_of_payment == 3) {
         return "Marzo";
       }elseif ($this->month_of_payment == 4) {
         return "Abril";
       }elseif ($this->month_of_payment == 5) {
         return "Mayo";
       }elseif ($this->month_of_payment == 6) {
         return "Junio";
       }elseif ($this->month_of_payment == 7) {
         return "Julio";
       }elseif ($this->month_of_payment == 8) {
         return "Agosto";
       }elseif ($this->month_of_payment == 9) {
         return "Septiembre";
       }elseif ($this->month_of_payment == 10) {
         return "Octubre";
       }elseif ($this->month_of_payment == 11) {
         return "Noviembre";
       }elseif ($this->month_of_payment == 12) {
         return "Diciembre";
       }
    }

    public function user(){
      return $this->belongsTo('App\User','responsable_id');
    }

    public function SignatureFlows() {
    		return $this->hasMany('\App\Models\ServiceRequests\SignatureFlow');
    }

    public function establishment() {
    		return $this->belongsTo('\App\Establishment');
    }

    // public function responsabilityCenter() {
    // 		return $this->belongsTo('\App\Models\ServiceRequests\ResponsabilityCenter');
    // }

    public function subdirection() {
    		return $this->belongsTo('\App\Rrhh\OrganizationalUnit','subdirection_ou_id');
    }

    public function responsabilityCenter() {
        return $this->belongsTo('\App\Rrhh\OrganizationalUnit','responsability_center_ou_id');
    }

    public function shiftControls() {
    		return $this->hasMany('\App\Models\ServiceRequests\ShiftControl');
    }

    public static function getPendingRequests()
    {
      $serviceRequestsPendingsCount = ServiceRequest::whereHas("SignatureFlows", function($subQuery) {
                                                   $subQuery->where('user_id',Auth::user()->id)->whereNull('status');
                                                 })
                                                 ->where('user_id','!=',Auth::user()->id)
                                                 ->orderBy('id','asc')
                                                 ->count();
      return $serviceRequestsPendingsCount;
    }


    protected $table = 'doc_service_requests';
}
