<?php

namespace App\Livewire\Requirements;

use Livewire\Component;
use Illuminate\Support\Collection;

use App\Models\Rrhh\OrganizationalUnit;
use App\Models\Establishment;
use App\Models\Rrhh\Authority;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RequirementReceivers extends Component
{
    public $ouRoots;
    public $to_ou_id;
    public $users;
    public $authority;
    public $to_user_id = '';
    public $users_array = [];
    public $message = '';
    public $parte_id;
    public $enCopia = [];
    public $options;

    public function mount()
    {   
        $this->ouRoots = array();
        $establishments_ids = explode(',',env('APP_SS_ESTABLISHMENTS'));
        // dd($establishments_ids);

        // para verificar si usuario logeado es director(a) del servicio
        $auth_user_id = auth()->id();
        $manager_user_id = OrganizationalUnit::where('level',1)
                                            ->where('establishment_id',38)
                                            ->first()
                                            ->currentManager
                                            ->user_id;

        // 18/03: José solicita por orden de Rafael villalobios que pueda visualizar todas las ou
        
        // if($auth_user_id == $manager_user_id && $this->parte_id!=null){
        //     // $ouTree = Establishment::find(38)->getOuTreeWithAliasByLevelAttribute(2);
        //     $ouTree = Establishment::find(38)->getOuTreeWithAliasAttribute();
        //     foreach($ouTree as $key => $outree){
        //         $this->ouRoots[] = array('id'=> $key, 'name' => $outree);
        //     }
        // }
        // else{
        //     foreach($establishments_ids as $establishment) {
        //         $ouTree = Establishment::find($establishment)->ouTreeWithAlias;
        //         foreach($ouTree as $key => $outree){
        //             $this->ouRoots[] = array('id'=> $key, 'name' => $outree);
        //         }
        //     }
        // }

        foreach($establishments_ids as $establishment) {
            $ouTree = Establishment::find($establishment)->ouTreeWithAlias;
            foreach((array) $ouTree as $key => $outree){
                $this->ouRoots[] = array('id'=> $key, 'name' => $outree);
            }
        }

        //$this->to_ou_id = 1;
        $this->to_ou_id = '';
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

        if($this->to_user_id){
            $user = User::find($this->to_user_id);
            array_push($this->users_array, $user);
            array_push($this->enCopia, 0); 
        }else{
            $this->message = "Debe seleccionar un usuario";
            return;
        }  
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

        if($this->to_user_id){
            $user = User::find($this->to_user_id);
            array_push($this->users_array, $user);
            array_push($this->enCopia, 1);
        }else{
            $this->message = "Debe seleccionar un usuario";
            return;
        }
    }

    public function render()
    {
        if($this->to_ou_id){

            //obtiene usuarios de ou
            // $this->to_user_id = null;

            $users = User::where('organizational_unit_id', $this->to_ou_id)
                        ->orderBy('name')
                        ->get();
            if($users->count()>0){
                $this->to_user_id = $users->first()->id;
            }else{
                $this->to_user_id = ''; 
            }
            
            $this->users = $users;
            // dd($this->users_array);

            $authority = null;
            $current_authority = Authority::getAuthorityFromDate($this->to_ou_id,Carbon::now(),'manager');
            if($current_authority) {
                $authority = $current_authority->user;

                if ($authority <> null) {
                    if(!$users->find($authority)) {
                        $users->push($authority);
                    }
                }

                $this->authority = Authority::getAuthorityFromDate($this->to_ou_id,Carbon::now(),'manager');
                if($this->authority!=null){
                    $this->to_user_id = $this->authority->user_id;
                }
            }
        }

        // $users_array siempre esté inicializado como un array
        $this->users_array = $this->users_array ?? [];

        // Existencia del índice antes de acceder a él
        foreach($this->users_array as $key => $item){
            if(!is_null($item) && !$item instanceof Collection) {
                if(isset($this->users_array[$key])){
                    $this->users_array[$key] = User::find($item['id']);
                }
            }
        }
        
        return view('livewire.requirements.requirement-receivers');
    }

    public function remove($key)
    {
        // Verificar si el destinatario a eliminar no está en copia
        if ($this->enCopia[$key] == 0) {
            // Contar cuántos destinatarios que no están en copia quedan
            $remainingDestinatarios = collect($this->enCopia)->filter(function ($value) {
                return $value == 0;
            })->count();

            // Si solo queda un destinatario, impedir la eliminación
            if ($remainingDestinatarios <= 1) {
                $this->message = "Debe haber al menos un destinatario principal.";
                return;
            }
        }

        // Si pasa la validación, eliminar el destinatario
        unset($this->users_array[$key]);
        unset($this->enCopia[$key]);

        // Reindexar los arrays para evitar problemas de índices
        $this->users_array = array_values($this->users_array);
        $this->enCopia = array_values($this->enCopia);
    }

}
