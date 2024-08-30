<?php

namespace App\Livewire\HotelBooking;

use Livewire\Component;

use App\Models\HotelBooking\Hotel;
use App\Models\HotelBooking\Room;

class HotelRoomSelecting extends Component
{
    public $hotels;
    public $hotel_id;
    public $rooms;
    public $room_id;
    public $room;
    public $start_date;

    public function mount(){
        $this->hotels = Hotel::all();
    }

    public function hotel_change()
    {
        $this->room = null;
        if($this->hotel_id){
            $hotel = Hotel::find($this->hotel_id);
            $this->rooms = $hotel->rooms;
        }else{
            $this->rooms = null;
        }
    }

    public function room_change(){
        $this->room = Room::find($this->room_id);
        $this->dispatch('ExecRender', room: $this->room);
        $this->dispatch('getRoom', roomId: $this->room->id);
    }

    public function render()
    {
        return view('livewire.hotel-booking.hotel-room-selecting');
    }
}
