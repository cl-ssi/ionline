<?php

namespace App\Livewire\HotelBooking;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\HotelBooking\RoomBooking;
use App\Notifications\HotelBooking\NewBooking;

class BookRoom extends Component
{
    public $isVisible = false; // Cambio de nombre aquí
    public $room;
    public $start_date;
    public $end_date;
    public $payment_type;
    public $user_id;

    public function toggleVisibility(){
        $this->isVisible = !$this->isVisible;
    }

    public function mount(){
        $this->user_id = auth()->user()->id;
    }

    #[On('loadUserData')]
    public function loadUserData(User $user){
        $this->user_id = $user->id;
    }

    public function confirm_reservation(){
        // Validar el campo de código de barra antes de redirigir a la URL
        $this->validate([
            'payment_type' => 'required'
        ]);

        $roomBookingSeach = RoomBooking::where('user_id', $this->user_id)
                                        ->where('start_date', $this->start_date)
                                        ->where('end_date', $this->end_date)
                                        ->where('room_id', $this->room->id)
                                        ->where('status','<>','Cancelado')
                                        ->count();

        if($roomBookingSeach > 0){
            session()->flash('info', 'Ya tienes una reserva para ese día.');
        }else{
            $roomBooking = new RoomBooking();
            $roomBooking->user_id = $this->user_id;
            $roomBooking->room_id = $this->room->id;
            $roomBooking->start_date = $this->start_date;
            $roomBooking->end_date = $this->end_date;
            $roomBooking->status = "Reservado";
            $roomBooking->payment_type = $this->payment_type;
            $roomBooking->save();

            if($roomBooking->user){
                if($roomBooking->user->email != null){
                    // Utilizando Notify 
                    $roomBooking->user->notify(new NewBooking($roomBooking));
                } 
            }

            return redirect()->route('hotel_booking.confirmation_page')->with(['roomBooking' => $roomBooking]);
        }
    }

    public function render()
    {
        return view('livewire.hotel-booking.book-room');
    }
}
