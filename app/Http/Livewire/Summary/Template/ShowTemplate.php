<?php

namespace App\Http\Livewire\Summary\Template;

use Livewire\Component;
use App\Models\Summary\Template;
use App\Models\Summary\Summary;

class ShowTemplate extends Component
{
    public Summary $summary;
    public Template $template;

    protected function rules()
    {
        $array = [];
        foreach($this->template->fields as $name => $type) {
            $array['template.'.$name] = 'required';
        }
        return $array;
    }

    protected $messages = [

    ];

    public function generate(){
        // No hace nada, es para gatillar los .defer
    }

    public function render()
    {
        return view('livewire.summary.template.show-template')->extends('layouts.bt4.app');
    }
}
