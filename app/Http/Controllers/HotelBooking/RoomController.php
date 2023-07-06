<?php

namespace App\Http\Controllers\HotelBooking;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\HotelBooking\Room;
use App\Models\HotelBooking\Hotel;
use App\Models\HotelBooking\RoomType;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::all();
        return view('hotel_booking.rooms.index',compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hotels = Hotel::all();
        $roomTypes = RoomType::all();
        return view('hotel_booking.rooms.create',compact('hotels','roomTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $room = new Room($request->All());
      $room->save();

      session()->flash('info', 'La habitación ha sido registrada.');
      return redirect()->route('hotel_booking.rooms.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pharmacies\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pharmacies\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        $hotels = Hotel::all();
        $roomTypes = RoomType::all();
        return view('hotel_booking.rooms.edit', compact('room','hotels','roomTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pharmacies\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $room->fill($request->all());
        $room->save();

        session()->flash('info', 'La habitación ha sido actualizada.');
        return redirect()->route('hotel_booking.rooms.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pharmacies\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
      $room->delete();
      session()->flash('success', 'La habitación ha sido eliminada.');
      return redirect()->route('hotel_booking.rooms.index');
    }
}
