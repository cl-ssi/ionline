<?php

namespace App\Livewire\Inventory;

use App\Models\Inv\InventoryLabel;
use Livewire\Component;

class SearchLabels extends Component
{
    public $tagId;
    public $search;
    public $showResult;
    public $placeholder;
    public $eventName;
    public $smallInput = false;
    public $module;
    public $labelsId;
    public $foundLabels;
    public $selectedLabels;

    public function mount($selectedLabels)
    {
        $this->foundLabels = collect([]);
        if($selectedLabels)
        {
            $this->selectedLabels = $selectedLabels;
            $this->labelsId = $this->selectedLabels->pluck('id');
        }
        else
        {
            $this->labelsId = collect([]);
            $this->selectedLabels = collect([]);
        }

    }

    public function render()
    {
        return view('livewire.inventory.search-labels');
    }

    public function updatedSearch()
    {
        $this->showResult = true;
        $this->foundLabels = collect([]);

        if($this->search)
        {
            $search = "%$this->search%";
            $this->foundLabels = InventoryLabel::query()
                ->when($this->module != null, function($query) {
                    $query->whereModule($this->module);
                })
                ->when($this->search, function ($query) use ($search) {
                    $query->where('name', 'like', $search);
                })
                ->limit(5)
                ->get();
        }
    }

    public function addSearchedLabel(InventoryLabel $label)
    {
        $this->showResult = false;
        $this->search = null;
        $this->labelsId->push($label->id);
        $this->labelsId = $this->labelsId->unique();
        $this->selectedLabels = InventoryLabel::whereIn('id', $this->labelsId)->get();
        $this->foundLabels = collect([]);
        $this->dispatch($this->eventName, values: $this->labelsId);
    }

    public function clearSearch()
    {
        $this->showResult = false;
        $this->foundLabels = collect([]);
        $this->search = null;
    }

    public function deleteLabel($index)
    {
        $this->labelsId = $this->labelsId->forget($index)->values();
        $this->dispatch($this->eventName, values: $this->labelsId);
        $this->selectedLabels = InventoryLabel::whereIn('id', $this->labelsId)->get();
    }
}
