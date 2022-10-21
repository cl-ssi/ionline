<?php

namespace App\Http\Controllers\Rem;

use App\Models\Rem\UserRem;
use App\Http\Controllers\Controller;

class UserRemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $userrem = UserRem::All();
        return view('rem/user/index', compact('userrem'));
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
     * @param  \App\Http\Requests\StoreUserRemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRem $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rem\UserRem  $userRem
     * @return \Illuminate\Http\Response
     */
    public function show(UserRem $userRem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rem\UserRem  $userRem
     * @return \Illuminate\Http\Response
     */
    public function edit(UserRem $userRem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRemRequest  $request
     * @param  \App\Models\Rem\UserRem  $userRem
     * @return \Illuminate\Http\Response
     */
    public function update(UserRem $request, UserRem $userRem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rem\UserRem  $userRem
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserRem $userRem)
    {
        //
    }
}
