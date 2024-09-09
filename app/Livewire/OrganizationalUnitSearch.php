<?php

namespace App\Livewire;

use App\Models\Rrhh\OrganizationalUnit;
use Livewire\Attributes\On;
use Livewire\Component;

class OrganizationalUnitSearch extends Component
{
    public $organizational_unit_id;
    public $establishment_id;
    public $organizationalUnits;
    public $search;
    public $showResult  = false;

    public $tagId;
    public $smallInput;
    public $placeholder;

    public $component;
    public $event;


    public function render()
    {
        return view('livewire.organizational-unit-search');
    }

    public function mount()
    {
        $this->organizationalUnits = collect([]);
    }

    #[On('clear')]
    public function clear()
    {
        $this->showResult = false;
        $this->search = null;
        $this->organizational_unit_id = null;
        $this->organizationalUnits = collect([]);

        $this->dispatch($this->event, value: null);
    }

    public function updatedSearch()
    {
        $this->organizationalUnits = collect([]);

        if($this->search && $this->establishment_id)
        {
            $this->showResult = true;

            $this->organizationalUnits = OrganizationalUnit::query()
                ->whereEstablishmentId($this->establishment_id)
                ->where('name', 'like', "%" . $this->search . "%")
                ->limit(5)
                ->get();
        }
    }

    #[On('addOrganizationalUnit')]
    public function addOrganizationalUnit(OrganizationalUnit $organizational_unit)
    {
        $this->showResult = false;
        $this->search = $organizational_unit->name;
        $this->organizational_unit_id  = $organizational_unit->id;
        $this->organizationalUnits = collect([]);

        $this->dispatch($this->event, value: $this->organizational_unit_id);
    }

    #[On('establishmentId')]
    public function establishmentId($value)
    {
        $this->establishment_id = $value;
    }
}
