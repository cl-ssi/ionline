<?php

namespace App\Livewire\ServiceRequest;

use Livewire\Component;
use App\Models\Country;
use App\Models\ClCommune;
use App\Models\User;
use App\Models\WebService\Fonasa;

class EmployeeData extends Component
{
    // public User $user;
    public $user_id;
    public $countries;
    public $communes;

    public $name;
    public $dv;
    public $fathers_family;
    public $mothers_family;
    public $country_id;
    public $address;
    public $commune_id;
    public $phone_number;
    public $email;

    public $readonly = "readonly";

    public function getFonasaData(){
        // Se obtienen datos del funcionario desde fonasa
        if(!isset(Fonasa::find($this->user_id."-".$this->dv)->message)){
            $fonasaUser = Fonasa::find($this->user_id."-".$this->dv);

            $this->readonly = "readonly";
            $this->dv = $fonasaUser->dv;
            $this->name = $fonasaUser->name;
            $this->fathers_family = $fonasaUser->fathers_family;
            $this->mothers_family = $fonasaUser->mothers_family;
            $this->address = $fonasaUser->direccion;
            $this->phone_number = $fonasaUser->telefono;
        }  
    }

    public function keydown(){
        if ($this->user_id > 3000000) {
            $user = User::find($this->user_id);
            if($user){
                $this->readonly = "readonly";
                $this->dv = $user->dv;
                $this->name = $user->name;
                $this->fathers_family = $user->fathers_family;
                $this->mothers_family = $user->mothers_family;
                $this->country_id = $user->country_id;
                $this->address = $user->address;
                $this->commune_id = $user->commune_id;
                $this->phone_number = $user->phone_number;
                $this->email = $user->email;
            }else{
                $this->readonly = "";
                $this->dv = "";
                $this->name = "";
                $this->fathers_family = "";
                $this->mothers_family = "";
                $this->country_id = "";
                $this->address = "";
                $this->commune_id = "";
                $this->phone_number = "";
                $this->email = "";
            }
        }
    }

    public function mount(){
        $this->countries = Country::orderBy('name', 'ASC')->get();
        $this->communes = ClCommune::orderBy('name', 'ASC')->get();
    }

    public function render()
    {
        return view('livewire.service-request.employee-data');
    }
    
}
