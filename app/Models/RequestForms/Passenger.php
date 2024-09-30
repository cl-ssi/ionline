<?php

namespace App\Models\RequestForms;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Parameters\BudgetItem;
use OwenIt\Auditing\Contracts\Auditable;

class Passenger extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    
    protected $fillable = [
        'passenger_type', 'document_type', 'document_number', 'user_id', 'run', 'dv' ,'name',
        'fathers_family', 'mothers_family', 'birthday', 'phone_number', 'email', 'round_trip', 
        'origin', 'destination', 'departure_date', 'return_date', 'baggage', 'unit_value', 'request_form_id'
    ];

    public function budgetItem() {
        return $this->belongsTo(BudgetItem::class);
    }

    public function purchasingProcess(){
      return $this->belongsToMany(PurchasingProcess::class, 'arq_purchasing_process_detail')->withPivot('id', 'internal_purchase_order_id', 'petty_cash_id', 'fund_to_be_settled_id', 'tender_id', 'direct_deal_id', 'immediate_purchase_id', 'user_id', 'quantity', 'unit_value', 'tax', 'expense', 'status', 'release_observation', 'supplier_run', 'supplier_name', 'supplier_specifications', 'charges', 'discounts')->whereNull('arq_purchasing_process_detail.deleted_at')->withTimestamps()->using(PurchasingProcessDetail::class);
    }

    public function getRunFormatAttribute() {
        return number_format($this->run, 0,'.','.') . '-' . $this->dv;
    }

    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->fathers_family} {$this->mothers_family}";
    }

    public function getFromDateFormatAttribute()
    {
      return Carbon::parse($this->from_date)->format('d-m-Y H:i:s');
    }

    public function getDepartureDateFormatAttribute()
    {
      return Carbon::parse($this->departure_date)->format('d-m-Y H:i:s');
    }

    public function getBaggageNameAttribute()
    {
      switch ($this->baggage) {

        case 'baggage':
          return "Equipaje de Bodega";
          break;

        case 'hand luggage':
          return "Equipaje de Cabina";
          break;

        case 'handbag':
          return "Bolso de Mano";
          break;
        
        case 'oversized baggage':
          return "Equipaje Sobredimensionado";
          break;
      }
    }

    public function getRoundTripNameAttribute()
    {
      switch ($this->round_trip) {

        case 'round trip':
          return "Ida y Vuelta";
          break;

        case 'one-way only':
          return "Solo Ida";
          break;
      }
    }

    public function request_form() {
        return $this->belongsTo('App\RequestForms\RequestForm');
    }

    public function request_form_item_codes() {
        return $this->belongsTo('App\RequestForms\RequestFormItemCode');
    }

    public function passengerChanged() {
        return $this->hasMany(PassengerChanged::class, 'passenger_id');
    }

    public function latestPendingPassengerChanged() {
        return $this->hasOne(PassengerChanged::class, 'passenger_id')->where('status', 'pending')->latestOfMany();
    }

    public $table = "arq_passengers";

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'departure_date'  => 'datetime',
        'return_date'     => 'datetime',
        'birthday'        => 'date'
    ];
}
