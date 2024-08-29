<?php

namespace App\Livewire\HotelBooking;

use Livewire\Component;
use App\Models\HotelBooking\RoomBooking;

class ChangePaymentType extends Component
{
    public $roomBooking;
    public $payment_type;
    public $showSelect = false;

    protected $rules = [
        'payment_type' => 'required'
    ];

    public function mount(RoomBooking $roomBooking)
    {
        $this->roomBooking = $roomBooking;
        $this->payment_type = $roomBooking->payment_type;
    }

    public function toggleSelect()
    {
        $this->showSelect = !$this->showSelect;
    }

    public function save()
    {
        $this->validate();

        $this->roomBooking->payment_type = $this->payment_type;
        $this->roomBooking->save();

        return redirect()->route('hotel_booking.my_bookings'); // Reemplaza 'desired.route' con la ruta a la que deseas redirigir.
    }

    public function render()
    {
        return view('livewire.hotel-booking.change-payment-type');
    }
}
