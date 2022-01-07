<?php

namespace App\Models\RequestForms;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Passenger extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'run', 'dv' ,'name' ,'fathers_family', 'mothers_family',
        'birthday', 'phone_number', 'email', 'round_trip', 'origin', 'destination',
        'departure_date', 'return_date', 'baggage', 'unit_value', 'request_form_id'
    ];

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
          return "Equipaje de mano";
          break;

        case 'handbag':
          return "Bolso de Mano";
          break;
      }
    }

    public function request_form() {
        return $this->belongsTo('App\RequestForms\RequestForm');
    }

    public function request_form_item_codes() {
        return $this->belongsTo('App\RequestForms\RequestFormItemCode');
    }

    public $table = "arq_passengers";

    public $dates = ['departure_date', 'return_date'];
}
