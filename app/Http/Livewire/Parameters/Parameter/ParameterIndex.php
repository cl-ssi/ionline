<?php

namespace App\Http\Livewire\Parameters\Parameter;

use App\Models\Parameters\Parameter;
use Livewire\Component;
use Livewire\WithPagination;

class ParameterIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $modules;
    public $search;
    public $module_selected;

    public function mount()
    {
        $this->module_selected = '';
        $this->modules = Parameter::groupBy('module')->get();
    }

    public function render()
    {
        return view('livewire.parameters.parameter.parameter-index', [
            'parameters' => $this->getParameters()
        ])
        ->extends('layouts.app');
    }

    public function getParameters()
    {
        $search = "%$this->search%";

        /** Resetea la paginación */
        $this->resetPage();

        $parameters = Parameter::query()
            ->when($this->module_selected != '', function($query) {
                $query->whereModule($this->module_selected);
            })
            ->when($this->search, function ($q) use($search) {
                $q->where('parameter', 'like', $search);
            })
            ->orderBy('module')
            ->orderBy('parameter')
            ->paginate(10);

        return $parameters;
    }
}
