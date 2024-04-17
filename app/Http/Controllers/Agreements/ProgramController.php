<?php

namespace App\Http\Controllers\Agreements;

use App\Models\Agreements\Program;
use App\Models\Agreements\Signer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $programs = Program::with('components')
                    ->when($request->program_name, function($q) use ($request){ return $q->where('name', 'LIKE', '%'.$request->program_name.'%'); })
                    ->orderBy('name')->get();
        return view('agreements.programs.index', compact('programs'));
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
     * @param  \App\Models\Agreements\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function show(Program $program)
    {
        $program->load('resolutions', 'components', 'budget_availabilities');
        $referrers = User::all()->sortBy('name');
        $signers = Signer::with('user')->get();
        return view('agreements.programs.show', compact('program', 'referrers', 'signers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agreements\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function edit(Program $program)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agreements\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Program $program)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agreements\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function destroy(Program $program)
    {
        //
    }
}
