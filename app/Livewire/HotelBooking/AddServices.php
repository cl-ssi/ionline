<?php

namespace App\Livewire\HotelBooking;

use Livewire\Component;

use App\Models\HotelBooking\Service;
use App\Models\HotelBooking\Room;
use App\Models\HotelBooking\RoomService;

class AddServices extends Component
{
    // public $services;

    public function mount()
    {
        $this->services = Service::all();
    }

    // public function render()
    // {
    //     return view('livewire.hotel-booking.add-services');
    // }

    public $services;
    public $room;
    public $roomServices;
    public $roomServicesArray;

    public function setService($service_id)
    {
        if(in_array($service_id, $this->roomServicesArray))
        {
            /** este modelo no tiene ID hay que hacer la query para borrar */
            RoomService::where('room_id',$this->room->id)
                        ->where('service_id',$service_id)->delete();
        }
        else
        {
            RoomService::Create([
                'room_id' => $this->room->id,
                'service_id' => $service_id
            ]);
        }
        
        $this->room->refresh();
    }

    public function render()
    {
        // $this->roomServices = $this->room->services->where('user_id',auth()->id());
        $this->roomServices = $this->room->services;
        $this->roomServicesArray = $this->roomServices->pluck('id')->toArray();

        return view('livewire.hotel-booking.add-services');
    }

    
}
