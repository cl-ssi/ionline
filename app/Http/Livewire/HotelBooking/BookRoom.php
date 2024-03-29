<?php

namespace App\Http\Livewire\HotelBooking;

use Livewire\Component;
use Carbon\Carbon;

use App\Models\HotelBooking\Room;
use App\Models\HotelBooking\RoomBooking;

class BookRoom extends Component
{
    public $show = false;
    public $room;
    public $start_date;
    public $end_date;
    public $payment_type;

    public function show(){
        if($this->show){
            $this->show = false;
        }else{
            $this->show = true;
        }
    }

    public function confirm_reservation(){

        // Validar el campo de código de barra antes de redirigir a la URL
        $this->validate([
            'payment_type' => 'required'
        ]);

        $roomBooking = new RoomBooking();
        $roomBooking->user_id = auth()->user()->id;
        $roomBooking->room_id = $this->room->id;
        $roomBooking->start_date = $this->start_date;
        $roomBooking->end_date = $this->end_date;
        $roomBooking->status = "Reservado";
        $roomBooking->payment_type = $this->payment_type;
        $roomBooking->save();

        // $roomBooking = RoomBooking::find(3);
        // dd($roomBooking);
        // return redirect()->route('hotel_booking.confirmation_page',compact('roomBooking'));
        return redirect()->route('hotel_booking.confirmation_page')->with( ['roomBooking' => $roomBooking] );
    }

    public function render()
    {
        return view('livewire.hotel-booking.book-room');
    }
}
