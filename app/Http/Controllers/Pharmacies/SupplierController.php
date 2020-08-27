<?php

namespace App\Http\Controllers\Pharmacies;

use App\Http\Controllers\Controller;
use App\Pharmacies\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$suppliers = Supplier::All();
        $suppliers = Supplier::where('pharmacy_id',session('pharmacy_id'))
                             ->orderBy('name', 'ASC')->paginate(50);
        //return view('pharmacies.suppliers.index', compact('suppliers'));
        return view('pharmacies.suppliers.index')->withSuppliers($suppliers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pharmacies.suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $supplier = new Supplier($request->All());
        $supplier->pharmacy_id = session('pharmacy_id');
        $supplier->save();

        session()->flash('info', 'El proveedor '.$supplier->name.' ha sido creado.');
        return redirect()->route('pharmacies.suppliers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pharmacies\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pharmacies\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        return view('pharmacies.suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pharmacies\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $supplier->fill($request->all());
        $supplier->save();

        session()->flash('info', 'El proveedor '.$supplier->name.' ha sido editado.');
        return redirect()->route('pharmacies.suppliers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pharmacies\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
