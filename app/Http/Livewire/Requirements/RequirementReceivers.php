<?php

namespace App\Http\Livewire\Requirements;

use Livewire\Component;
use Illuminate\Support\Collection;

use App\Rrhh\OrganizationalUnit;
use App\Rrhh\Authority;
use App\User;
use Carbon\Carbon;

class RequirementReceivers extends Component
{
    public $ouRoots;
    public $to_ou_id;
    public $users;
    public $authority;
    public $to_user_id = '';
    public $user_array = [];
    public $user_cc_array = [];
    public $message = '';
    public $parte_id;

    public function mount()
    {
        $this->ouRoots = null;
        $this->ouRoots = OrganizationalUnit::where('level', 1)->with('establishment',
                                                                     'childs','childs.establishment',
                                                                     'childs.childs','childs.childs.establishment',
                                                                     'childs.childs.childs','childs.childs.childs.establishment',
                                                                     'childs.childs.childs.childs','childs.childs.childs.childs.establishment',
                                                                     'childs.childs.childs.childs.childs','childs.childs.childs.childs.childs.establishment',
                                                                     'childs.childs.childs.childs.childs.childs','childs.childs.childs.childs.childs.childs.establishment')
                                                                     ->get();
        $this->to_ou_id = 1;
        // $this->to_user_id = 17430005;
    }

    public function add()
    {
        // validación
        $this->message = '';
        foreach($this->user_array as $item){
            if($this->to_user_id == $item['id']){
                $this->message = "El usuario ya se ingresó";
                return;
            }
        }
        foreach($this->user_cc_array as $item){
            if($this->to_user_id == $item['id']){
                $this->message = "El usuario ya se ingresó";
                return;
            }
        }

        $user = User::find($this->to_user_id);
        array_push($this->user_array, $user);
    }

    public function add_cc()
    {
        // validaciones
        $this->message = '';
        if(count($this->user_array) == 0){
            $this->message = "Debe existir a lo menos un destinatario para agregar en copia.";
            return;
        }
        foreach($this->user_array as $item){
            if($this->to_user_id == $item['id']){
                $this->message = "El usuario ya se ingresó";
                return;
            }
        }
        foreach($this->user_cc_array as $item){
            if($this->to_user_id == $item['id']){
                $this->message = "El usuario ya se ingresó";
                return;
            }
        }

        $user = User::find($this->to_user_id);
        array_push($this->user_cc_array, $user);
    }

    public function render()
    {
        if($this->to_ou_id){

            $this->ouRoots = OrganizationalUnit::where('level', $this->to_ou_id)->with('establishment',
                                                                                        'childs','childs.establishment',
                                                                                        'childs.childs','childs.childs.establishment',
                                                                                        'childs.childs.childs','childs.childs.childs.establishment',
                                                                                        'childs.childs.childs.childs','childs.childs.childs.childs.establishment',
                                                                                        'childs.childs.childs.childs.childs','childs.childs.childs.childs.childs.establishment',
                                                                                        'childs.childs.childs.childs.childs.childs','childs.childs.childs.childs.childs.childs.establishment')
                                                                                        ->get();

            //obtiene usuarios de ou
            $authority = null;
            $current_authority = Authority::getAuthorityFromDate($this->to_ou_id,Carbon::now(),'manager');
            if($current_authority) {
                $authority = $current_authority->user;
            }

            $users = User::where('organizational_unit_id', $this->to_ou_id)
                        ->orderBy('name')
                        ->get();
            if ($authority <> null) {
                if(!$users->find($authority)) {
                    $users->push($authority);
                }}
            $this->users = $users;
            //selecciona autoridad
            $this->authority = Authority::getAuthorityFromDate($this->to_ou_id,Carbon::now(),'manager');
            if($this->authority!=null){
                $this->to_user_id = $this->authority->user_id;
            }
        }

        // se agrega para que deje todos los objetos del array del tipo User
        foreach($this->user_array as $key => $item){
            if(!$item instanceof Collection) {
                $this->user_array[$key] = User::find($item['id']);  
            }
        }
        foreach($this->user_cc_array as $key => $item){
            if(!$item instanceof Collection) {
                $this->user_cc_array[$key] = User::find($item['id']);  
            }
        }
        
        return view('livewire.requirements.requirement-receivers');
    }
}
