<?php

namespace App\Http\Controllers\ReplacementStaff\Manage;

use App\Http\Controllers\Controller;
use App\Models\ReplacementStaff\RstFundamentManage;
use App\Models\ReplacementStaff\FundamentDetailManage;
use App\Models\ReplacementStaff\RstDetailFundament;
use Illuminate\Http\Request;

class RstFundamentManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fundaments = RstFundamentManage::all();
        return view('replacement_staff.manage.fundament.index', compact('fundaments'));
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
     * @param  \App\Models\RstFundamentManage  $rstFundamentManage
     * @return \Illuminate\Http\Response
     */
    public function show(RstFundamentManage $rstFundamentManage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RstFundamentManage  $rstFundamentManage
     * @return \Illuminate\Http\Response
     */
    public function edit(RstFundamentManage $rstFundamentManage)
    {
        $fundamentDetailManages = FundamentDetailManage::all();
        return view('replacement_staff.manage.fundament.edit',
            compact('rstFundamentManage','fundamentDetailManages'));
    }

    public function assign_fundament(Request $request, RstFundamentManage $rstFundamentManage){
        foreach ($request->fundament_detail_id as $key => $fundament_detail_id) {
            $rstDetailFundament = new RstDetailFundament();
            $rstDetailFundament->fundament_detail_id = $fundament_detail_id;
            $rstDetailFundament->fundament_manage_id = $rstFundamentManage->id;
            $rstDetailFundament->save();
        }

        return redirect()->route('replacement_staff.manage.fundament.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RstFundamentManage  $rstFundamentManage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RstFundamentManage $rstFundamentManage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RstFundamentManage  $rstFundamentManage
     * @return \Illuminate\Http\Response
     */
    public function destroy(RstFundamentManage $rstFundamentManage)
    {
        //
    }
}
