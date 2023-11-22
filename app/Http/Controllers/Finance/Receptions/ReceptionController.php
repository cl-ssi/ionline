<?php

namespace App\Http\Controllers\Finance\Receptions;

use App\Http\Controllers\Controller;
use App\Models\Finance\Receptions\Reception;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceptionController extends Controller
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
     * Display the specified resource.
     *
     * @param  \App\Models\Finance\Receptions\Reception  $reception
     * @return \Illuminate\Http\Response
     */
    public function show($reception_id)
    {
        $reception = Reception::find($reception_id);
        $establishment = $reception->creator->organizationalUnit->establishment;
        return Pdf::loadView('finance.receptions.show', [
            'reception' => $reception,
            'establishment' => $establishment
        ])->stream('download.pdf');

        // return view('finance.receptions.show', compact('reception'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Finance\Receptions\Reception  $reception
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reception $reception)
    {
        //
    }
}
