<?php

namespace App\Http\Controllers\Resources;

use App\Models\Resources\Computer;
use App\Models\User;
use App\Models\Parameters\Place;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Resources\StoreComputerRequest;
use App\Http\Requests\Resources\UpdateComputerRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ComputersExport;

class ComputerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $totales['notebook']['leased'] = Computer::where('type', 'notebook')->where('active_type', 'leased')->count();
        $totales['notebook']['own'] = Computer::where('type', 'notebook')->where('active_type', 'own')->count();
        $totales['notebook']['user'] = Computer::where('type', 'notebook')->where('active_type', 'user')->count();

        $totales['desktop']['leased'] = Computer::where('type', 'desktop')->where('active_type', 'leased')->count();
        $totales['desktop']['own'] = Computer::where('type', 'desktop')->where('active_type', 'own')->count();
        $totales['desktop']['user'] = Computer::where('type', 'desktop')->where('active_type', 'user')->count();

        $totales['all-in-one']['leased'] = Computer::where('type', 'all-in-one')->where('active_type', 'leased')->count();
        $totales['all-in-one']['own'] = Computer::where('type', 'all-in-one')->where('active_type', 'own')->count();
        $totales['all-in-one']['user'] = Computer::where('type', 'all-in-one')->where('active_type', 'user')->count();

        $totales['other']['leased'] = Computer::where('type', 'other')->where('active_type', 'leased')->count();
        $totales['other']['own'] = Computer::where('type', 'other')->where('active_type', 'own')->count();
        $totales['other']['user'] = Computer::where('type', 'other')->where('active_type', 'user')->count();

        $totalMerged["merged"] = Computer::whereNotNull('fusion_at')->count();
        $totalMerged["not_merged"] = Computer::whereNull('fusion_at')->count();

        $computers = Computer::Search($request->get('search'))
            ->with('users', 'place')
            ->paginate(50);

        return view('resources.computer.index', compact('computers', 'totales', 'totalMerged'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::OrderBy('name')->get();
        $places = Place::All();
        return view('resources.computer.create', compact('users', 'places'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComputerRequest $request)
    {
        $computer = new computer($request->All());
        $computer->save();
        $computer->users()->sync($request->input('users'));
        session()->flash('info', 'El computador ' . $computer->brand . ' ha sido creado.');
        return redirect()->route('resources.computer.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resources\Computer  $computer
     * @return \Illuminate\Http\Response
     */
    public function show(Computer $computer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resources\Computer  $computer
     * @return \Illuminate\Http\Response
     */
    public function edit(Computer $computer)
    {
        $users = User::with('computers')
            ->orderBy('name')
            ->get();
        $places = Place::with('location')
            ->get();
        //$computer = new Computer;
        return view('resources.computer.edit', compact('computer', 'users', 'places'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resources\Computer  $computer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateComputerRequest $request, Computer $computer)
    {
        $computer->fill($request->all());
        $computer->save();
        $computer->users()->sync($request->input('users'));
        session()->flash('success', 'El computador ' . $computer->brand . ' ha sido actualizado.');
        return redirect()->route('resources.computer.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resources\Computer  $computer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Computer $computer)
    {
        $computer->delete();
        session()->flash('success', 'El computador ' . $computer->brand . ' ha sido eliminado');
        return redirect()->route('resources.computer.index');
    }

    public function export()
    {
        return Excel::download(new ComputersExport, 'recursos-computadores-listado.xlsx');
    }
}
