<?php

namespace App\Livewire\HotelBooking;

use Livewire\Component;
use App\Models\HotelBooking\Hotel;
use App\Models\HotelBooking\Room;

class HotelRoomSelectingSimple extends Component
{
    public $hotels;
    public $hotel_id;
    public $room;
    public $room_id;

    public function mount($room = null)
    {
        // Cargar todos los hoteles
        $this->hotels = Hotel::all();

        // Si se ha pasado una habitación, cargar ese hotel y esa habitación
        if ($room) {
            $this->room_id = $room->id;
            $this->hotel_id = $room->hotel->id;
        }
    }

    public function hotel_change()
    {
        // Cargar las habitaciones asociadas al hotel seleccionado
        $this->rooms = Room::where('hotel_id', $this->hotel_id)->get();
    }

    public function render()
    {
        // Cargar las habitaciones asociadas al hotel seleccionado
        $rooms = [];
        if ($this->hotel_id) {
            $rooms = Room::where('hotel_id', $this->hotel_id)->get();
        }

        // return view('livewire.hotel-booking.calendar', [
        //     'rooms' => $rooms
        // ]);

        return view('livewire.hotel-booking.hotel-room-selecting-simple', [
            'rooms' => $rooms
        ]);
    }
}