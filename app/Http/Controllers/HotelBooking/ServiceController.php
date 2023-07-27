<?php

namespace App\Http\Controllers\HotelBooking;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\HotelBooking\Service;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::all();
        return view('hotel_booking.services.index',compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hotel_booking.services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $service = new Service($request->All());
      $service->save();

      session()->flash('info', 'El servicio ha sido registrado.');
      return redirect()->route('hotel_booking.services.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pharmacies\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        return view('hotel_booking.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pharmacies\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $service->fill($request->all());
        $service->save();

        session()->flash('info', 'El servicio ha sido actualizado.');
        return redirect()->route('hotel_booking.services.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pharmacies\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
      $service->delete();
      session()->flash('success', 'El servicio ha sido eliminado');
      return redirect()->route('hotel_booking.services.index');
    }
}

