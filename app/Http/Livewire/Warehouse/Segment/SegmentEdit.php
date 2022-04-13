<?php

namespace App\Http\Livewire\Warehouse\Segment;

use App\Models\Warehouse\Segment;
use Livewire\Component;

class SegmentEdit extends Component
{
    public $segment;
    public $name;

    public $rules = [
        'name' => 'required|string|min:2|max:255'
    ];

    public function mount()
    {
        $this->name = $this->segment->name;
    }

    public function render()
    {
        return view('livewire.warehouse.segment.segment-edit');
    }

    public function update()
    {
        $dataValidated = $this->validate();
        $this->segment->update($dataValidated);
        $this->segment->refresh();

        // session()->flash('danger', 'Error en clave única. No se pudo iniciar sesión');

        redirect()->route('segments.index');
    }

    public function changeExperiesAt()
    {
        $this->segment->update([
            'experies_at' => ($this->segment->experies_at == null) ? now() : null
        ]);
        $this->segment->refresh();
        $this->render();
    }
}
