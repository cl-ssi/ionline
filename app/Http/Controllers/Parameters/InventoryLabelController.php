<?php


namespace App\Http\Controllers\Parameters;

use App\Models\Inv\InventoryLabel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryLabel\StoreInventoryLabelRequest;
use App\Http\Requests\InventoryLabel\UpdateInventoryLabelRequest;

class InventoryLabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($module)
    {
        $labels = InventoryLabel::where('module', $module)->get();
        return view('parameters.labels.index', compact('labels', 'module'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($module)
    {
        return view('parameters.labels.create', compact('module'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\InventoryLabel\StoreInventoryLabelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInventoryLabelRequest $request)
    {
        $module = $request->module;
        $dataValidated = $request->validated();
        $dataValidated['module'] = $module;
        InventoryLabel::create($dataValidated);
        session()->flash('success', 'Se ha guardado la etiqueta.');
        return redirect()->route('parameters.labels.index', $module);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inv\InventoryLabel  $inventoryLabel
     * @return \Illuminate\Http\Response
     */
    public function show(InventoryLabel $inventoryLabel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inv\InventoryLabel  $inventoryLabel
     * @return \Illuminate\Http\Response
     */
    public function edit(InventoryLabel $inventoryLabel)
    {
        return view('parameters.labels.edit', compact('inventoryLabel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\InventoryLabel\UpdateInventoryLabelRequest  $request
     * @param  \App\Models\Inv\InventoryLabel  $inventoryLabel
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInventoryLabelRequest $request, InventoryLabel $inventoryLabel)
    {
        $inventoryLabel->update($request->validated());
        $module = $request->module;

        session()->flash('info', 'La etiqueta ha sido editada.');
        return redirect()->route('parameters.labels.index',$module);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inv\InventoryLabel  $inventoryLabel
     * @return \Illuminate\Http\Response
     */
    public function destroy(InventoryLabel $inventoryLabel)
    {
        //
    }
}
