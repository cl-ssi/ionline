<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Resources\Telephone;
use App\User;
use App\Parameters\Place;

class TelephoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $telephones = Telephone::Search($request->get('search'))->with('place')->paginate(100);
        return view('resources.telephone.index', compact('telephones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::doesnthave('Telephones')->get();
        $places = Place::All();
        return view('resources.telephone.create', compact('users','places'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $rules = [
          'number' => 'required|unique:res_telephones,number',
          'minsal' => 'required|unique:res_telephones,minsal',
          'mac'    => 'unique:res_telephones,mac',
      ];

      $messages = [
          'required' => 'Necesita completar número y anexo',
          'number.unique' => 'El número de teléfono ya está ingresado.',
          'minsal.unique' => 'El anexo minsal ya está ingresado.',
          'mac.unique' => 'La dirección MAC ya está ingresada.',
      ];

      $request->validate($rules, $messages);


      $telephone = new Telephone($request->All());

      // if ($request->has('user')) {
      //     if ($request->filled('user')) {
      //         $telephone->user()->associate($request->input('user'));
      //     }
      //     else {
      //         $telephone->user()->dissociate();
      //     }
      // }

      $telephone->save();
      $telephone->users()->sync($request->input('users'));

      session()->flash('info', 'El telefono '.$telephone->number.' ha sido creado.');

      return redirect()->route('resources.telephone.index');

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
