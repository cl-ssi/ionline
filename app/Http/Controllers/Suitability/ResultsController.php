<?php

namespace App\Http\Controllers\Suitability;

use App\Models\Suitability\Result;
use App\Models\Suitability\School;
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
    public function index(Request $request)
    {
        
        $school_id = $request->colegio;
        $estado = $request->estado;

        $results = Result::when($school_id != null, function ($q) use ($school_id) 
        {
            return $q->whereHas("psirequest", function ($subQuery) use ($school_id) {
                $subQuery->where('school_id', $school_id);
              });

        })
        ->when($estado, function($q) use ($estado){
            return $q->whereHas("psirequest", function ($subQuery) use ($estado) {
                $subQuery->where('status', $estado);
              });
        })
        ->with('psirequest.school', 'user')
        ->get();

        $count = $results->countBy('psirequest.status');
        
        $schools = School::orderBy("name", "asc")->get();
        

        return view('suitability.results.index', compact('results','schools','school_id', 'estado', 'count'));
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
    public function destroy(Result $result)
    {
        $result->delete();
        session()->flash('danger', 'El resultado de test de idoneidad ha sido eliminado');
        return redirect()->back();
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
