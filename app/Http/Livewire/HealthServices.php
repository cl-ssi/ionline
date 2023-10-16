<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\HealthService;
use App\Models\ClRegion;

class HealthServices extends Component
{
    /** Mostrar o no el form, tanto para crear como para editar */
    public $form = false;

    public $healthService;

    /** Listado de regiones */
    public $regions;

    public function mount()
    {
        $this->regions = ClRegion::pluck('name','id');
    }

    protected function rules()
    {
        return [
            'healthService.name' => 'required|min:4',
            'healthService.region_id' => 'required',
        ];
    }

    protected $messages = [
        'healthService.name.required' => 'El nombre es requerido.',
        'healthService.region_id.required' => 'La la región es requerida.',
    ];

    public function index()
    {
        $this->resetErrorBag();
        $this->form = false;
    }

    public function form(HealthService $healthService)
    {
        $this->healthService = HealthService::firstOrNew([ 'id' => $healthService->id]);
        $this->form = true;
    }

    public function save()
    {
        $this->validate();
        $this->healthService->save();
        $this->index();
    }

    public function delete(HealthService $healthService)
    {
        $healthService->delete();
        $this->index();
    }

    public function render()
    {
        $healthServices = HealthService::with('region')->get();
        return view('livewire.health-services', [
            'healthServices' => $healthServices,
        ])->extends('layouts.bt4.app');
    }
}
