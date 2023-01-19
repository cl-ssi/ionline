<?php

namespace App\Http\Livewire\Parameters\Parameter;

use Livewire\Component;
use App\User;
use App\Models\Parameters\Parameter;

class SingleManager extends Component
{
    /** Uso:
     *  
     * @livewire('parameters.parameter.single-manager',[
     *      'module' => 'drugs',
     *      'parameterName' => 'Jefe',
     *      'type' => 'user'
     * ])
     * 
     * Type puede ser de tipo User o Value
     *
     * Obtener el valor de un parametro
     * $value = Parameter::get('module','parameter');
     */

    public $module;
    public $parameterName;
    public $type;
    
    public $save = false;

    public $user;

    public $parameter;

    protected $listeners = ['userSelected' => 'userSelected'];

    public function mount($module, $parameterName, $type)
    {
        $this->parameter = Parameter::firstOrCreate([
            'module' => $module,
            'parameter' => $parameterName,
        ]);

        $this->type = $type;

        if($type == 'user'){
            $this->user = User::find($this->parameter->value);
        }


    }

    /** Listener del componente de seleccionar usuarios */
    public function userSelected(User $user)
    {
        $this->parameter->value = $user->id;
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
