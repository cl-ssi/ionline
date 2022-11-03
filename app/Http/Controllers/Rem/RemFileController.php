<?php

namespace App\Http\Controllers\Rem;

use App\Http\Controllers\Controller;
use App\Models\Rem\RemFile;
use App\Models\Rem\UserRem;
use Illuminate\Http\Request;
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
        //
        //dd('en el index');
        $dates = CarbonPeriod::create(
            Carbon::parse('next month')->startOfMonth()->subYear(),
            '1 month',
            Carbon::now()->startOfMonth()
        )->map(function($date) {
            return [
                'month' => $date->format('M'),
                'year' => $date->format('Y')
            ];
        });

        $usersRem = UserRem::where('user_id', auth()->id())->get();

        //dd($dates);
        
        //iterator_to_array($dates);
        //or
        //collect($dates)->toArray();
        //dd(iterator_to_array($dates));

        return view('rem.file.index', compact('dates','usersRem'));


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
