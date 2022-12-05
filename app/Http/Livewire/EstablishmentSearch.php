<?php

namespace App\Http\Livewire;

use App\Models\Establishment;
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

    protected $listeners = [
        'addEstablishment',
    ];

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
        $this->emitTo('organizational-unit-search', 'clear');
        $this->emitTo('organizational-unit-search', 'establishmentId', null);
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

    public function addEstablishment(Establishment $establishment)
    {
        $this->showResult = false;
        $this->search = $establishment->name;
        $this->establishment_id  = $establishment->id;
        $this->establishments = collect([]);
        $this->emitTo('organizational-unit-search', 'establishmentId', $this->establishment_id);
    }
}
