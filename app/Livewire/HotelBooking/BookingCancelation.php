<?php

namespace App\Livewire\HotelBooking;

use Livewire\Component;

class BookingCancelation extends Component
{
    public $roomBooking;
    public $showForm = false;
    public $cancelationReason;

    public function showCancelationForm()
    {
        $this->showForm = true;
    }

    public function hideCancelationForm()
    {
        $this->showForm = false;
        $this->cancelationReason = null;
    }

    public function submitCancelation()
    {
        $this->validate([
            'cancelationReason' => 'required'
        ]);

        // Puedes añadir aquí lógica adicional si es necesario.

        $this->dispatch('submitCancelationForm');
    }

    public function render()
    {
        return view('livewire.hotel-booking.booking-cancelation');
    }
}
