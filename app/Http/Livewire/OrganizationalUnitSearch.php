<?php

namespace App\Http\Livewire;

use App\Rrhh\OrganizationalUnit;
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

    protected $listeners = [
        'addOrganizationalUnit',
        'establishmentId',
        'clear'
    ];

    public function render()
    {
        return view('livewire.organizational-unit-search');
    }

    public function mount()
    {
        $this->organizationalUnits = collect([]);
    }

    public function clear()
    {
        $this->showResult = false;
        $this->search = null;
        $this->organizational_unit_id = null;
        $this->organizationalUnits = collect([]);

        $this->emitTo($this->component, $this->event, null);
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

    public function addOrganizationalUnit(OrganizationalUnit $organizational_unit)
    {
        $this->showResult = false;
        $this->search = $organizational_unit->name;
        $this->organizational_unit_id  = $organizational_unit->id;
        $this->organizationalUnits = collect([]);

        $this->emitTo($this->component, $this->event, $this->organizational_unit_id);
    }

    public function establishmentId($value)
    {
        $this->establishment_id = $value;
    }
}
