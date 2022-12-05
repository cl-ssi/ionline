<?php

namespace App\Http\Livewire\Parameters;

use Livewire\Component;
use App\Models\Parameters\Holiday;
use Livewire\WithPagination;

class Holidays extends Component
{
    /** Necesario para paginar los resultados */
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    /** Mostrar o no el form, tanto para crear como para editar */
    public $form = false;

    public $holiday;

    protected function rules()
    {
        /* Esto fixea que si seleccionas una fecha en el navegador 
         * y luego la borras, se pasa un string vacio en vez de null */
        empty($this->date) ? $this->date = null : $this->date;

        return [
            'holiday.date' => 'required|date_format:Y-m-d',
            'holiday.name' => 'required|min:4',
            'holiday.region' => 'nullable',
        ];
    }

    protected $messages = [
        'holiday.date.required' => 'La fecha desde es requerida.',
        'holiday.name.required' => 'El nombre es requerido.',
    ];

    public function index()
    {
        $this->resetErrorBag();
        $this->form = false;
    }

    public function form(Holiday $holiday)
    {
        $this->holiday = Holiday::firstOrNew([ 'id' => $holiday->id]);
        $this->form = true;
    }

    public function save()
    {
        $this->validate();
        $this->holiday->save();
        $this->index();
    }

    public function delete(Holiday $holiday)
    {
        $holiday->delete();
    }

    public function render()
    {
        $holidays = Holiday::latest()->paginate(25);
        return view('livewire.parameters.holidays', [
            'holidays' => $holidays,
        ])->extends('layouts.app');
    }
}
