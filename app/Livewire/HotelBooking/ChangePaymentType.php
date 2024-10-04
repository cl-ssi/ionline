<?php

namespace App\Livewire\HotelBooking;

use Livewire\Component;
use App\Models\HotelBooking\RoomBooking;
use App\Notifications\HotelBooking\NewBooking;
use App\Jobs\HotelBooking\ExecuteVerificationAfterFiveHours;

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

        if($this->roomBooking->payment_type == "Transferencia"){

            if ($this->roomBooking->user && $this->roomBooking->user->email != null) {
                // Notificar al usuario sobre el cambio a Transferencia
                $this->roomBooking->user->notify(new NewBooking($this->roomBooking));
            }

            ExecuteVerificationAfterFiveHours::dispatch($this->roomBooking)->delay(now()->addHours(5));
            session()->flash('success', 'Se debe subir comprobante de transferencia. Tienes 5 horas para hacerlo, de lo contrario, la reserva será anulada.');
        }

        return redirect()->route('hotel_booking.my_bookings');
    }

    public function render()
    {
        return view('livewire.hotel-booking.change-payment-type');
    }
}
