<?php

namespace App\Http\Controllers\Programmings;

use App\Programmings\Programming;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Programmings\Review;
use App\Models\Programmings\CommuneFile;

class ProgrammingReviewController extends Controller
{
    public function index(Programming $programming,Request $request)
    {
        $reviews = Review::where('commune_file_id',$request->commune_file_id)
                                       ->OrderBy('id')->get();
        
        $communeFile = CommuneFile::where('id',$request->commune_file_id)->first();


        return view('programmings/reviews/index')->withProgramming($programming)->withReview($reviews)->with('communeFile', $communeFile);
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

        $review->save();

        return redirect()->back();
    }

}
