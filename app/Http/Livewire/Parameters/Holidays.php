<?php

namespace App\Http\Livewire\Parameters;

use Livewire\Component;
use App\Holiday;

class Holidays extends Component
{
    public $holidays;
    public $view;

    public $holiday;
    public $date, $name, $region;

    protected function rules()
    {
        /* Esto fixea que si seleccionas una fecha en el navegador 
         * y luego la borras, se pasa un string vacio en vez de null */
        empty($this->date) ? $this->date = null : $this->date;

        return [
            'date' => 'required|date_format:Y-m-d',
            'name' => 'required|min:4',
            'region' => 'nullable',
        ];
    }

    protected $messages = [
        'date.required' => 'La fecha desde es requerida.',
        'name.required' => 'El nombre es requerido.',
    ];

    public function mount()
    {
        $this->holidays = Holiday::orderBy('date')->get();
        $this->view = 'index';
    }

    public function index()
    {
        $this->view = 'index';
    }

    public function create()
    {
        $this->view = 'create';
        $this->holiday = null;
        
        $this->date = null;
        $this->name = null;
        $this->region = null;
    }

    public function store()
    {
        Holiday::create($this->validate());
        $this->mount();
        $this->view = 'index';
    }

    public function edit(Holiday $holiday)
    {
        $this->view = 'edit';
        $this->holiday = $holiday;
        
        $this->date = $holiday->date->format('Y-m-d');
        $this->name = $holiday->name;
        $this->region = $holiday->region;
    }

    public function update(Holiday $holiday)
    {
        $holiday->update($this->validate());

        $this->mount();
        $this->view = 'index';
    }

    public function delete(Holiday $holiday)
    {
        $holiday->delete();
        $this->mount();
    }

    public function render()
    {
        return view('livewire.parameters.holidays')->extends('layouts.app');
    }
}
