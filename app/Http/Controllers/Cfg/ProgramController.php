<?php

namespace App\Http\Controllers\Cfg;

use App\Http\Controllers\Controller;
use App\Models\Cfg\Program;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cfg.programs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cfg.programs.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cfg\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function edit(Program $program)
    {
        return view('cfg.programs.edit', compact('program'));
    }
}
