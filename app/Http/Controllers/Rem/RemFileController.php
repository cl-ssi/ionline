<?php

namespace App\Http\Controllers\Rem;

use App\Http\Controllers\Controller;
use App\Models\Rem\RemFile;
use App\Models\Rem\UserRem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Establishment;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class RemFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
               
        $now = now()->startOfMonth();
        
        for($i=1; $i<=12; $i++)
        {
            $this->rango[] = $now->clone();
            $now->subMonth('1');
        }

        $dates = $this->rango;
        $rem_establishments = auth()->user()->remEstablishments;

        return view('rem.file.index', compact('dates','rem_establishments'));


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
     * @param  \App\Models\RemFile  $remFile
     * @return \Illuminate\Http\Response
     */
    public function show(RemFile $remFile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RemFile  $remFile
     * @return \Illuminate\Http\Response
     */
    public function edit(RemFile $remFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RemFile  $remFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RemFile $remFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RemFile  $remFile
     * @return \Illuminate\Http\Response
     */
    public function destroy(RemFile $remFile)
    {
        //
    }
}
