<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resources\Mobile;
use App\Http\Requests\Resources\StoreMobileRequest;
use App\Http\Requests\Resources\UpdateMobileRequest;
use App\Models\User;

class MobileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mobiles = Mobile::Search($request->get('search'))->paginate(50);
        return view('resources.mobile.index', compact('mobiles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('resources.mobile.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMobileRequest $request)
    {
        $mobile = new Mobile($request->All());
        $mobile->owner = $request->has('owner');
        $mobile->directory = $request->has('directory');
        $mobile->save();
        session()->flash('info', 'El Teléfono Móvil ' . $mobile->number . ' ha sido creado.');
        return redirect()->route('resources.mobile.index');
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
    public function edit(Mobile $mobile)
    {
        return view('resources.mobile.edit', compact('mobile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMobileRequest $request, Mobile $mobile)
    {
        //dd($request->all());
        $mobile->fill($request->all());
        $mobile->owner = $request->has('owner');
        $mobile->directory = $request->has('directory');
        $mobile->save();
        session()->flash('success', 'El Teléfono Movil ' . $mobile->number . ' ha sido actualizado.');
        return redirect()->route('resources.mobile.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mobile $mobile)
    {
        $mobile->delete();
        session()->flash('success', 'El Teléfono Móvil ' . $mobile->number . ' ha sido eliminado.');
        return redirect()->route('resources.mobile.index');
    }
}
