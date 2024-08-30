<?php

namespace App\Livewire\HotelBooking;

use Livewire\Component;
use Carbon\Carbon;

use App\Models\HotelBooking\RoomBooking;

class HotelRoomLock extends Component
{
    public $room;
    public $start_date;
    public $end_date;

    public function save(){
        $start_date = Carbon::parse($this->start_date);
        $end_date = Carbon::parse($this->end_date);

        //validación rango de fecha de búsqueda
        if($start_date->format('Y-m-d') < now()->format('Y-m-d')){
            session()->flash('warning', 'La fechas deben ser superior al día actual.');
            return view('hotel_booking.home',compact('communes','hotels','found_rooms', 'request'));
        }

        if($start_date > $end_date){
            session()->flash('warning', 'La fecha de ingreso no puede ser superior a la fecha de salida.');
            return view('hotel_booking.home',compact('communes','hotels','found_rooms', 'request'));
        }

        $roomBooking = new RoomBooking();
        $roomBooking->user_id = auth()->user()->id;
        $roomBooking->room_id = $this->room->id;
        $roomBooking->start_date = $this->start_date;
        $roomBooking->end_date = $this->end_date;
        $roomBooking->status = "Bloqueado";
        $roomBooking->save();

        session()->flash('info', 'Se ha bloqueado el período seleccionado.');

        $this->dispatch('ExecRender', room: null);
    }

    public function render()
    {
        return view('livewire.hotel-booking.hotel-room-lock');
    }
}
