<?php

namespace App\Http\Controllers\Drugs;

use App\Http\Controllers\Controller;
use App\Models\Drugs\Protocol;
use App\Models\Establishment;
use App\Models\Parameters\Parameter;
use Illuminate\Http\Request;

class ProtocolController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Drugs\Protocol  $protocol
     * @return \Illuminate\Http\Response
     */
    public function show($protocol)
    {
        // if $proctols is integer then find the protocol object
        if (is_numeric($protocol)) {
            $protocol = Protocol::find($protocol);
        }

        $manager_position = Parameter::get('drugs','Jefe');
        $establishment = Establishment::find(38);

        $documentFile = \PDF::loadView('drugs.protocols.show', compact('protocol','manager_position','establishment'));

        return $documentFile->stream();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Drugs\Protocol  $protocol
     * @return \Illuminate\Http\Response
     */
    public function destruction(Protocol $protocol)
    {
        $manager_position = Parameter::get('drugs','Jefe');
        $establishment = Establishment::find(38);

        $documentFile = \PDF::loadView('drugs.protocols.destruction', compact('protocol','manager_position','establishment'));

        return $documentFile->stream();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Drugs\Protocol  $protocol
     * @return \Illuminate\Http\Response
     */
    public function edit(Protocol $protocol)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Drugs\Protocol  $protocol
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Protocol $protocol)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Drugs\Protocol  $protocol
     * @return \Illuminate\Http\Response
     */
    public function destroy(Protocol $protocol)
    {
        //
    }
}
