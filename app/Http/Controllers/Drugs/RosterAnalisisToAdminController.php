<?php

namespace App\Http\Controllers\Drugs;

use App\Models\Drugs\RosterAnalisisToAdmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RosterAnalisisToAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rosters = RosterAnalisisToAdmin::All();

        dd($rosters);
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
     * @param  \App\Models\Drugs\RosterAnalisisToAdmin  $rosterAnalisisToAdmin
     * @return \Illuminate\Http\Response
     */
    public function show(RosterAnalisisToAdmin $rosterAnalisisToAdmin)
    {
        //$rosters = RosterAnalisisToAdmin::Find();

        dd($rosters);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Drugs\RosterAnalisisToAdmin  $rosterAnalisisToAdmin
     * @return \Illuminate\Http\Response
     */
    public function edit(RosterAnalisisToAdmin $rosterAnalisisToAdmin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Drugs\RosterAnalisisToAdmin  $rosterAnalisisToAdmin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RosterAnalisisToAdmin $rosterAnalisisToAdmin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Drugs\RosterAnalisisToAdmin  $rosterAnalisisToAdmin
     * @return \Illuminate\Http\Response
     */
    public function destroy(RosterAnalisisToAdmin $rosterAnalisisToAdmin)
    {
        //
    }
}
