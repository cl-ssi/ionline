<?php

namespace App\Livewire\Parameters\Parameter;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\User;
use App\Models\Parameters\Parameter;

class SingleManager extends Component
{
    /** Uso:
     *  
     * @livewire('parameters.parameter.single-manager',[
     *      'module' => 'drugs',
     *      'parameterName' => 'Jefe',
     *      'type' => 'user', // user or text
     *      'parameterDescription' => 'bla bla bla'
     * ])
     * 
     * Type puede ser de tipo User o Value
     *
     * Obtener el valor de un parametro
     * $value = Parameter::get('module','parameter','establishment_id' [opcional]);
     */

    public $module;
    public $parameterName;
    public $parameterDescription;
    public $type;
    
    public $save = false;

    public $user;

    public $parameter;

    public function mount($module, $parameterName, $type, $parameterDescription = null)
    {
        $this->parameter = Parameter::firstOrCreate([
            'module' => $module,
            'parameter' => $parameterName,
            'establishment_id' => auth()->user()->organizationalUnit->establishment->id
        ],[
            'description' => $parameterDescription,
        ]);

        $this->type = $type;

        if($type == 'user'){
            $this->user = User::find($this->parameter->value);
        }


    }

    /** Listener del componente de seleccionar usuarios */
    #[On('userSelected')]
    public function userSelected($userId)
    {
        $this->parameter->value = $userId;
    }

    protected $rules = [
        'parameter.module' => 'required',
        'parameter.parameter' => 'required',
        'parameter.value' => 'required',
        'parameter.description' => 'nullable',
    ];

    /**
    * Save
    */
    public function save()
    {
        $this->validate();
        $this->parameter->save();
        $this->save = 'spin';
        $this->save = true;
    }

    public function render()
    {
        return view('livewire.parameters.parameter.single-manager');
    }
}
