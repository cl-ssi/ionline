<?php

namespace App\Http\Controllers\RequestForms;

use App\Models\RequestForms\ItemRequestForm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemRequestFormController extends Controller
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
        // return  view('request_form.item.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, RequestForm $requestForm)
    {
        // $item = new Item($request->All());
        // dd('hola');
        // //ASOCIAR ID FOLIO.
        // $item->request_form()->associate($requestForm->id);
        // $item->save();
        // session()->flash('info', 'Su articulo fue ingresado con exito');
        // return redirect()->route('request_forms.edit', compact('requestForm'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ItemRequestForm  $itemRequestForm
     * @return \Illuminate\Http\Response
     */
    public function show(ItemRequestForm $itemRequestForm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ItemRequestForm  $itemRequestForm
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemRequestForm $itemRequestForm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ItemRequestForm  $itemRequestForm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemRequestForm $itemRequestForm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ItemRequestForm  $itemRequestForm
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemRequestForm $itemRequestForm)
    {
        // $requestform_id = $item->request_form_id;
        // $item->delete();
        //
        // session()->flash('info', 'El pasaje fue ingresado con exito');
        // return redirect()->route('request_forms.edit', compact('requestform_id'));
    }

    public function show_item_file(ItemRequestForm $itemRequestForm)
    {
        return Storage::disk('gcs')->response($itemRequestForm->article_file);
    }
}
