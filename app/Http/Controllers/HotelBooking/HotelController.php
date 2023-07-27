<?php

namespace App\Http\Controllers\HotelBooking;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\HotelBooking\Hotel;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hotels = Hotel::all();
        return view('hotel_booking.hotels.index',compact('hotels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hotel_booking.hotels.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $hotel = Hotel::find(1);

        // // tiene imagenes adjuntas
        // if(count($request->imgFiles)>0){
        //     dd($request->imgFiles);
        //     foreach($request->imgFiles as $file) {
                
        //         $filename = $file->getClientOriginalName();
        //         $hotelImage = New HotelImage;
        //         $hotelImage->file = $file->store('ionline/hotel_booking/hotel_images',['disk' => 'gcs']);
        //         $hotelImage->name = $filename;
        //         $hotelImage->hotel_id = $hotel->id;
        //         $hotelImage->save();
        //     }
        // }
        // dd("");


        $hotel = new Hotel($request->All());
        $hotel->save();

        session()->flash('info', 'El hotel ha sido registrado.');
        return redirect()->route('hotel_booking.hotels.index');
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
    public function edit(Hotel $hotel)
    {
        return view('hotel_booking.hotels.edit', compact('hotel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pharmacies\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hotel $hotel)
    {
        $hotel->fill($request->all());
        $hotel->save();

        session()->flash('info', 'El hotel ha sido actualizado.');
        return redirect()->route('hotel_booking.hotels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pharmacies\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hotel $hotel)
    {
      $hotel->delete();
      session()->flash('success', 'El hotel ha sido eliminado');
      return redirect()->route('hotel_booking.hotels.index');
    }
}
