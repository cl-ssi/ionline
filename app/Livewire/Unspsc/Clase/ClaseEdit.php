<?php

namespace App\Livewire\Unspsc\Clase;

use Livewire\Component;

class ClaseEdit extends Component
{
    public $segment;
    public $family;
    public $class;
    public $name;

    public $rules = [
        'name' => 'required|string|min:2|max:255'
    ];

    public function mount()
    {
        $this->name = $this->class->name;
    }

    public function render()
    {
        return view('livewire.unspsc.class.class-edit');
    }

    public function update()
    {
        $dataValidated = $this->validate();
        $this->class->update($dataValidated);
        $this->class->refresh();
        return redirect()->route('class.index', ['segment' => $this->segment, 'family' => $this->family]);
    }

    public function changeExperiesAt()
    {
        $this->class->update([
            'experies_at' => ($this->class->experies_at == null) ? now() : null
        ]);
        $this->class->refresh();
        $this->render();
    }
}
