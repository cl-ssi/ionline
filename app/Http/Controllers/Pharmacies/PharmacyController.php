<?php

namespace App\Http\Controllers\Pharmacies;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Pharmacies\Pharmacy;
use App\User;

class PharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        session(['pharmacy_id' => Auth::user()->pharmacies->first()->id]);
        return view('pharmacies.index');
    }

    public function admin_view(){
      return view('pharmacies.admin_view');
    }

    public function pharmacy_users(){
      $pharmacies = Pharmacy::all();
      return view('pharmacies.admin.pharmacy_users',compact('pharmacies'));
    }

    public function user_asign_store(Request $request){

      $pharmacies = Pharmacy::all();
      $user = User::find($request->user_id);
      $pharmacy = Pharmacy::find($request->pharmacy_id);

      if ($user->pharmacies->count() > 0) {
        session()->flash('warning', 'El usuario ya tiene una farmacia asignada.');
        return view('pharmacies.admin.pharmacy_users',compact('pharmacies'));
      }

      $user->pharmacies()->attach($pharmacy);

      session()->flash('info', 'Se ha asociado el usuario a la farmacia seleccionada.');
      return view('pharmacies.admin.pharmacy_users',compact('pharmacies'));
    }

    public function user_asign_destroy(Pharmacy $pharmacy, User $user){
      $pharmacies = Pharmacy::all();
      $user->pharmacies()->detach($pharmacy);

      session()->flash('info', 'Se ha desaociado el usuario de la farmacia seleccionada.');
      return view('pharmacies.admin.pharmacy_users',compact('pharmacies'));
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
