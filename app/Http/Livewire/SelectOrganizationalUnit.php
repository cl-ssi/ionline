<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Rrhh\OrganizationalUnit;

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

    public $ouRoot;
    public $ouRoots;
    public $establishment_id;
    public $selected_id = 'organizational_unit_id';

    public $organizational_unit_id;

    public function render()
    {
        /** Single establishment */
        if($this->establishment_id)
        {
            // $ous = OrganizationalUnit::where('establishment_id', $this->establishment_id)->orderByDesc('level')->get();
            // $max_level = $ous->first()->level;

            // for($i = $max_level; $i >= 1; $i--) {
            //     foreach($ous->where('level',$i) as $ou) {
            //         // app('debugbar')->log($ou);
            //         if($ou->level != 1) {
            //             $tree[$ou->organizational_unit_id] = ['id'=>$ou->id, 'name'=>$ou->name, 'level'=> $ou->level];
            //         }
            //     }
            // }

            // foreach($ous as $ou) {

            //     // if($ou->level == 1) {
            //     //     $tree[$ou->id]['name'] = $ou->name; 
            //     // }
            //     // else {
            //     //     if($ou->level)
            //     //     $tree[$ou->organizational_unit_id]['childs'][$ou->id]['name'] = $ou->name; 
            //     // }
            // }

            // app('debugbar')->log($tree);

            $this->ouRoot = OrganizationalUnit::where('level',1)->where('establishment_id', $this->establishment_id)->first();
            if($this->ouRoot)
            {
                return view('livewire.select-organizational-unit');
            }
            else{
                dd('No se econtró una unidad organizacional de nivel 1 para el establecimiento id: '.$this->establishment_id);
            }
        }
        /** Multi establishment */
        else 
        {
            $this->ouRoots = OrganizationalUnit::where('level',1)->get();
            return view('livewire.select-organizational-unit');
        }
    }
}
