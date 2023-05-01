<?php

namespace App\Http\Controllers\Programmings;

use App\Models\Programmings\Programming;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Programmings\Review;
use App\Models\Programmings\CommuneFile;
use Illuminate\Support\Facades\Auth;

class ProgrammingReviewController extends Controller
{
    public function index(Programming $programming,Request $request)
    {
        $reviews = Review::where('commune_file_id',$request->commune_file_id)
                                       ->OrderBy('id')->get();
        
        $communeFile = CommuneFile::where('id',$request->commune_file_id)->first();


        return view('programmings.reviews.index')->withProgramming($programming)->withReview($reviews)->with('communeFile', $communeFile);
    }

    public function show($communeFile_id)
    {
        $communeFile = CommuneFile::with('programming_reviews.updatedBy:id,name,fathers_family,mothers_family')->findOrFail($communeFile_id);
        $communeFile->programming_status = Programming::where('year', $communeFile->year)->whereHas('establishment.commune', function($q) use ($communeFile){
            return $q->where('id', $communeFile->commune_id);
        })->first()->status;
        // return $communeFile;
        return view('programmings.reviews.show', compact('communeFile'));
    }

    public function update(Request $request,$id)
    {
       // DD($request);

        $review = Review::find($id);

        $review->fill($request->all());
        if($request->answer){
            $review->answer = $request->answer;
        }
        if($request->observation){
            $review->observation = $request->observation;
        }

        $review->updated_by = Auth::id();

        $review->save();
        session()->flash('info', 'El registro de evaluación se ha actualizado exitosamente');

        return redirect()->back();
    }

}
