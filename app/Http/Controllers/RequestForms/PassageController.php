<?php

namespace App\Http\Controllers\RequestForms;

use App\RequestForms\Passage;
use App\RequestForms\RequestForm;
use App\RequestForms\RequestFormItemCode;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PassageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return  view('request_form.passage.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, RequestForm $requestForm)
    {
        $item = new Passage($request->All());
        //ASOCIAR ID FOLIO.
        $item->request_form()->associate($requestForm->id);
        $item->save();
        session()->flash('info', 'El pasajero fue ingresado con exito');
        return redirect()->route('request_forms.edit', compact('requestForm'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Passage  $passage
     * @return \Illuminate\Http\Response
     */
    public function show(Passage $passage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Passage  $passage
     * @return \Illuminate\Http\Response
     */
    public function edit(Passage $passage)
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
    public function update(Request $request, Passage $passage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Passage  $passage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Passage $passage)
    {
        $requestform_id = $passage->request_form->id;
        $passage->delete();

        session()->flash('info', 'El pasajero fue eliminado con exito');
        return redirect()->route('request_forms.edit', compact('requestform_id'));
    }

    public function createFromPrevious(Request $request, RequestForm $requestForm)
    {
        $previous = User::find($request->run);
        $requestform_id =  $requestForm->id;
        //session()->flash('info', 'El pasajero fue eliminado con exito');
        return redirect()->route('request_forms.edit', compact('requestform_id','previous'));
    }
}
