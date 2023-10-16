<?php

namespace App\Http\Livewire\InventoryLabel;

use App\Models\Inv\InventoryLabel;
use Livewire\Component;

class InventoryLabelIndex extends Component
{
    public $module;
    public $search;

    public function mount()
    {
        $this->search = null;
    }

    public function render()
    {
        return view('livewire.inventory-label.inventory-label-index', [
            'labels' => $this->getLabels()
        ])->extends('layouts.bt4.app');
    }

    public function getLabels()
    {
        $search = "%$this->search%";

        $labels = InventoryLabel::query()
            ->when($this->search, function ($query) use ($search) {
                $query->where('name', 'like', $search);
            })
            ->where('module', $this->module)
            ->get();

        return $labels;
    }
}
