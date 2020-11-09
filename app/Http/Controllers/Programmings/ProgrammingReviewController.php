<?php

namespace App\Http\Controllers\Programmings;

use App\Programmings\Programming;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Programmings\Review;

class ProgrammingReviewController extends Controller
{
    public function index(Programming $programming,Request $request)
    {
        $reviews = Review::where('programming_id',$request->programming_id)
                                       ->OrderBy('id')->get();

        return view('programmings/reviews/index')->withProgramming($programming)->withReview($reviews);
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
