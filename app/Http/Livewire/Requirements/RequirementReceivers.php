<?php

namespace App\Http\Livewire\Requirements;

use Livewire\Component;
use Illuminate\Support\Collection;

use App\Rrhh\OrganizationalUnit;
use App\Models\Establishment;
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
    public $users_array = [];
    public $message = '';
    public $parte_id;
    public $enCopia = [];
    public $options;

    public function mount()
    {
        // $this->ouRoots = null;
        // $this->ouRoots = OrganizationalUnit::where('level', 1)->with('establishment',
        //                                                              'childs','childs.establishment',
        //                                                              'childs.childs','childs.childs.establishment',
        //                                                              'childs.childs.childs','childs.childs.childs.establishment',
        //                                                              'childs.childs.childs.childs','childs.childs.childs.childs.establishment',
        //                                                              'childs.childs.childs.childs.childs','childs.childs.childs.childs.childs.establishment',
        //                                                              'childs.childs.childs.childs.childs.childs','childs.childs.childs.childs.childs.childs.establishment')
        //                                                              ->get();
        // $this->to_ou_id = 1;




        // $this->options = array();
        // $this->ouRoots = array();
        
        // $ouRoots = OrganizationalUnit::select('id','level','name','organizational_unit_id as father_id')
        //     ->whereIn('establishment_id',explode(',',env('APP_SS_ESTABLISHMENTS')))
        //     ->orderBy('name')
        //     ->get()
        //     ->toArray();
        // if(!empty($ouRoots)) {
        //     $this->buildTree($ouRoots, 'father_id', 'id');
        // }

        // /** Necesito formar este array poque sino livewire me los ordena por key los options y me quedan desordenados */
        // foreach($this->options as $id => $option) {
        //     dd($option);
        //     $this->ouRoots[] = array('id'=> $id, 'name' => $option);
        // }

        $this->ouRoots = array();
        $establishments_ids = explode(',',env('APP_SS_ESTABLISHMENTS'));
        foreach($establishments_ids as $establishment){
            foreach(Establishment::find($establishment)->outTreeWithEstablishmentName as $key => $outree){
                $this->ouRoots[] = array('id'=> $key, 'name' => $outree);
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
        
        return view('livewire.requirements.requirement-receivers');
    }

    function stripAccents($str) {
        return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    }

    /**
     * @param array $flatList - a flat list of tree nodes; a node is an array with keys: id, parentID, name.
     */
    function buildTree(array $flatList)
    {
        $grouped = [];
        foreach ($flatList as $node){
            if(!$node['father_id']) {
                $node['father_id'] = 0;
            }
            $grouped[$node['father_id']][] = $node;
        }

        $fnBuilder = function($siblings) use (&$fnBuilder, $grouped) {
            foreach ($siblings as $k => $sibling) {
                $id = $sibling['id'];
                // $this->options[$id] = str_repeat("- ", $sibling['level']).OrganizationalUnit::find($sibling['id'])->establishment->alias.'-'.$sibling['name'];
                $this->options[$id] = str_repeat("- ", $sibling['level']).$sibling['name'];
                if(isset($grouped[$id])) {
                    $sibling['children'] = $fnBuilder($grouped[$id]);
                }
                $siblings[$k] = $sibling;
            }
            return $siblings;
        };

        return $fnBuilder($grouped[0]);
    }
}
