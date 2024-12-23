<?php

namespace App\Livewire\HotelBooking;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\HotelBooking\RoomBooking;
use App\Notifications\HotelBooking\NewBooking;
use App\Jobs\HotelBooking\ExecuteVerificationAfterFiveHours;

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
        // Validar el campo de tipo de pago antes de continuar
        $this->validate([
            'payment_type' => 'required'
        ]);
    
        // Verificar si el usuario ya tiene una reserva que se solape con las fechas solicitadas
        $userBookingSearch = RoomBooking::where('user_id', $this->user_id)
                                        ->where('status', '<>', 'Cancelado')
                                        ->where(function($query) {
                                            $query->whereBetween('start_date', [$this->start_date, $this->end_date])
                                                  ->orWhereBetween('end_date', [$this->start_date, $this->end_date])
                                                  ->orWhere(function($q) {
                                                      $q->where('start_date', '<', $this->start_date)  // Fecha de inicio anterior a la nueva reserva
                                                        ->where('end_date', '>', $this->start_date);    // Fecha de fin después de la nueva fecha de inicio
                                                  });
                                        })
                                        ->where(function ($query) {
                                            $query->where('end_date', '!=', $this->start_date);  // No considerar las reservas que terminan el mismo día que la nueva comienza
                                        })
                                        ->count();
    
        // Verificar si otras personas ya tienen una reserva en el mismo rango de fechas
        $otherBookingSearch = RoomBooking::where('room_id', $this->room->id)  // Misma habitación
                                         ->where('user_id', '<>', $this->user_id)  // Diferente usuario
                                         ->where('status', '<>', 'Cancelado')
                                         ->where(function($query) {
                                             $query->whereBetween('start_date', [$this->start_date, $this->end_date])
                                                   ->orWhereBetween('end_date', [$this->start_date, $this->end_date])
                                                   ->orWhere(function($q) {
                                                       $q->where('start_date', '<', $this->start_date)
                                                         ->where('end_date', '>', $this->start_date);
                                                   });
                                         })
                                         ->where(function ($query) {
                                            $query->where('end_date', '!=', $this->start_date)  // No considerar reservas que terminan el mismo día que la nueva comienza
                                                  ->where('start_date', '!=', $this->end_date); // No considerar reservas que comienzan el mismo día que la nueva termina
                                        })
                                         ->count();
    
        // Si el usuario ya tiene una reserva para ese día o se solapa con una existente
        if ($userBookingSearch > 0) {
            session()->flash('info', 'Ya tienes una reserva para ese día o se superpone con una existente.');
            return;
        }
    
        // Si otra persona ya tiene una reserva para ese día o se solapa
        if ($otherBookingSearch > 0) {
            session()->flash('info', 'Otra persona ya ha reservado esta habitación en el mismo período.');
            return;
        }
    
        // Crear la nueva reserva si no hay conflictos
        $roomBooking = new RoomBooking();
        $roomBooking->user_id = $this->user_id;
        $roomBooking->room_id = $this->room->id;
        $roomBooking->start_date = $this->start_date;
        $roomBooking->end_date = $this->end_date;
        $roomBooking->status = "Reservado";
        $roomBooking->payment_type = $this->payment_type;
        $roomBooking->save();
    
        if ($roomBooking->user && $roomBooking->user->email != null) {
            // Notificar al usuario sobre la nueva reserva
            $roomBooking->user->notify(new NewBooking($roomBooking));
        }

        if ($roomBooking->payment_type == "Transferencia") {
            // Despachar el job para que se ejecute 5 horas después
            ExecuteVerificationAfterFiveHours::dispatch($roomBooking)->delay(now()->addHours(5));
        
            session()->flash('success', 'Reserva ' . $roomBooking->id . ' confirmada para la habitación ' . $roomBooking->room->identifier . ' desde ' . $roomBooking->start_date->format('Y-m-d') . ' hasta ' . $roomBooking->end_date->format('Y-m-d') . '. Aprovecha de subir tu comprobante de transferencia. Tienes 5 horas para hacerlo, de lo contrario, la reserva será anulada.');
        } else {
            session()->flash('success', 'Reserva ' . $roomBooking->id . ' confirmada para la habitación ' . $roomBooking->room->identifier . ' desde ' . $roomBooking->start_date->format('Y-m-d') . ' hasta ' . $roomBooking->end_date->format('Y-m-d'));
        }

        return redirect()->route('hotel_booking.my_bookings');
    }
    
    
    

    public function render()
    {
        return view('livewire.hotel-booking.book-room');
    }
}
