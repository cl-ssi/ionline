<?php

namespace App\Http\Livewire\TextTemplates;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;
use App\Models\TextTemplates\TextTemplate;

class ControlsTextTemplate extends Component
{
    /* 
    
    * INTRUCTIVO DE USO (BLADE) *

    * CREAR UN TEXT AREA *

    <fieldset class="form-group">
        <label for="form-obs" class="form-label">Ejemplo para emitir</label>
        <textarea class="form-control" 
            id="form-obs" 
            rows="3" 
            wire:model="nombreCampo">{{ $nombreCampo }}</textarea>
    </fieldset>

    * AGREGAR EL LIVEWIRE CON LOS SIGUIENTES PARAMETROS: *

    @livewire('text-templates.controls-text-template', [
        'module'    => 'plan de compras',
        'input'     => 'nombreCampo'
    ], key('nombreCampo'))

    * INTRUCTIVO DE USO (LW) *

    * AGREGAR EL LISTENER EN EL COMPONENTE QUE RECIBIRÁ EL TEMPLATE *
    protected $listeners = ['setTemplate'];

    * AGREGAR EL NOMBRE DE VARIABLE QUE SE DEIFINIÓ EN EL INPUT *
    public $nombreCampo;

    * AGREGAR LA FUNCION QUE RECIBIRA EL TEMPLATE (DECLARADA EN LISTENERS)
    public function setTemplate($input, $template){
        $this->$input = $template;
    }

    */

    public $module;
    public $input;

    public $textTemplate;

    protected $rules = [
        'textTemplate.title'    => 'required',
        'textTemplate.template' => 'required',
    ];

    protected $messages = [
        'textTemplate.title.required'    => "El título es obligatorio",
        'textTemplate.template.required' => "El contenido de la plantilla es obligatoria",
    ];

    public function mount()
    {
        $this->textTemplate = new TextTemplate();
    }

    public function render()
    {
        $myTextTemplates = TextTemplate::where('module',$this->module)
            ->where('input', $this->input)
            ->where('user_id', auth()->id())
            ->orderBy('title')
            ->get();

        return view('livewire.text-templates.controls-text-template', 
            compact('myTextTemplates'));
    }

    public function save() 
    {
        $this->validate();
        $this->textTemplate->module = $this->module;
        $this->textTemplate->input = $this->input;
        $this->textTemplate->user_id = auth()->id();
        $this->textTemplate->save();

        $this->textTemplate = new TextTemplate();
        $this->resetErrorBag();
    }

    public function form(TextTemplate $textTemplate) {
        $this->textTemplate = TextTemplate::firstOrNew(['id' => $textTemplate->id]);
        $this->resetErrorBag();
    }

    public function delete(TextTemplate $textTemplate){
        $textTemplate->delete();
    }

    public function emitTemplates($textTemplates){
        $this->emit('setTemplate', $textTemplates['input'], $textTemplates['template']);
    }
}
