<?php

namespace App\Livewire\RequestForm\Passenger;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\User;
use App\Models\Parameters\PurchaseMechanism;

class PassengerRequest extends Component
{
    public $edit, $tittle;

    /* Mantenedores */
    public $lstPurchaseMechanism;

    public $searchedPassenger;

    public $passengerType, $inputsInternalPassengers = "readonly", $run, $dv, 
            $document_type, $document_number, $name, $fathers_family, $mothers_family,
            $birthday, $phone_number, $email, $round_trip, $origin, $destination,
            $departure_date, $return_date, $baggage, $unitValue;

    public $roundTripValue;

    public $passengers, $key, $editRF, $savedPassengers, $deletedPassengers;

    public $totalValue = 0 , $precision_currency;

    //Para Validar

    protected $messages = [
        'passengerType.required'    => 'Campo Tipo de Pasajero es obligatorio.',
        'run.required'              => 'Campo Run es obligatorio.',
        'run.integer'               => 'Run debe ser número entero sin puntos ni dígito verificador.',
        'run.min'                   => 'Run debe ser mayor o igual a 1.',
        'dv.required'               => 'Campo DV es obligatorio.',
        'document_type.required'    => 'Campo Tipo Documento es obligatorio.',
        'document_number.required'  => 'Campo Número Documento es obligatorio.',
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
        'destination.required'      => 'Campo Destino es requerido.',
        'departure_date.required'   => 'Campo Fecha de Ida es requerido.',
        'return_date.required'      => 'Campo Fecha de Regreso es requerido.',
        'baggage.required'          => 'Seleccione tipo de equipaje.',
        'unitValue.required'        => 'Debe ingresar el valor del pasaje.',
    ];

    public function addPassenger(){
        $rules = [
            'passengerType'  => 'required',
            'name'           => 'required',
            'fathers_family' => 'required',
            'birthday'       => 'required',
            'phone_number'   => 'required|integer',
            'email'          => 'required|email',
            'round_trip'     => 'required',
            'origin'         => 'required',
            'destination'    => 'required',
            'departure_date' => 'required',
            'baggage'        => 'required',
            'unitValue'      => 'required',
        ];
    
        if ($this->passengerType == "internal") {
            $rules['run'] = 'required|integer|min:1';
            $rules['dv'] = 'required';
            $rules['mothers_family'] = 'required';
        }
    
        if ($this->passengerType == "external") {
            $rules['document_type'] = 'required';
            $rules['document_number'] = 'required';
        }
    
        if ($this->round_trip != 'one-way only') {
            $rules['return_date'] = 'required';
        }
    
        $validatedData = $this->validate($rules);

        // $this->validate();
        $this->passengers[]=[
              'id'                  => null,
              'passenger_type'      => $this->passengerType,
              'run'                 => ($this->passengerType == "internal") ? $this->run : null,
              'dv'                  => ($this->passengerType == "internal") ? $this->dv : null,
              'document_type'       => ($this->passengerType == "external") ? $this->document_type : null,
              'document_number'     => ($this->passengerType == "external") ? $this->document_number : null,
              'name'                =>  $this->name,
              'fathers_family'      =>  $this->fathers_family,
              'mothers_family'      =>  $this->mothers_family,
              'birthday'            =>  $this->birthday,
              'phone_number'        =>  $this->phone_number,
              'email'               =>  $this->email,
              'round_trip'          =>  $this->round_trip,
              'origin'              =>  $this->origin,
              'destination'         =>  $this->destination,
              'departure_date'      =>  $this->departure_date,
              'return_date'         =>  $this->return_date,
              'baggage'             =>  $this->baggage,
              'unitValue'           =>  $this->unitValue
        ];
        $this->totalValue();
        $this->cleanPassenger();

        $this->dispatch('savedPassengers', passengers: $this->passengers);
    }

    public function cleanPassenger()
    {
        $this->edit  = false;
        $this->resetErrorBag();
        $this->passengerType=$this->document_type=$this->document_number=$this->run=$this->run=$this->dv=$this->name=
        $this->fathers_family=$this->mothers_family=$this->birthday=$this->phone_number=$this->email=
        $this->round_trip=$this->origin=$this->destination=$this->departure_date=
        $this->return_date=$this->baggage=$this->unitValue = "";
    }

    public function deletePassenger($key)
    {
        if($this->editRF && array_key_exists('id',$this->passengers[$key])){
            $this->deletedPassengers[]=$this->passengers[$key]['id'];
            $this->dispatch('deletedPassengers', $this->deletedPassengers);
        }
        unset($this->passengers[$key]);
        $this->totalValue();
        $this->cleanPassenger();
        $this->dispatch('savedPassengers', passengers: $this->passengers);
    }

    public function editPassenger($key){
        $this->resetErrorBag();

        if($this->passengers[$key]['passenger_type'] == 'internal' || $this->passengers[$key]['passenger_type'] == null){
            $this->passengerType = 'internal';
            $this->inputsInternalPassengers = 'readonly';
        }
        else{
            $this->passengerType = 'external';
            $this->inputsInternalPassengers = null;
        }

        $this->edit             = true;

        $this->document_type    = $this->passengers[$key]['document_type'];
        $this->document_number  = $this->passengers[$key]['document_number'];
        $this->run              = $this->passengers[$key]['run'];
        $this->dv               = $this->passengers[$key]['dv'];
        $this->name             = $this->passengers[$key]['name'];
        $this->fathers_family   = $this->passengers[$key]['fathers_family'];
        $this->mothers_family   = $this->passengers[$key]['mothers_family'];
        $this->birthday         = $this->passengers[$key]['birthday'];
        $this->phone_number     = $this->passengers[$key]['phone_number'];
        $this->email            = $this->passengers[$key]['email'];
        $this->round_trip       = $this->passengers[$key]['round_trip'];
        $this->origin           = $this->passengers[$key]['origin'];
        $this->destination      = $this->passengers[$key]['destination'];
        $this->departure_date   = $this->passengers[$key]['departure_date'];
        $this->return_date      = $this->passengers[$key]['return_date'];
        $this->baggage          = $this->passengers[$key]['baggage'];
        $this->unitValue        = $this->passengers[$key]['unitValue'];

        $this->key              = $key;
    }

    public function updatePassenger(){
        /*
        $validatedData = $this->validate([
            ($this->passengerType == "internal") ? 'run' : 'run'    => ($this->passengerType == "internal") ? 'required|integer|min:1' : '',
            ($this->passengerType == "internal") ? 'dv' : 'dv'      => ($this->passengerType == "internal") ? 'required' : '',
            ($this->passengerType == "external") ? 'document_type' : 'document_type'        => ($this->passengerType == "external") ? 'required' : '',
            ($this->passengerType == "external") ? 'document_number' : 'document_number'    => ($this->passengerType == "external") ? 'required' : '',
            'name'              =>  'required',
            'fathers_family'    =>  'required',
            ($this->passengerType == "internal") ? 'mothers_family' : 'mothers_family' =>  ($this->passengerType == "internal") ? 'required' : null,
            'birthday'          =>  'required',
            'phone_number'      =>  'required|integer',
            'email'             =>  'required|email',
            'round_trip'        =>  'required',
            'origin'            =>  'required',
            'destination'       =>  'required',
            'departure_date'    =>  'required',
            'return_date'       =>  'exclude_if:round_trip,one-way only|required',
            'baggage'           =>  'required',
            'unitValue'         =>  'required',
        ]);
        */

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
        $this->dispatch('savedPassengers', passengers: $this->passengers);
    }

    public function totalValue()
    {
        $this->totalValue = 0;
        foreach($this->passengers as $passenger){
            $this->totalValue = $this->totalValue + $passenger['unitValue'];
        }
    }

    public function mount($savedPassengers, $savedTypeOfCurrency)
    {
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
                'document_type'     =>  $passenger->document_type,
                'document_number'   =>  $passenger->document_number,
                'run'               =>  $passenger->run,
                'dv'                =>  $passenger->dv,
                'name'              =>  $passenger->name,
                'fathers_family'    =>  $passenger->fathers_family,
                'mothers_family'    =>  $passenger->mothers_family,
                'birthday'          =>  $passenger->birthday->format('Y-m-d'),
                'phone_number'      =>  $passenger->phone_number,
                'email'             =>  $passenger->email,
                'round_trip'        =>  $passenger->round_trip,
                'origin'            =>  $passenger->origin,
                'destination'       =>  $passenger->destination,
                'departure_date'    =>  $passenger->departure_date->format('Y-m-d\TH:i'),
                'return_date'       =>  $passenger->return_date ? $passenger->return_date->format('Y-m-d\TH:i') : null,
                'baggage'           =>  $passenger->baggage,
                'unitValue'         =>  $passenger->unit_value
          ];
        
          $this->totalValue();
        }
    }

    #[On('searchedPassenger')]
    public function searchedPassenger(User $user)
    {
        $this->searchedPassenger = $user;

        $this->run = $this->searchedPassenger->id;
        $this->dv = $this->searchedPassenger->dv;
        $this->name = $this->searchedPassenger->name;
        $this->fathers_family = $this->searchedPassenger->fathers_family;
        $this->mothers_family = $this->searchedPassenger->mothers_family;
        $this->birthday = $this->searchedPassenger->birthday ? $this->searchedPassenger->birthday->format('Y-m-d') : null;
        $this->phone_number = $this->searchedPassenger->phone_number;
        $this->email = $this->searchedPassenger->email;
    }

    public function render()
    {
        $users = User::orderBy('name', 'ASC')->get();
        return view('livewire.request-form.passenger.passenger-request', compact('users'));
    }

    #[On('savedTypeOfCurrency')]
    public function savedTypeOfCurrency($typeOfCurrency)
    {
      $this->precision_currency = $typeOfCurrency == 'peso' ? 0 : 2;
    }

    public function updatedPassengerType($PassengerTypeValue){
        if($PassengerTypeValue == "external"){
            $this->inputsInternalPassengers = null;

            $this->run = null;
            $this->dv = null;
            $this->name = null;
            $this->fathers_family = null;
            $this->mothers_family = null;
            $this->birthday = null;
            $this->phone_number = null;
            $this->email = null;
        }
        else{
            $this->inputsInternalPassengers = "readonly";
            
            $this->run = null;
            $this->dv = null;
            $this->name = null;
            $this->fathers_family = null;
            $this->mothers_family = null;
            $this->birthday = null;
            $this->phone_number = null;
            $this->email = null;
        }
    }
}
