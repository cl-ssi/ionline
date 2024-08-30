<?php

namespace App\Livewire;

use App\Models\Rrhh\OrganizationalUnit;
use App\Models\Establishment;
use Livewire\Component;

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
     *
     * Todas las opciones:
     *
     * 'organizational_unit_id' => '20',
     * 'establishment_id' => '38',
     * 'selected_id' => 'ou_id',
     * 'emitToListener' => 'nombre del listener',
     * 'readonlyEstablishment' => true or false,
     * 'mobile' => true or false, // no agrupa los inputs
     * 'required' => true or false, // Campos requeridos o no obligatorio de selección del select
     * 'aditional_ous' => [53,2] // array con id's de establecimientos
     */

    public $selected_id = 'organizational_unit_id';
    public $required = true;
    public $aditional_ous = null;
    public $establishment_id;
    public $organizational_unit_id;
    public $readonlyEstablishment = false;
    public $mobile = false;
    public $selectpicker = false;
    public $filter;

    public $emitToListener = null;

    public $establishments;

    public $options;
    public $ous;
    public $ous_backup;

    /**
     * Mount function
     *
     * @return void
     */
    public function mount()
    {
        /*
         * TODO: Esperando que la tabla de establecimientos se pueda filtrar por establecimientos dependientes del ss
         */
        $establishments_ids = explode(',',env('APP_SS_ESTABLISHMENTS'));
        $this->establishments = Establishment::whereIn('id',$establishments_ids)                                            
                                            ->when($this->aditional_ous != null, function ($q)  {
                                                return $q->orWhereIn('id',$this->aditional_ous);
                                            })
                                            ->orderBy('official_name')->get();

        //$this->establishments = Establishment::whereIn('id',[1,34,35,36,38,41])->get();
        //$this->establishments = Establishment::orderBy('official_name', 'asc')->get();

        $this->loadOus();

        // app('debugbar')->log($this->ous);
    }

    /**
     * Load OUS from establishment_id
     *
     * @return void
     */
    public function loadOus()
    {
        $this->options = array();
        $this->ous = array();

        $ous = OrganizationalUnit::query()
            ->select('id', 'level', 'name', 'organizational_unit_id as father_id')
            ->where('establishment_id',$this->establishment_id)
            ->orderBy('name')
            ->get()
            ->toArray();

        if(!empty($ous)) {
            $this->buildTree($ous);
        }

        /**
         * Necesito formar este array poque sino livewire me los ordena por key los options y me quedan desordenados
         */
        foreach($this->options as $id => $option) {
            $this->ous[] = ['id' => $id, 'name' => $option];
        }

        /**
         * Guardo una copia para restablecer el listado cada vez que se filtra
         */
        $this->ous_backup = $this->ous;

    }

    public function render()
    {
        /**
         * Si se seteo por parametro un listener, entonces le enviamos a ese listener la ou_id
         */
        if(isset($this->emitToListener)) {
            $this->dispatch($this->emitToListener, organizationalUnitId: $this->organizational_unit_id);
        }

        /**
         * Restaura las ous en base a la copia
         */
        $this->ous = $this->ous_backup;

        /**
         * Filtra el listado
         */
        if($this->filter) {
            $this->ous = array_filter(
                $this->ous,
                fn($haystack) => str_contains(
                    strtolower($this->stripAccents($haystack['name'])), strtolower($this->stripAccents($this->filter))
                )
            );
        }

        return view('livewire.select-organizational-unit');
    }

    /**
     * Remove accents
     *
     * @param  string  $str
     * @return string
     */
    function stripAccents($str)
    {
        return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    }

    /**
     * Build the ous tree
     *
     * @param  array  $flatList - a flat list of tree nodes; a node is an array with keys: id, parentID, name.
     * @return void
     */
    function buildTree(array $flatList)
    {
        $grouped = [];
        foreach ($flatList as $node) {
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
