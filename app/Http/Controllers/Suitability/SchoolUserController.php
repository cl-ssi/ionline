<?php

namespace App\Http\Controllers\Suitability;

use App\Models\Suitability\SchoolUser;
use App\Models\Suitability\School;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SchoolUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //        
        $schoolusers = SchoolUser::all();
        $users = User::where('external',1)->orderBy('name')->get();
        $schools = School::all();
        return view('suitability.users.index', compact('schoolusers','users', 'schools'));
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
        $school_user = new SchoolUser($request->All());
        $school_user->save();

        session()->flash('success', 'Se Asigno al Usuario al colegio');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SchoolUser  $schoolUser
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolUser $schoolUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SchoolUser  $schoolUser
     * @return \Illuminate\Http\Response
     */
    public function edit(SchoolUser $schoolUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SchoolUser  $schoolUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchoolUser $schoolUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SchoolUser  $schoolUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolUser $schoolUser)
    {
        //
    }
}
