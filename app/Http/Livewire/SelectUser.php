<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Rrhh\OrganizationalUnit;
use App\Rrhh\Authority;
use App\User;
use Carbon\Carbon;

class SelectUser extends Component
{
    protected $listeners = ['selectUser'];

    public $to_ou_id;
    
    public $users;
    public $authority;
    public $to_user_id = '';
    public $users_array = [];
    public $message = '';
    public $parte_id;
    public $enCopia = [];
 
    public function selectUser($organizational_unit_id)
    {
        $this->to_ou_id = $organizational_unit_id;
    }

    public function add()
    {
        // validación
        $this->message = '';
        foreach($this->users_array as $item){
            if($this->to_user_id == $item['id']){
                $this->message = "El usuario ya se ingresó";
                return;
            }
        }

        $user = User::find($this->to_user_id);
        array_push($this->users_array, $user);
        array_push($this->enCopia, 0);   
    }

    public function add_cc()
    {
        // validaciones
        $this->message = '';
        if(count($this->users_array) == 0){
            $this->message = "Debe existir a lo menos un destinatario para agregar en copia.";
            return;
        }
        foreach($this->users_array as $item){
            if($this->to_user_id == $item['id']){
                $this->message = "El usuario ya se ingresó";
                return;
            }
        }

        $user = User::find($this->to_user_id);
        array_push($this->users_array, $user);
        array_push($this->enCopia, 1);   
    }

    public function render()
    {

        if($this->to_ou_id){

            // $this->ouRoots = OrganizationalUnit::where('level', $this->to_ou_id)->with('establishment',
            //                                                                             'childs','childs.establishment',
            //                                                                             'childs.childs','childs.childs.establishment',
            //                                                                             'childs.childs.childs','childs.childs.childs.establishment',
            //                                                                             'childs.childs.childs.childs','childs.childs.childs.childs.establishment',
            //                                                                             'childs.childs.childs.childs.childs','childs.childs.childs.childs.childs.establishment',
            //                                                                             'childs.childs.childs.childs.childs.childs','childs.childs.childs.childs.childs.childs.establishment')
            //                                                                             ->get();

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
        foreach($this->users_array as $key => $item){
            if(!$item instanceof Collection) {
                $this->users_array[$key] = User::find($item['id']);  
            }
        }

        return view('livewire.select-user');
    }
}
