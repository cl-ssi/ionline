<?php

namespace App\Livewire\HotelBooking;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\HotelBooking\Room;
use App\Models\HotelBooking\RoomBookingConfiguration as RoomBookingConfigurationModel;

class RoomBookingConfiguration extends Component
{
    public $configuration;
    public $room;
    public $start_date;
    public $end_date;
    public $monday;
    public $tuesday;
    public $wednesday;
    public $thursday;
    public $friday;
    public $saturday;
    public $sunday;

    public function mount(){
        // solo si viene el parametro 'configuration' se realiza esa carga
        if($this->configuration){
            $this->start_date = $this->configuration->start_date->format('Y-m-d');
            $this->end_date = $this->configuration->end_date->format('Y-m-d');
            if($this->configuration->monday){
                $this->monday = $this->configuration->monday;
            }
            if($this->configuration->tuesday){
                $this->tuesday = $this->configuration->tuesday;
            }
            if($this->configuration->wednesday){
                $this->wednesday = $this->configuration->wednesday;
            }
            if($this->configuration->thursday){
                $this->thursday = $this->configuration->thursday;
            }
            if($this->configuration->friday){
                $this->friday = $this->configuration->friday;
            }
            if($this->configuration->saturday){
                $this->saturday = $this->configuration->saturday;
            }
            if($this->configuration->sunday){
                $this->sunday = $this->configuration->sunday;
            }
        }   
    }

    public function update(RoomBookingConfigurationModel $configuration){
        // verificar fechas
        // foreach($this->configuration->room->bookingConfigurations as $bookingConfiguration){
        //     if(Carbon::parse($this->start_date) >= $bookingConfiguration->start_date && Carbon::parse($this->start_date) <= $bookingConfiguration->end_date){
        //         session()->flash('warning', 'No es posible guardar esta configuración. Verifique las fechas.');return 0;
        //     }
        //     if(Carbon::parse($this->end_date) >= $bookingConfiguration->start_date && Carbon::parse($this->end_date) <= $bookingConfiguration->end_date){
        //         session()->flash('warning', 'No es posible guardar esta configuración. Verifique las fechas.');return 0;
        //     }
        //     if(Carbon::parse($this->start_date) <= $bookingConfiguration->start_date && Carbon::parse($this->end_date) >= $bookingConfiguration->end_date){
        //         session()->flash('warning', 'No es posible guardar esta configuración. Verifique las fechas.');return 0;
        //     }
        // }

        // modifica configuración
        $configuration->start_date = $this->start_date;
        $configuration->end_date = $this->end_date;

        if($this->monday){$configuration->monday = $this->monday;}
        else{$configuration->monday = null;}

        if($this->tuesday){$configuration->tuesday = $this->tuesday;}
        else{$configuration->tuesday = null;}

        if($this->wednesday){$configuration->wednesday = $this->wednesday;}
        else{$configuration->wednesday = null;}

        if($this->thursday){$configuration->thursday = $this->thursday;}
        else{$configuration->thursday = null;}

        if($this->friday){$configuration->friday = $this->friday;}
        else{$configuration->friday = null;}

        if($this->saturday){$configuration->saturday = $this->saturday;}
        else{$configuration->saturday = null;}

        if($this->sunday){$configuration->sunday = $this->sunday;}
        else{$configuration->sunday = null;}

        $configuration->save();

        $this->dispatch('ExecRender', room: null);

        /** Agrega un mensaje de éxito */
        session()->flash('info', 'Se ha modificado la configuración.');
    }

    #[On('getRoom')]
    public function getRoom($roomId){
        // si se guarda uno nuevo, se busca y se guarda en variable local
        if($roomId){
            $this->room = Room::find($roomId);
        }
        
        $this->render();
    }

    public function save(){
        // verificar fechas
        // foreach($this->room->bookingConfigurations as $bookingConfiguration){
        //     if(Carbon::parse($this->start_date) >= $bookingConfiguration->start_date && Carbon::parse($this->start_date) <= $bookingConfiguration->end_date){
        //         session()->flash('warning', 'No es posible guardar esta configuración. Verifique las fechas.');return 0;
        //     }
        //     if(Carbon::parse($this->end_date) >= $bookingConfiguration->start_date && Carbon::parse($this->end_date) <= $bookingConfiguration->end_date){
        //         session()->flash('warning', 'No es posible guardar esta configuración. Verifique las fechas.');return 0;
        //     }
        //     if(Carbon::parse($this->start_date) <= $bookingConfiguration->start_date && Carbon::parse($this->end_date) >= $bookingConfiguration->end_date){
        //         session()->flash('warning', 'No es posible guardar esta configuración. Verifique las fechas.');return 0;
        //     }
        // }

        // guarda nueva configuración
        $roomBookingConfigurationModel = new RoomBookingConfigurationModel();
        $roomBookingConfigurationModel->start_date = $this->start_date;
        $roomBookingConfigurationModel->end_date = $this->end_date;
        $roomBookingConfigurationModel->room_id = $this->room->id;
        if($this->monday){$roomBookingConfigurationModel->monday = $this->monday;}else{$roomBookingConfigurationModel->monday = false;}
        if($this->tuesday){$roomBookingConfigurationModel->tuesday = $this->tuesday;}else{$roomBookingConfigurationModel->tuesday = false;}
        if($this->wednesday){$roomBookingConfigurationModel->wednesday = $this->wednesday;}else{$roomBookingConfigurationModel->wednesday = false;}
        if($this->thursday){$roomBookingConfigurationModel->thursday = $this->thursday;}else{$roomBookingConfigurationModel->thursday = false;}
        if($this->friday){$roomBookingConfigurationModel->friday = $this->friday;}else{$roomBookingConfigurationModel->friday = false;}
        if($this->saturday){$roomBookingConfigurationModel->saturday = $this->saturday;}else{$roomBookingConfigurationModel->saturday = false;}
        if($this->sunday){$roomBookingConfigurationModel->sunday = $this->sunday;}else{$roomBookingConfigurationModel->sunday = false;}
        $roomBookingConfigurationModel->status = "Reservado";
        $roomBookingConfigurationModel->save();

        $this->dispatch('ExecRender', room: $this->room);

        $this->reset();

        /** Agrega un mensaje de éxito */
        session()->flash('info', 'Se ha guardado la configuración.');
    }

    public function render()
    {
        return view('livewire.hotel-booking.room-booking-configuration');
    }
}
