<?php

namespace App\Livewire\Summary;

use Livewire\Component;
use App\Models\Summary\Summary;

class UpdateObservation extends Component
{
    public Summary $summary;
    
    protected $rules = [
        'summary.observation' => 'required',
    ];

    protected $messages = [
        'summary.observation.required' => 'Debe ingresar una observación.',
    ];

    /**
    * save
    */
    public function updateObservation()
    {
        $this->summary->save();
    }

    public function render()
    {
        return view('livewire.summary.update-observation');
    }
}
