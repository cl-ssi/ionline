<?php

namespace App\Models\RequestForms;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Parameters\BudgetItem;

class PassengerChanged extends Model
{
  use SoftDeletes;
  protected $fillable = [
    'user_id', 'run', 'dv', 'name', 'fathers_family', 'mothers_family',
    'birthday', 'phone_number', 'email', 'round_trip', 'origin', 'destination',
    'departure_date', 'return_date', 'baggage', 'unit_value', 'status',
    'passenger_id', 'budget_item_id'
  ];

  public function budgetItem()
  {
    return $this->belongsTo(BudgetItem::class);
  }

  public function getRunFormatAttribute()
  {
    return number_format($this->run, 0, '.', '.') . '-' . $this->dv;
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

  public function passenger()
  {
    return $this->belongsTo(Passenger::class);
  }

  public $table = "arq_passengers_changed";

  /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
      'departure_date'  => 'date', 
      'return_date'     => 'datetime', 
      'birthday'        => 'datetime'
  ];
}
