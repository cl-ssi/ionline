<?php

namespace App\Livewire\Inventory;

use Livewire\Component;

class RemovalRequest extends Component
{

    public $motivo;
    public $inventory;

    protected $rules = [
        'motivo' => 'required|min:3|max:255',
    ];

    public function submit()
    {
        $this->validate();

        $this->inventory->removal_request_reason = $this->motivo;
        $this->inventory->removal_request_reason_at = now();
        $this->inventory->save();

        // Después de completar las acciones, puedes restablecer la variable reason
        $this->motivo = '';

        // Puedes agregar un mensaje de éxito o realizar otras acciones después de la presentación exitosa.
        session()->flash('success', 'Solicitud enviada con éxito.');
    }


    public function render()
    {
        return view('livewire.inventory.removal-request')->extends('layouts.bt5.app');
    }
}
