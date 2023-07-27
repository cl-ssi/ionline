<?php

namespace App\Http\Controllers\HotelBooking;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;

use App\Models\ClCommune;
use App\Models\HotelBooking\Hotel;
use App\Models\HotelBooking\RoomBookingConfiguration;
use App\Models\HotelBooking\RoomBooking;

class HotelBookingController extends Controller
{
    public function index(Request $request){
        $hotels = Hotel::all();
        $communes = ClCommune::all();
        return view('hotel_booking.home',compact('communes','hotels','request'));
    }

    public function search_booking(Request $request){
        $commune_id = $request->commune_id;
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $guest_number = intval($request->guest_number);
        $diff = $start_date->diffInDays($end_date);
        // dd($start_date, $end_date);

        $hotels = Hotel::all();
        $communes = ClCommune::all();
        $count = 0;
        $found_rooms = [];

        //validación rango de fecha de búsqueda
        if($start_date->format('Y-m-d') < now()->format('Y-m-d')){
            session()->flash('warning', 'La fechas deben ser superior al día actual.');
            return view('hotel_booking.home',compact('communes','hotels','found_rooms', 'request'));
        }

        if($start_date > $end_date){
            session()->flash('warning', 'La fecha de ingreso no puede ser superior a la fecha de salida.');
            return view('hotel_booking.home',compact('communes','hotels','found_rooms', 'request'));
        }
        
        // encuentra todas las configuraciones que tengan disponibilidad 
        $bookingConfigurations = RoomBookingConfiguration::where('end_date','>=',now())->get();

        foreach($bookingConfigurations as $bookingConfiguration){
            $room_capacity = $bookingConfiguration->room->single_bed + ($bookingConfiguration->room->double_bed*2);
            $max_days_alowed = $bookingConfiguration->room->max_days_avaliable;
            
            if($start_date >= $bookingConfiguration->start_date && $start_date <= $bookingConfiguration->end_date 
            && $end_date >= $bookingConfiguration->start_date && $end_date <= $bookingConfiguration->end_date
            && $guest_number <= $room_capacity
            && $diff <= $max_days_alowed){

                $roomBookings = RoomBooking::where('room_id',$bookingConfiguration->room_id)->whereIn('status',['Reservado','Bloqueado'])->get();

                // se verifica si dia actuales son compatible con días reservados/bloqueados
                $flag = 0;
                foreach($roomBookings as $key => $roomBooking){
                    
                    if($start_date < $roomBooking->start_date && $end_date >= $roomBooking->end_date){
                        $flag = 1;
                        continue; //se rompe la busqueda en esta configuración
                    }
                    if($start_date > $roomBooking->start_date && $start_date < $roomBooking->end_date){
                        $flag = 1;
                        continue; //se rompe la busqueda en esta configuración
                    }
                    if($end_date > $roomBooking->start_date && $end_date < $roomBooking->end_date){
                        $flag = 1;
                        continue; //se rompe la busqueda en esta configuración
                    }
                    
                    if($start_date->format('Y-m-d') == $roomBooking->start_date->format('Y-m-d') && $end_date->format('Y-m-d') == $roomBooking->end_date->format('Y-m-d')){
                        $flag = 1;
                        continue; //se rompe la busqueda en esta configuración
                    }
                }

                // No hubo interrupciones, por ende se agrega habitación al array
                if($flag == 0){
                    array_push($found_rooms, $bookingConfiguration->room);
                }
            }
        }
        
        return view('hotel_booking.home',compact('communes','hotels','found_rooms', 'request'));
    }

    public function my_bookings(){

        if(Auth::user()->hasPermissionTo('HotelBooking: Administrador')){
            $roomBookings = RoomBooking::paginate(50);
        }else{
            $roomBookings = RoomBooking::where('user_id',auth()->user()->id)->paginate(50);
        }
        return view('hotel_booking.my_bookings',compact('roomBookings'));
    }

    public function booking_cancelation(RoomBooking $roomBooking){
        $roomBooking->status = "Cancelado";
        $roomBooking->save();
        session()->flash('success', 'Se modificó el estado de la reserva.');
        return redirect()->back();
    }
}
