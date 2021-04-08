<?php

namespace App\Http\Livewire\RequestForm\Passage;

use Livewire\Component;

class TicketRequest extends Component
{
    public $edit, $tittle;
    public $items, $key;
    public $program, $justification, $run, $dv, $names, $fathersName, $mothersName, $birthDay, $telephoneNumber, $email, $trip, $origin, $destiny, $departureDate, $fromDate, $baggage;

    protected $rules = [
        'run'             =>  'required|integer|min:1',
        'dv'              =>  'required|numeric|min:1',
        'fathersName'     =>  'required',
        'mothersName'     =>  'required',
        'birthDay'        =>  'required',
        'email'           =>  'required|email',
        'telephoneNumber' =>  'required|integer',
        'trip'            =>  'required',
        'origin'          =>  'required',
        'destiny'         =>  'required',
        'departureDate'   =>  'required',
        'fromDate'        =>  'required',
        'baggage'         =>  'required',
    ];

    protected $messages = [
        'run.required'              => 'Campo Run es obligatorio.',
        'run.integer'               => 'Run debe ser número entero sin puntos ni dígito verificador.',
        'run.min'                   => 'Run debe ser mayor o igual a 1.',
        'dv.required'               => 'Campo DV es obligatorio.',
        'dv.numeric'                => 'DV debe ser numérico.',
        'dv.min'                    => 'DV debe ser mayor o igual a 0.1.',
        'fathersName.required'      => 'Campo Apellido Paterno es requerido.',
        'mothersName.required'      => 'Campo Apellido Materno es requerido',
        'birthDay.required'         => 'Campo Fecha de Nacimiento es requerido.',
        'email.required'            => 'E-mail es requerido.',
        'email.email'               => 'E-mail debe contener formato adecuado.',
        'telephoneNumber.required'  => 'Campo Teléfono es obligatorio.',
        'telephoneNumber.integer'   => 'Campo Teléfono debe ser numérico entero sin puntos.',
        'trip.required'             => 'Seleccione un tipo de viaje.',
        'origin.required'           => 'Campo Origen es requerido.',
        'destiny.required'          => 'Campo Destino es requerido.',
        'departureDate.required'    => 'Campo Fecha de Ida es requerido.',
        'fromDate.required'         => 'Campo Fecha de Regreso es requerido.',
        'baggage.required'          => 'Seleccione tipo de equipaje.',
    ];

    public function mount(){
      $this->items                  = array();
      $this->tittle                 = "Agregar Ticket";
      $this->edit                   = false;
    }

    public function addTicket(){
      $this->validate();
      $this->items[]=[
            'run'                   => $this->run,
            'dv'                    => $this->dv,
            'names'                 => $this->names,
            'fathersName'           => $this->fathersName,
            'mothersName'           => $this->mothersName,
            'birthDay'              => $this->birthDay,
            'telephoneNumber'       => $this->telephoneNumber,
            'email'                 => $this->email,
            'trip'                  => $this->trip,
            'origin'                => $this->origin,
            'destiny'               => $this->destiny,
            'departureDate'         => $this->departureDate,
            'fromDate'              => $this->fromDate,
            'baggage'               => $this->baggage,
    ];
      $this->cleanTicket();
    }

    public function deleteTicket($key){
      unset($this->items[$key]);
      $this->cleanTicket();
    }

    public function editTicket($key){
      $this->resetErrorBag();
      $this->tittle                       =   "Editar Ticket Nro ". ($key+1);
      $this->edit                         =   true;
      $this->run                          =   $this->items[$key]['run'];
      $this->dv                           =   $this->items[$key]['dv'];
      $this->names                        =   $this->items[$key]['names'];
      $this->fathersName                  =   $this->items[$key]['fathersName'];
      $this->mothersName                  =   $this->items[$key]['mothersName'];
      $this->birthDay                     =   $this->items[$key]['birthDay'];
      $this->telephoneNumber              =   $this->items[$key]['telephoneNumber'];
      $this->email                        =   $this->items[$key]['email'];
      $this->trip                         =   $this->items[$key]['trip'];
      $this->origin                       =   $this->items[$key]['origin'];
      $this->destiny                      =   $this->items[$key]['destiny'];
      $this->departureDate                =   $this->items[$key]['departureDate'];
      $this->fromDate                     =   $this->items[$key]['fromDate'];
      $this->baggage                      =   $this->items[$key]['baggage'];
      $this->key                          =   $key;
    }

    public function updateTicket(){
      $this->validate();
      $this->items[$this->key]['run']               =     $this->run;
      $this->items[$this->key]['dv']                =     $this->dv;
      $this->items[$this->key]['names']             =     $this->names;
      $this->items[$this->key]['fathersName']       =     $this->fathersName;
      $this->items[$this->key]['mothersName']       =     $this->mothersName;
      $this->items[$this->key]['birthDay']          =     $this->birthDay;
      $this->items[$this->key]['telephoneNumber']   =     $this->telephoneNumber;
      $this->items[$this->key]['email']             =     $this->email;
      $this->items[$this->key]['trip']              =     $this->trip;
      $this->items[$this->key]['origin']            =     $this->origin;
      $this->items[$this->key]['destiny']           =     $this->destiny;
      $this->items[$this->key]['departureDate']     =     $this->departureDate;
      $this->items[$this->key]['fromDate']          =     $this->fromDate;
      $this->items[$this->key]['baggage']           =     $this->baggage;
      $this->cleanTicket();
    }

    public function cleanTicket(){
      $this->tittle = "Agregar Ticket";
      $this->edit  = false;
      $this->resetErrorBag();
      $this->run=$this->dv=$this->names=$this->fathersName=$this->mothersName=$this->birthDay=$this->telephoneNumber=$this->email=$this->trip=
      $this->origin=$this->destiny=$this->departureDate=$this->fromDate=$this->baggage="";
    }

    public function saveTicketRequest(){
      $this->validate(
          [
            'program'                      =>  'required',
            'justification'                =>  'required',
            'items'                        =>  'required'
          ],
          [
            'program.required'             =>  'Ingrese un Programa Asociado.',
            'justification.required'       =>  'Campo Justificación en Breve, es requerido.',
            'items.required'               =>  'Debe agregar al menos un Ticket.'
          ],
        );
      //Codigo para Serialización...
    }

    public function render()
    {
        return view('livewire.request-form.passage.ticket-request');
    }
}
