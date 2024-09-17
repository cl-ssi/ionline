<?php

namespace App\Livewire\Signatures;

use Livewire\Component;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\User;
use App\Models\Establishment;
use App\Models\Rrhh\Authority;
use Livewire\Attributes\On;
use Carbon\Carbon;

class Visators extends Component
{
    public $organizationalUnit = [];
    public $users = [];
    public $inputs = [];
    public $visatorType = [];
    public $i = 0;
    public $user = [];
    public $signature;
    public $requiredVisator = '';
    public $selectedDocumentType;

    public $authority;
    public $ouRoots;
    public $to_ou_id;
    public $users_array = [];
    public $to_user_id = '';
    public $message;
    public $endorse_type;
    public $endorse_type_enabled = "disabled";

    public function updatedEndorseType($value)
    {
        if($value == "No requiere visación") 
            $this->endorse_type_enabled = "disabled"; 
        else{
            $this->endorse_type_enabled = "enabled";
        }
            
    }

    public function mount()
    {
        // obtiene array con datos de visadores
        $this->updatedEndorseType("No requiere visación");

        if($this->signature){
            foreach($this->signature->signaturesFlowVisator as $signatureFlowVisator){
                $user = User::find($signatureFlowVisator->user_id);
                array_push($this->users_array, $user);
                array_push($this->visatorType, $signatureFlowVisator->visator_type ? $signatureFlowVisator->visator_type : $signatureFlowVisator->type);
            }

            $this->selectedDocumentType = $this->signature->type_id;
            $this->endorse_type = $this->signature->endorse_type;
            $this->updatedEndorseType($this->endorse_type);
        }

        // obtiene info de select de ou
        $this->ouRoots = array();
        $establishments_ids = explode(',',env('APP_SS_ESTABLISHMENTS'));

        // para verificar si usuario logeado es director(a) del servicio
        $auth_user_id = auth()->id();
        $manager_user_id = OrganizationalUnit::where('level',1)
                                            ->where('establishment_id',38)
                                            ->first()
                                            ->currentManager
                                            ->user_id;

        foreach($establishments_ids as $establishment) {
            $ouTree = Establishment::find($establishment)->ouTreeWithAlias;
            foreach((array) $ouTree as $key => $outree){
                $this->ouRoots[] = array('id'=> $key, 'name' => $outree);
            }
        }

        $this->to_ou_id = '';
    }

    #[On('documentTypeChanged')]
    public function configureDocumentType($type_id)
    {
        $this->selectedDocumentType = $type_id;
    }

    public function add($i, $visatorType = 'visador')
    {
        if (!$this->to_user_id) {
            // No permitir agregar visador si no se ha seleccionado un funcionario
            $this->message = "Debe seleccionar un funcionario para agregar.";
            return;
        }

        array_push($this->visatorType, $visatorType);

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
    }

    public function remove($i)
    {
        // unset($this->inputs[$i]);
        unset($this->visatorType[$i]);

        unset($this->users_array[$i]);
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

        return view('livewire.signatures.visators');
    }
}
