<?php

namespace App\Livewire\Unspsc\Family;

use Livewire\Component;

class FamilyEdit extends Component
{
    public $segment;
    public $family;
    public $name;

    public $rules = [
        'name' => 'required|string|min:2|max:255'
    ];

    public function mount()
    {
        $this->name = $this->family->name;
    }

    public function render()
    {
        return view('livewire.unspsc.family.family-edit');
    }

    public function update()
    {
        $dataValidated = $this->validate();
        $this->family->update($dataValidated);
        $this->family->refresh();
        return redirect()->route('families.index', $this->segment);
    }

    public function changeExperiesAt()
    {
        $this->family->update([
            'experies_at' => ($this->family->experies_at == null) ? now() : null
        ]);
        $this->family->refresh();
        $this->render();
    }
}
