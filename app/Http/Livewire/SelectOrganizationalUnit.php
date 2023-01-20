<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Rrhh\OrganizationalUnit;
use App\Models\Establishment;

class SelectOrganizationalUnit extends Component
{
    /** Uso: 
     * @livewire('select-organizational-unit')
     * 
     * Se puede definir el nombre del campo que almacenará el id de unidad organizacional
     * @livewire('select-organizational-unit', ['selected_id' => 'ou_id'])
     * 
     * Se puede especificar un único establecimiento para listar sus ous (ej: Servicio de salud id = 38)
     * @livewire('select-organizational-unit', ['establishment_id' => '38'])
     *
     * Si necesitas que aparezca precargada la unidad organizacional
     * @livewire('select-organizational-unit', ['establishment_id' => '38', 'organizational_unit_id' => '20'])
     */

    public $selected_id = 'organizational_unit_id';
    public $establishment_id;
    public $organizational_unit_id;
    public $filter;

    public $establishments;

    public $options;
    public $ous;

    /**
    * mount
    */
    public function mount()
    {
        /* TODO: Esperando que la tabla de establecimientos se pueda filtrar por establecimientos dependientes del ss */
        $this->establishments = Establishment::whereIn('id',[1,38,41])->get();
        $this->loadOus();
    }

    /**
    * Load OUS from establishment_id
    */
    public function loadOus()
    {
        $this->options = array();

        $ous = OrganizationalUnit::select('id','level','name','organizational_unit_id as father_id')
            ->where('establishment_id',$this->establishment_id)
            // ->orderBy('name')
            ->get()
            ->toArray();
        if(!empty($ous)) {
            $this->buildTree($ous, 'father_id', 'id');
        }
    }

    public function render()
    {
        if($this->filter) {
            $options = array_filter(
                $this->options, 
                fn($haystack) => str_contains(
                    strtolower($haystack), strtolower($this->filter)
                )
            );
        }
        else {
            $options = $this->options;
        }

        /** Vacía el array ou antes de formar una con pares de valores id,name */
        /** Necesito formar este array poque sino livewire me los ordena por key los options y me quedan desordenados */
        $this->ous = array();

        foreach($options as $id => $option) {
            $this->ous[] = array('id'=> $id, 'name' => $option);
        }

        // app('debugbar')->log($this->ous);

        return view('livewire.select-organizational-unit');
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
