<?php

namespace App\Http\Controllers\RequestForms;

use App\RequestForms\Item;
use App\RequestForms\RequestForm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItemController extends Controller
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
        return  view('request_form.item.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, RequestForm $requestForm)
    {
        $item = new Item($request->All());
        //ASOCIAR ID FOLIO.
        $item->request_form()->associate($requestForm->id);
        $item->save();
        $requestform_id = $requestForm->id;
        session()->flash('info', 'Su articulo fue ingresado con exito');
        return redirect()->route('request_forms.edit', compact('requestform_id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $requestform_id = $item->request_form_id;
        $item->delete();

        session()->flash('info', 'El pasaje fue ingresado con exito');
        return redirect()->route('request_forms.edit', compact('requestform_id'));
    }
}
