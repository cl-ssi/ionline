<?php

namespace App\Http\Controllers\RequestForms;

use App\Models\RequestForms\Passenger;
use App\Models\RequestForms\RequestForm;
//use App\RequestForms\RequestFormItemCode;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PassengerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('id', auth()->id());
        return view('request_form.passage.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$user = User::where('id', auth()->id());
        return  view('request_form.passenger.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, RequestForm $requestForm)
    {
        $item = new Passenger($request->All());
        //ASOCIAR ID FOLIO.
        $item->request_form()->associate($requestForm->id);
        $item->save();
        session()->flash('info', 'El pasajero fue ingresado con exito');
        return redirect()->route('request_forms.edit', compact('requestForm'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Passenger  $passage
     * @return \Illuminate\Http\Response
     */
    public function show(Passenger $passenger)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Passage  $passage
     * @return \Illuminate\Http\Response
     */
    public function edit(Passenger $passenger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Passage  $passage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Passenger $passenger)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Passenger  $passenger
     * @return \Illuminate\Http\Response
     */
    public function destroy(Passenger $passenger)
    {
        // $requestform_id = $passage->request_form->id;
        // $passage->delete();
        //
        // session()->flash('info', 'El pasajero fue eliminado con exito');
        // return redirect()->route('request_forms.edit', compact('requestform_id'));
    }

    public function createFromPrevious(Request $request, RequestForm $requestForm)
    {
        // $previous = User::find($request->run);
        // $requestform_id =  $requestForm->id;
        // //session()->flash('info', 'El pasajero fue eliminado con exito');
        // return redirect()->route('request_forms.edit', compact('requestform_id','previous'));
    }
}
