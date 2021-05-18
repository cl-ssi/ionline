<?php

namespace App\Http\Controllers\Suitability;

use App\Models\Suitability\Result;
use App\Models\Suitability\Question;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResultsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$results = Result::orderBy("request_id", "asc")->get();
        $results = Result::orderBy("request_id", "asc")->get();
        //$results = Result::with("psirequest", "asc")->get();
        //$results = Result::with("psirequest")->orderBy("Result.psirequest.school_id", "asc")->get();
        return view('suitability.results.index', compact('results'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $result = Result::find($id);
        $questions = Question::all();
        return view('suitability.results.show', compact('result','questions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function certificate($id)
    {
        //
        $result = Result::find($id);
        return view('suitability.results.certificate', compact('result'));
    }

    public function certificatepdf($id)
    {
        //
        $result = Result::find($id);
        $pdf = \PDF::loadView('suitability.results.certificate', compact('result'));
        return $pdf->download('Certificado de Idoneidad '.$result->user->fullName.'.pdf');
    }
}
