<?php

namespace App\Livewire;

use App\Models\Establishment;
use Livewire\Attributes\On;
use Livewire\Component;

class EstablishmentSearch extends Component
{
    public $establishment_id;
    public $establishments;
    public $search;
    public $showResult  = false;

    public $tagId;
    public $smallInput;
    public $placeholder;

    public function render()
    {
        return view('livewire.establishment-search');
    }

    public function mount()
    {
        $this->establishments = collect([]);
    }

    public function clear()
    {
        $this->showResult = false;
        $this->search = null;
        $this->establishment_id = null;
        $this->establishments = collect([]);
        $this->dispatch('clear')->to('organizational-unit-search');
        $this->dispatch('establishmentId', null)->to('organizational-unit-search');
    }

    public function updatedSearch()
    {
        $this->showResult = true;
        $this->establishments = collect([]);

        if($this->search)
        {
            $this->establishments = Establishment::query()
                ->where('name', 'like', "%" . $this->search . "%")
                ->limit(5)
                ->get();
        }
    }

    #[On('addEstablishment')]
    public function addEstablishment(Establishment $establishment)
    {
        $this->showResult = false;
        $this->search = $establishment->name;
        $this->establishment_id  = $establishment->id;
        $this->establishments = collect([]);
        $this->dispatch('establishmentId', $this->establishment_id)->to('organizational-unit-search');
    }
}
