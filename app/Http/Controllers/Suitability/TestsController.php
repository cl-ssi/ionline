<?php

namespace App\Http\Controllers\Suitability;

use App\Models\Suitability\Category;
use App\Models\Suitability\Option;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTestRequest;
use App\Models\Suitability\PsiRequest;

class TestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function welcome()
    {
        //
        return view('suitability.welcome');
    }


    public function index($psi_request_id)
    {
        //
        $categories = Category::with(['categoryQuestions' => function ($query) {
            $query->inRandomOrder()
                ->with(['questionOptions' => function ($query) {
                    $query->inRandomOrder();
                }]);
        }])
        ->whereHas('categoryQuestions')
        ->get();

    // return view('suitability.test', compact('categories','psi_request_id'));
    return view('external.suitability.test', compact('categories','psi_request_id'));
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
    // public function store(Request $request)
    // {
    //     //
    //     $options = Option::find(array_values($request->input('questions')));

    //     $result = auth()->user()->userResults()->create([
    //         'total_points' => $options->sum('points'),
    //         'request_id' => $request->input('psi_request_id')
    //     ]);
    //     $valor = $request->input('psi_request_id');
    //     $questions = $options->mapWithKeys(function ($option) use ($valor) {
    //         return [$option->question_id => [
    //                     'option_id' => $option->id,
    //                     'points' => $option->points,
    //                     'request_id' => $valor
    //                     //'request_id' => '1'
    //                     //'request_id' => 1
    //                 ]
    //             ];
    //         })->toArray();

    //     $result->questions()->sync($questions);


    //     $psirequests = PsiRequest::find($request->input('psi_request_id'));
    //     $psirequests->status = "Test Finalizado";
    //     $psirequests->update();


    //     session()->flash('success', 'Finalizó el Test Exitosamente');
    //     return redirect()->route('suitability.welcome');

    //     //return redirect()->route('client.results.show', $result->id);
    // }


    public function storeExternal(Request $request)
    {
        //
        $options = Option::find(array_values($request->input('questions')));

        $result = auth()->user()->userResults()->create([
            'total_points' => $options->sum('points'),
            'request_id' => $request->input('psi_request_id')
        ]);

        $request_id = $request->input('psi_request_id');

        $questions = $options->mapWithKeys(function ($option) use ($request_id) {
            return [$option->question_id => [
                        'option_id' => $option->id,
                        'points' => $option->points,
                        'request_id' => $request_id
                    ]
                ];
            })->toArray();

        $result->questions()->sync($questions);


        $psirequests = PsiRequest::find($request->input('psi_request_id'));
        $psirequests->status = "Test Finalizado";
        $psirequests->update();


        session()->flash('success', 'Finalizó el Test Exitosamente');
        return redirect()->route('external');
        
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

    public function updateStatus($psirequestid)
    {
        
        $psirequest = PsiRequest::find($psirequestid);
        $psirequest->status = 'Realizando Test';        
        $psirequest->save();
        return $this->index($psirequestid);
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
}
