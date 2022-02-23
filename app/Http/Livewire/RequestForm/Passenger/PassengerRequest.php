<?php

namespace App\Http\Livewire\RequestForm\Passenger;

use Livewire\Component;
use App\User;
use App\Models\Parameters\PurchaseMechanism;
use Carbon\Carbon;

class PassengerRequest extends Component
{
    public $edit, $tittle;
    //public $items, $key;

    /* Mantenedores */
    public $lstPurchaseMechanism;


    // public $program, $justification, $run, $dv, $names, $fathersName, $mothersName, $birthDay,
    //        $telephoneNumber, $email, $trip, $origin, $destiny, $departureDate, $fromDate,
    //        $baggage, $passengerType;

    public $searchedUser;

    public $passengerType, $run, $dv, $name, $fathers_family, $mothers_family,
          $birthday, $phone_number, $email, $round_trip, $origin, $destination,
          $departure_date, $return_date, $baggage, $unitValue;

    public $roundTripValue;

    public $passengers, $key, $editRF, $savedPassengers, $deletedPassengers;

    public $totalValue = 0 , $precision_currency;

    protected $listeners = ['searchedUser', 'savedTypeOfCurrency'];

    //Para Validar

    protected $rules = [
        // 'passengerType'     =>  'required',
        'run'               =>  'required|integer|min:1',
        'dv'                =>  'required|numeric|min:1',
        'name'              =>  'required',
        'fathers_family'    =>  'required',
        'mothers_family'    =>  'required',
        'birthday'          =>  'required',
        'phone_number'      =>  'required|integer',
        'email'             =>  'required|email',
        'round_trip'        =>  'required',
        'origin'            =>  'required',
        //'destination'       =>  'required',
        'departure_date'    =>  'required',
        'return_date'       =>  'required',
        'baggage'           =>  'required',
        'unitValue'         =>  'required',

    ];

    protected $messages = [
        // 'passengerType.required'    => 'Seleccione tipo de Pasajero.',
        'run.required'              => 'Campo Run es obligatorio.',
        'run.integer'               => 'Run debe ser número entero sin puntos ni dígito verificador.',
        'run.min'                   => 'Run debe ser mayor o igual a 1.',
        'dv.required'               => 'Campo DV es obligatorio.',
        'dv.numeric'                => 'DV debe ser numérico.',
        'dv.min'                    => 'DV debe ser mayor o igual a 0.1.',
        'name.required'             => 'Campo Nombre Completo',
        'fathers_family.required'   => 'Campo Apellido Paterno es requerido.',
        'mothers_family.required'   => 'Campo Apellido Materno es requerido',
        'phone_number.required'     => 'Campo Teléfono es obligatorio.',
        'phone_number.integer'      => 'Campo Teléfono debe ser numérico entero sin puntos.',
        'birthday.required'         => 'Campo Fecha de Nacimiento es requerido.',
        'email.required'            => 'E-mail es requerido.',
        'email.email'               => 'E-mail debe contener formato adecuado.',
        'round_trip.required'       => 'Seleccione un tipo de viaje.',
        'origin.required'           => 'Campo Origen es requerido.',
        //'destination.required'      => 'Campo Destino es requerido.',
        'departure_date.required'   => 'Campo Fecha de Ida es requerido.',
        'return_date.required'      => 'Campo Fecha de Regreso es requerido.',
        'baggage.required'          => 'Seleccione tipo de equipaje.',
        'unitValue.required'        => 'Debe ingresar el valor del pasaje.',
    ];

    public function addPassenger(){
        $this->validate();
        $this->passengers[]=[
              'id'                =>  null,
              'passenger_type'    =>  $this->passengerType,
              'run'               =>  $this->run,
              'dv'                =>  $this->dv,
              'name'              =>  $this->name,
              'fathers_family'    =>  $this->fathers_family,
              'mothers_family'    =>  $this->mothers_family,
              'birthday'          =>  $this->birthday,
              'phone_number'      =>  $this->phone_number,
              'email'             =>  $this->email,
              'round_trip'        =>  $this->round_trip,
              'origin'            =>  $this->origin,
              'destination'       =>  $this->destination,
              'departure_date'    =>  $this->departure_date,
              'return_date'       =>  $this->return_date,
              'baggage'           =>  $this->baggage,
              'unitValue'         =>  $this->unitValue
        ];
        $this->totalValue();
        $this->cleanPassenger();

        $this->emit('savedPassengers', $this->passengers);
    }

    public function cleanPassenger(){
      //$this->tittle = "Agregar Ticket";
      $this->edit  = false;
      $this->resetErrorBag();
      $this->run=$this->run=$this->dv=$this->name=$this->fathers_family=
        $this->mothers_family=$this->birthday=$this->phone_number=$this->email=
        $this->round_trip=$this->origin=$this->destination=$this->departure_date=
        $this->departure_date=$this->return_date=$this->baggage=$this->unitValue = "";
    }

    public function deletePassenger($key){
        if($this->editRF && array_key_exists('id',$this->passengers[$key])){
            $this->deletedPassengers[]=$this->passengers[$key]['id'];
            $this->emitUp('deletedPassengers', $this->deletedPassengers);
            }
        unset($this->passengers[$key]);
        $this->totalValue();
        $this->cleanPassenger();
        $this->emit('savedPassengers', $this->passengers);
        //$this->cleanTicket();
    }

    public function editPassenger($key){
      $this->resetErrorBag();
      //$this->title                    = "Editar Item Nro ". ($key+1);
      $this->edit                     = true;

      $this->run            = $this->passengers[$key]['run'];
      $this->dv             = $this->passengers[$key]['dv'];
      $this->name           = $this->passengers[$key]['name'];
      $this->fathers_family = $this->passengers[$key]['fathers_family'];
      $this->mothers_family = $this->passengers[$key]['mothers_family'];
      $this->birthday       = $this->passengers[$key]['birthday'];
      $this->phone_number   = $this->passengers[$key]['phone_number'];
      $this->email          = $this->passengers[$key]['email'];
      $this->round_trip     = $this->passengers[$key]['round_trip'];
      $this->origin         = $this->passengers[$key]['origin'];
      $this->destination    = $this->passengers[$key]['destination'];
      $this->departure_date = Carbon::parse($this->passengers[$key]['departure_date'])->format('Y-m-d\TH:i:s');
      $this->return_date    = Carbon::parse($this->passengers[$key]['return_date'])->format('Y-m-d\TH:i:s');
      $this->baggage        = $this->passengers[$key]['baggage'];
      $this->unitValue      = $this->passengers[$key]['unitValue'];

      $this->key                      = $key;
    }

    public function updatePassenger(){
        $this->validate();
        $this->edit                                     = false;
        $this->passengers[$this->key]['run']            = $this->run;
        $this->passengers[$this->key]['dv']             = $this->dv;
        $this->passengers[$this->key]['name']           = $this->name;
        $this->passengers[$this->key]['fathers_family'] = $this->fathers_family;
        $this->passengers[$this->key]['mothers_family'] = $this->mothers_family;
        $this->passengers[$this->key]['birthday']       = $this->birthday;
        $this->passengers[$this->key]['phone_number']   = $this->phone_number;
        $this->passengers[$this->key]['email']          = $this->email;
        $this->passengers[$this->key]['round_trip']     = $this->round_trip;
        $this->passengers[$this->key]['origin']         = $this->origin;
        $this->passengers[$this->key]['destination']    = $this->destination;
        $this->passengers[$this->key]['departure_date'] = $this->departure_date;
        $this->passengers[$this->key]['return_date']    = $this->return_date;
        $this->passengers[$this->key]['baggage']        = $this->baggage;
        $this->passengers[$this->key]['unitValue']      = $this->unitValue;
        $this->totalValue();
        $this->cleanPassenger();
        $this->emit('savedPassengers', $this->passengers);
    }

    public function totalValue(){
        $this->totalValue = 0;
        foreach($this->passengers as $passenger){
            $this->totalValue = $this->totalValue + $passenger['unitValue'];
        }
    }

    public function mount($savedPassengers, $savedTypeOfCurrency){
      // $this->run = $this->searchedUser->run;

      $this->passengers             = array();
      $this->lstPurchaseMechanism   = PurchaseMechanism::all();
      $this->editRF                 = false;
      if(!is_null($savedPassengers)){
        $this->editRF = true;
        $this->savedPassengers = $savedPassengers;
        $this->setSavedPassengers();
      }
      if(!is_null($savedTypeOfCurrency)){
        $this->precision_currency = $savedTypeOfCurrency == 'peso' ? 0 : 2;
      }
    }

    private function setSavedPassengers()
    {
        foreach($this->savedPassengers as $passenger){
            $this->passengers[]=[
                'id'                =>  $passenger->id,
                'passenger_type'    =>  $passenger->passenger_type,
                'run'               =>  $passenger->run,
                'dv'                =>  $passenger->dv,
                'name'              =>  $passenger->name,
                'fathers_family'    =>  $passenger->fathers_family,
                'mothers_family'    =>  $passenger->mothers_family,
                'birthday'          =>  $passenger->birthday,
                'phone_number'      =>  $passenger->phone_number,
                'email'             =>  $passenger->email,
                'round_trip'        =>  $passenger->round_trip,
                'origin'            =>  $passenger->origin,
                'destination'       =>  $passenger->destination,
                'departure_date'    =>  $passenger->departure_date,
                'return_date'       =>  $passenger->return_date,
                'baggage'           =>  $passenger->baggage,
                'unitValue'         =>  $passenger->unit_value
          ];
        
          $this->totalValue();
        }
    }

    public function searchedUser(User $user){
        $this->searchedUser = $user;

        $this->run = $this->searchedUser->id;
        $this->dv = $this->searchedUser->dv;
        $this->name = $this->searchedUser->name;
        $this->fathers_family = $this->searchedUser->fathers_family;
        $this->mothers_family = $this->searchedUser->mothers_family;
        $this->birthday = $this->searchedUser->birthday;
        $this->phone_number = $this->searchedUser->phone_number;
        $this->email = $this->searchedUser->email;
    }

    public function render()
    {
        // $this->dv = User::dvCalculate($this->run);

        $users = User::orderBy('name', 'ASC')->get();

        return view('livewire.request-form.passenger.passenger-request', compact('users'));
    }

    public function savedTypeOfCurrency($typeOfCurrency)
    {
      $this->precision_currency = $typeOfCurrency == 'peso' ? 0 : 2;
    }
}
