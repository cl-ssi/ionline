<?php

namespace App\Http\Livewire\TextTemplates;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

use App\Models\TextTemplates\TextTemplate;

class CreateTextTemplate extends Component
{
    public $title;
    public $module;
    public $moduleDisabled = 'readonly';
    public $input;
    public $template;

    public function render()
    {
        return view('livewire.text-templates.create-text-template');
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
    }
}
