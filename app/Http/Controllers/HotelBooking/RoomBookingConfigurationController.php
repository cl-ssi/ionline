<?php

namespace App\Http\Controllers\HotelBooking;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomBookingConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('hotel_booking.room_booking_configuration.index');
    }
}
