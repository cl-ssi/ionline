<?php

namespace App\Http\Controllers\RequestForms;

use App\Models\Parameters\UnitOfMeasurement;
use App\Models\RequestForms\ItemRequestForm;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ItemRequestFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // return  view('request_form.item.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
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
     * @return Response
     */
    public function show(ItemRequestForm $itemRequestForm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ItemRequestForm $itemRequestForm
     * @return Application|Factory|View
     */
    public function edit(ItemRequestForm $itemRequestForm)
    {
        $unitsOfMeasurement = UnitOfMeasurement::all();
        return view('request_form.item.edit', compact('itemRequestForm','unitsOfMeasurement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  ItemRequestForm  $itemRequestForm
     * @return RedirectResponse
     */
    public function update(Request $request, ItemRequestForm $itemRequestForm)
    {
        $itemRequestForm->update($request->all());
        return redirect()->route('request_forms.supply.purchase', $itemRequestForm->requestForm()->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ItemRequestForm  $itemRequestForm
     * @return Response
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
        if( Storage::exists($itemRequestForm->article_file) ) {
            return Storage::response($itemRequestForm->article_file);

        } 
        else {
            return redirect()->back()->with('warning', 'El archivo no se ha encontrado, considerar cargar nuevamente el archivo.');
        }
    }
}
