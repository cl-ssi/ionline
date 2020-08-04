<?php

namespace App\Http\Controllers\Rrhh;

use App\Http\Controllers\Controller;
use App\User;
use App\Rrhh\OrganizationalUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::Search($request->get('name'))->orderBy('name','Asc')->paginate(500);
        return view('rrhh.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ouRoot = OrganizationalUnit::find(1);
        return view('rrhh.create')->withOuRoot($ouRoot);
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
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $ouRoot = OrganizationalUnit::find(1);
        return view('rrhh.edit')
            ->withUser($user)
            ->withOuRoot($ouRoot);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->fill($request->all());

        if ($request->has('organizationalunit')) {
            if ($request->filled('organizationalunit')) {
                $user->organizationalunit()->associate($request->input('organizationalunit'));
            }
            else {
                $user->organizationalunit()->dissociate();
            }
        }

        $user->save();

        session()->flash('success', 'El usuario '.$user->name.' ha sido actualizado.');

        return redirect()->route('rrhh.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        /* Primero Limpiamos todos los roles */
        $user->roles()->detach();

        $user->delete();

        session()->flash('success', 'El usuario '.$user->name.' ha sido eliminado');

        return redirect()->route('rrhh.users.index');
    }

    public function switch(User $user) {
        if (session()->has('god')) {
            /* Clean session var */
            session()->pull('god');
        }
        else {
            /* set god session var = user_id */
            session(['god' => Auth::id()]);
        }

        Auth::login($user);
        return back();
    }
}
