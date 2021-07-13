<?php

namespace App\Http\Controllers\Agreements;

use App\Agreements\Program;
use App\Http\Controllers\Controller;
use App\Agreements\ProgramResolution;
use App\Agreements\ProgramResolutionAmount;
use App\Agreements\Signer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramResolutionController extends Controller
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
        $program = Program::findOrFail($request->program_id);
        $program_resolution = $program->resolutions()->create($request->all());

        foreach($program->components as $component)
            $program_resolution->resolution_amounts()->create(['subtitle' => null, 'amount' => 0, 'program_component_id' => $component->id]);

        session()->flash('info', 'La nueva resolución ha sido creada.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Agreements\ProgramResolution  $programResolution
     * @return \Illuminate\Http\Response
     */
    public function show($programResolutionId)
    {
        $program_resolution = ProgramResolution::findOrFail($programResolutionId);
        $program_resolution->load('resolution_amounts', 'program', 'director_signer', 'referrer');
        // return $program_resolution;
        $referrers = User::all()->sortBy('name');
        $signers = Signer::with('user')->get();
        return view('agreements.programs.resolutions.show', compact('program_resolution', 'referrers', 'signers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agreements\ProgramResolution  $programResolution
     * @return \Illuminate\Http\Response
     */
    public function edit(ProgramResolution $programResolution)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agreements\ProgramResolution  $programResolution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $programResolutionId)
    {
        $program_resolution = ProgramResolution::findOrFail($programResolutionId);
        $program_resolution->update($request->All());
        if($request->hasFile('file')){
            Storage::delete($program_resolution->file);
            $program_resolution->file = $request->file('file')->store('resolutions');
        }
        $program_resolution->save();

        session()->flash('info', 'La resolución #'.$program_resolution->id.' ha sido actualizado.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agreements\ProgramResolution  $programResolution
     * @return \Illuminate\Http\Response
     */
    public function destroy($programResolutionId)
    {
        ProgramResolution::findOrFail($programResolutionId)->delete();
        session()->flash('success', 'La resolución se ha dado de baja satisfactoriamente');
        return redirect()->back();
    }

    public function download(ProgramResolution $program_resolution)
    {
        return Storage::response($program_resolution->file, mb_convert_encoding($program_resolution->number,'ASCII'));
    }

    public function storeAmount(Request $request, ProgramResolution $program_resolution)
    {
        $program_resolution->resolution_amounts()->create($request->all());
        session()->flash('info', 'El nuevo monto ha sido registrado.');
        return redirect()->back();
    }

    public function updateAmount(Request $request, ProgramResolutionAmount $resolution_amount)
    {
        $resolution_amount->update($request->all());
        session()->flash('info', 'El monto ha sido actualizado.');
        return redirect()->back();
    }

    public function destroyAmount($resolutionAmountId)
    {
        ProgramResolutionAmount::findOrFail($resolutionAmountId)->delete();
        session()->flash('success', 'El monto ha sido eliminado de esta resolución');
        return redirect()->back();
    }
}
