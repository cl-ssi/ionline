<?php

namespace App\Http\Livewire\Requirements;

use Livewire\Component;
use Illuminate\Support\Collection;

use App\Rrhh\OrganizationalUnit;
use App\Models\Establishment;
use App\Rrhh\Authority;
use App\User;
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
        // dd(Authority::where('id',1));
        
        $this->ouRoots = array();
        $establishments_ids = explode(',',env('APP_SS_ESTABLISHMENTS'));

        // para verificar si usuario logeado es director(a) del servicio
        $auth_user_id = Auth::user()->id;
        $manager_user_id = OrganizationalUnit::where('level',1)
                                            // ->whereIn('establishment_id',$establishments_ids)
                                            ->where('establishment_id',38)
                                            ->first()
                                            ->currentManager
                                            ->user_id;

        if($auth_user_id == $manager_user_id && $this->parte_id!=null){
            $ouTree = Establishment::find(38)->getOuTreeWithAliasByLevelAttribute(2);
            foreach($ouTree as $key => $outree){
                $this->ouRoots[] = array('id'=> $key, 'name' => $outree);
            }
        }
        else{
            foreach($establishments_ids as $establishment) {
                $ouTree = Establishment::find($establishment)->ouTreeWithAlias;
                foreach($ouTree as $key => $outree){
                    $this->ouRoots[] = array('id'=> $key, 'name' => $outree);
                }
            }
        }

        $this->to_ou_id = 1;
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

        // se agrega para que deje todos los objetos del array del tipo User
        foreach($this->users_array as $key => $item){
            if(!$item instanceof Collection) {
                if(array_key_exists($key,$this->users_array)){
                    $this->users_array[$key] = User::find($item['id']);
                }
                  
            }
        }
        
        return view('livewire.requirements.requirement-receivers');
    }

    public function remove($key)
    {
        unset($this->users_array[$key]);
        unset($this->enCopia[$key]);
    }


    // function stripAccents($str) {
    //     return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    // }

    // /**
    //  * @param array $flatList - a flat list of tree nodes; a node is an array with keys: id, parentID, name.
    //  */
    // function buildTree(array $flatList)
    // {
    //     $grouped = [];
    //     foreach ($flatList as $node){
    //         if(!$node['father_id']) {
    //             $node['father_id'] = 0;
    //         }
    //         $grouped[$node['father_id']][] = $node;
    //     }

    //     $fnBuilder = function($siblings) use (&$fnBuilder, $grouped) {
    //         foreach ($siblings as $k => $sibling) {
    //             $id = $sibling['id'];
    //             // $this->options[$id] = str_repeat("- ", $sibling['level']).OrganizationalUnit::find($sibling['id'])->establishment->alias.'-'.$sibling['name'];
    //             $this->options[$id] = str_repeat("- ", $sibling['level']).$sibling['name'];
    //             if(isset($grouped[$id])) {
    //                 $sibling['children'] = $fnBuilder($grouped[$id]);
    //             }
    //             $siblings[$k] = $sibling;
    //         }
    //         return $siblings;
    //     };

    //     return $fnBuilder($grouped[0]);
    // }
}
