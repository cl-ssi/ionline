<?php

namespace App\Http\Livewire\TextTemplates;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;
use App\Models\TextTemplates\TextTemplate;

class ControlsTextTemplate extends Component
{
    /* 
    
    * INTRUCTIVO DE USO (BLADE) *

    * CREAR UN TEXT AREA Y AGREGAR LW CON LOS SIGUIENTES PARAMETROS:
    'module' y 'input' ESTOS SE ALMACENARAN EN BB.DD. *

    <fieldset class="form-group">
        <label for="exampleFormControlTextarea1" class="form-label">Ejemplo para emitir</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" wire:model="nombreCampo">{{ $nombreCampo }}</textarea>
    </fieldset>

    @livewire('text-templates.controls-text-template', [
        'module'    => 'plan de compras',
        'input'     => 'nombreCampo'
    ])

    * INTRUCTIVO DE USO (LW) *

    * SE AGREGA LISTENERS EN EL COMPONENTE QUE RECIBIRÁ EL TEMPLATE *
    protected $listeners = ['textTemplateToEmit'];

    * SE AGREGA EL COMPONENTE QUE DEFINIMOS EN EL CAMPO *
    public $nombreCampo;
    
    * SE AGREGA LA FUNCION QUE RECIBIRA EL TEMPLATE (DECLARADA EN LISTENERS)
    public function textTemplateToEmit($template, $input){
        $this->$input = $template;
    }

    */


    public $module;
    public $input;

    public $title;
    public $template;

    public function render()
    {
        $myTextTemplates = TextTemplate::where('user_id', Auth::user()->id)->get();
        return view('livewire.text-templates.controls-text-template', compact('myTextTemplates'));
    }

    public function save(){
        $textTemplate = new TextTemplate();
        $editTextTemplate = null;

        TextTemplate::updateOrCreate(
            [
                'id'    =>  $editTextTemplate ? $editTextTemplate->id : '',
            ],
            [
                'title'         => $this->title,
                'module'        => $this->module,
                'input'         => $this->input,
                'template'      => $this->template,
                'user_id'       => Auth::user()->id
            ]
        );

        // return redirect()->route('purchase_plan.show', $purchasePlan->id);
        return redirect()->back(); 
    }

    public function emitControls($textTemplates){
        $this->emit('textTemplateToEmit', $textTemplates['template'], $textTemplates['input']);
    }
}
