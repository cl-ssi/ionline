<?php

namespace App\Livewire\HotelBooking;

use Livewire\Component;
use App\Models\HotelBooking\RoomBooking;

class PendingRequestsCount extends Component
{
    public $roomBooking;

    public function mount(){
        $this->roomBooking = RoomBooking::where('status','Reservado')->count();
    }

    public function render()
    {
        return view('livewire.hotel-booking.pending-requests-count');
    }
}
