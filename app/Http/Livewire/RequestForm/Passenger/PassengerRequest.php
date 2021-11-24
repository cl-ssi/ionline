<?php

namespace App\Http\Livewire\RequestForm\Passenger;

use Livewire\Component;
use App\User;
use App\Models\Parameters\PurchaseMechanism;

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
          $departure_date, $return_date, $baggage;

    public $passengers, $key;

    protected $listeners = ['searchedUser'];

    //Para Validar

    protected $rules = [
        'passengerType'     =>  'required',
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
        'destination'       =>  'required',
        'departure_date'    =>  'required',
        'return_date'       =>  'required',
        'baggage'           =>  'required',

    ];

    protected $messages = [
        'passengerType.required'    => 'Seleccione tipo de Pasajero.',
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
        'destination.required'      => 'Campo Destino es requerido.',
        'departure_date.required'   => 'Campo Fecha de Ida es requerido.',
        'return_date.required'      => 'Campo Fecha de Regreso es requerido.',
        'baggage.required'          => 'Seleccione tipo de equipaje.',
    ];

    public function addPassenger(){
        $this->validate();
        $this->items[]=[
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
              'baggage'           =>  $this->baggage
        ];
        //$this->totalForm();
        //$this->cancelRequestService();
    }

    public function cleanPassenger(){
      //$this->tittle = "Agregar Ticket";
      $this->edit  = false;
      $this->resetErrorBag();
      $this->run=$this->dv=$this->name=$this->fathers_family=
        $this->mothers_family=$this->birthday=$this->phone_number=$this->email=
        $this->round_trip=$this->origin=$this->destination=$this->departure_date=
        $this->departure_date=$this->return_date=$this->baggage = "";
    }

    public function saveRequestForm(){

    }

    public function mount(){
      // $this->run = $this->searchedUser->run;

      $this->items                  = array();
      $this->lstPurchaseMechanism   = PurchaseMechanism::all();
      // $this->tittle                 = "Agregar Ticket";
      // $this->edit                   = false;
      // $this->dv                     = "";
      // //$this->run                    = "";
      // if(old('run')) {
      //     $this->run = old('run');
      // }
    }

    // public function addTicket(){
    //
    // //   $this->validate();
    // //   $this->items[]=[
    // //         'run'                   => $this->run,
    // //         'dv'                    => $this->dv,
    // //         'names'                 => $this->names,
    // //         'fathersName'           => $this->fathersName,
    // //         'mothersName'           => $this->mothersName,
    // //         'birthDay'              => $this->birthDay,
    // //         'telephoneNumber'       => $this->telephoneNumber,
    // //         'email'                 => $this->email,
    // //         'trip'                  => $this->trip,
    // //         'origin'                => $this->origin,
    // //         'destiny'               => $this->destiny,
    // //         'departureDate'         => $this->departureDate,
    // //         'fromDate'              => $this->fromDate,
    // //         'baggage'               => $this->baggage,
    // //         'passengerType'         => $this->passengerType,
    // // ];
    //   $this->cleanTicket();
    // }

    // public function deletePassenger($key){
    //   unset($this->items[$key]);
    //   //$this->cleanTicket();
    // }

    // public function editTicket($key){
    //   $this->resetErrorBag();
    //   $this->tittle                       =   "Editar Ticket Nro ". ($key+1);
    //   $this->edit                         =   true;
    //   $this->run                          =   $this->items[$key]['run'];
    //   $this->dv                           =   $this->items[$key]['dv'];
    //   $this->names                        =   $this->items[$key]['names'];
    //   $this->fathersName                  =   $this->items[$key]['fathersName'];
    //   $this->mothersName                  =   $this->items[$key]['mothersName'];
    //   $this->birthDay                     =   $this->items[$key]['birthDay'];
    //   $this->telephoneNumber              =   $this->items[$key]['telephoneNumber'];
    //   $this->email                        =   $this->items[$key]['email'];
    //   $this->trip                         =   $this->items[$key]['trip'];
    //   $this->origin                       =   $this->items[$key]['origin'];
    //   $this->destiny                      =   $this->items[$key]['destiny'];
    //   $this->departureDate                =   $this->items[$key]['departureDate'];
    //   $this->fromDate                     =   $this->items[$key]['fromDate'];
    //   $this->baggage                      =   $this->items[$key]['baggage'];
    //   $this->passengerType                =   $this->items[$key]['passengerType'];
    //   $this->key                          =   $key;
    // }

    // public function updateTicket(){
    //   $this->validate();
    //   // $this->items[$this->key]['run']               =     $this->run;
    //   // $this->items[$this->key]['dv']                =     $this->dv;
    //   // $this->items[$this->key]['names']             =     $this->names;
    //   // $this->items[$this->key]['fathersName']       =     $this->fathersName;
    //   // $this->items[$this->key]['mothersName']       =     $this->mothersName;
    //   // $this->items[$this->key]['birthDay']          =     $this->birthDay;
    //   // $this->items[$this->key]['telephoneNumber']   =     $this->telephoneNumber;
    //   // $this->items[$this->key]['email']             =     $this->email;
    //   // $this->items[$this->key]['trip']              =     $this->trip;
    //   // $this->items[$this->key]['origin']            =     $this->origin;
    //   // $this->items[$this->key]['destiny']           =     $this->destiny;
    //   // $this->items[$this->key]['departureDate']     =     $this->departureDate;
    //   // $this->items[$this->key]['fromDate']          =     $this->fromDate;
    //   // $this->items[$this->key]['baggage']           =     $this->baggage;
    //   // $this->items[$this->key]['passengerType']     =     $this->passengerType;
    //   $this->cleanTicket();
    // }

    // public function cleanTicket(){
    //   $this->tittle = "Agregar Ticket";
    //   $this->edit  = false;
    //   $this->resetErrorBag();
    //   $this->run=$this->dv=$this->names=$this->fathersName=$this->mothersName=$this->birthDay=$this->telephoneNumber=$this->email=$this->trip=
    //   $this->origin=$this->destiny=$this->departureDate=$this->fromDate=$this->passengerType=$this->baggage="";
    // }

    // public function updatedpassengerType($passenger_type_id){
    //     // dd('hola');
    //     // //$this->professions = ProfessionManage::where('profile_manage_id', $profile_id)->get();
    //     //
    //     // if($profile_id == 3 or $profile_id == 4){
    //     //     $this->selectstate = '';
    //     // }
    //     // else{
    //     //     $this->selectstate = 'disabled';
    //     // }
    // }

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
}
