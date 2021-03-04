<?php

namespace App\Http\Controllers\ReplacementStaff\Manage;

use App\Models\ReplacementStaff\ProfileManage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profileManage = ProfileManage::all();
        return view('replacement_staff.manage.profile.index', compact('profileManage'));
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
      $profileManages = new ProfileManage($request->All());
      $profileManages->save();

      session()->flash('success', 'Se ha creado el perfil de estamento exitosamente');
      //return redirect()->back();
      return redirect()->route('replacement_staff.manage.profile.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProfileManage  $profileManage
     * @return \Illuminate\Http\Response
     */
    public function show(ProfileManage $profileManage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProfileManage  $profileManage
     * @return \Illuminate\Http\Response
     */
    public function edit(ProfileManage $profileManage)
    {
        return view('replacement_staff.manage.profile.edit', compact('profileManage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProfileManage  $profileManage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProfileManage $profileManage)
    {
        $profileManage->fill($request->all());
        $profileManage->save();
        session()->flash('success', 'El perfil de estamento '.$profileManage->name.' ha sido actualizado.');
        return redirect()->route('replacement_staff.manage.profile.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProfileManage  $profileManage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProfileManage $profileManage)
    {
        $profileManage->delete();

        session()->flash('danger', 'El perfil estamento ha sido eliminado del sistema.');
        return redirect()->back();
    }
}
