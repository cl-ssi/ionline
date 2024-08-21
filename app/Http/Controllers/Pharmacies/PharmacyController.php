<?php

namespace App\Http\Controllers\Pharmacies;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Pharmacies\Pharmacy;
use App\Models\User;

class PharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // session(['pharmacy_id' => auth()->user()->pharmacies->first()->id]);
        return view('pharmacies.index');
    }

    public function admin_view(){
      return view('pharmacies.admin_view');
    }

    public function pharmacy_users()
    {
        if (auth()->user()->can('be god')) $pharmacies = Pharmacy::all();
        else $pharmacies = Pharmacy::where('establishment_id',auth()->user()->establishment_id)->get();

        return view('pharmacies.admin.pharmacy_users',compact('pharmacies'));
    }

    public function user_asign_store(Request $request)
    {
        if (auth()->user()->can('be god')) $pharmacies = Pharmacy::all();
        else $pharmacies = Pharmacy::where('establishment_id',auth()->user()->establishment_id)->get();

        $user = User::find($request->user_id);
        $pharmacy = Pharmacy::find($request->pharmacy_id);

        $user->pharmacies()->attach($pharmacy);

        session()->flash('info', 'Se ha asociado el usuario a la farmacia seleccionada.');
        return view('pharmacies.admin.pharmacy_users',compact('pharmacies'));
    }

    public function user_asign_destroy(Pharmacy $pharmacy, User $user){
        if (auth()->user()->can('be god')) $pharmacies = Pharmacy::all();
        else $pharmacies = Pharmacy::where('establishment_id',auth()->user()->establishment_id)->get();

        $user->pharmacies()->detach($pharmacy);

        session()->flash('info', 'Se ha desaociado el usuario de la farmacia seleccionada.');
        return view('pharmacies.admin.pharmacy_users',compact('pharmacies'));
    }

    public function change(Pharmacy $pharmacy){
        // auth()->user()->pharmacies()->detach(auth()->user()->pharmacies()->first());
        // auth()->user()->pharmacies()->attach($pharmacy);

        // session(['pharmacy_id' => auth()->user()->pharmacies->first()->id]);

        session(['pharmacy_id' => $pharmacy->id]);
        
        // return redirect()->back()->with('success', 'Se ha cambiado la farmacia.');
        return view('pharmacies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
