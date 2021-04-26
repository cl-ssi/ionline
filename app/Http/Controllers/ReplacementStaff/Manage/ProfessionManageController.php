<?php

namespace App\Http\Controllers\ReplacementStaff\Manage;

use App\Models\ReplacementStaff\ProfessionManage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfessionManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $professionManage = ProfessionManage::orderBy('name', 'ASC')->get();
        return view('replacement_staff.manage.profession.index', compact('professionManage'));
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
        $professionManages = new professionManage($request->All());
        $professionManages->save();

        session()->flash('success', 'Se ha creado el perfil de estamento exitosamente');
        //return redirect()->back();
        return redirect()->route('replacement_staff.manage.profession.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProfessionManage  $professionManage
     * @return \Illuminate\Http\Response
     */
    public function show(ProfessionManage $professionManage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProfessionManage  $professionManage
     * @return \Illuminate\Http\Response
     */
    public function edit(ProfessionManage $professionManage)
    {
        return view('replacement_staff.manage.profession.edit', compact('professionManage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProfessionManage  $professionManage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProfessionManage $professionManage)
    {
        $professionManage->fill($request->all());
        $professionManage->save();
        session()->flash('success', 'La profesión '.$professionManage->name.' ha sido actualizada.');
        return redirect()->route('replacement_staff.manage.profession.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProfessionManage  $professionManage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProfessionManage $professionManage)
    {
        $professionManage->delete();

        session()->flash('danger', 'La profesión ha sido eliminado del sistema.');
        return redirect()->back();
    }
}
