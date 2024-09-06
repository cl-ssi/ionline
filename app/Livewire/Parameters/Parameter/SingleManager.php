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
     *      'paramete' => 'Jefe',
     *      'type' => 'user', // user or text
     *      'description' => 'bla bla bla'
     * ])
     * 
     * Type puede ser de tipo User o Value
     *
     * Obtener el valor de un parametro
     * $value = Parameter::get('module','parameter','establishment_id' [opcional]);
     */


    public $parameterModule;
    public $parameterParameter;
    public $parameterValue;
    public $parameterDescription;

    public $parameterName;
    public $type;
    
    public $save = false;

    public $user;

    public $parameter;

    public function mount($module, $parameter, $type, $description = null)
    {
        
        $this->parameter = Parameter::firstOrCreate([
            'module' => $module,
            'parameter' => $parameter,
            'establishment_id' => auth()->user()->organizationalUnit->establishment->id
        ],[
            'description' => $description ?? null,
        ]);

        $this->parameterModule = $module;
        $this->parameterParameter = $parameter;
        $this->parameterValue = $this->parameter->value;
        $this->parameterDescription = $this->parameter->description;

        $this->type = $type;

        if($type == 'user'){
            $this->user = User::find($this->parameter->value);
        }


    }

    /** Listener del componente de seleccionar usuarios */
    #[On('userSelected')]
    public function userSelected(User $user)
    {
        if($this->type == 'user') 
        {
            $this->parameterValue = $user->id;
        }
    }

    protected $rules = [
        // 'parameterModule' => 'required',
        // 'parameterParameter' => 'required',
        'parameterValue' => 'required',
        // 'parameterDescription' => 'nullable',
    ];

    /**
    * Save
    */
    public function saveParameter()
    {
        $this->validate();
 
        $this->parameter->value = $this->parameterValue;
        $this->parameter->save();
    
        $this->save = 'spin';
        $this->save = true;
    }

    public function render()
    {
        return view('livewire.parameters.parameter.single-manager');
    }
}
