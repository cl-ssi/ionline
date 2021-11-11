<?php

namespace App\Http\Controllers\ReplacementStaff\Manage;

use App\Http\Controllers\Controller;
use App\Models\ReplacementStaff\LegalQualityManage;
use App\Models\ReplacementStaff\RstFundamentManage;
use App\Models\ReplacementStaff\FundamentLegalQuality;
use Illuminate\Http\Request;

class LegalQualityManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $legalQualityManages = LegalQualityManage::all();
        return view('replacement_staff.manage.legal_quality.index', compact('legalQualityManages'));
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
     * @param  \App\Models\LegalQualityManage  $legalQualityManage
     * @return \Illuminate\Http\Response
     */
    public function show(LegalQualityManage $legalQualityManage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LegalQualityManage  $legalQualityManage
     * @return \Illuminate\Http\Response
     */
    public function edit(LegalQualityManage $legalQualityManage)
    {
        $fundamentManages = RstFundamentManage::all();
        return view('replacement_staff.manage.legal_quality.edit',
            compact('legalQualityManage','fundamentManages'));
    }

    public function assign_fundament(Request $request, LegalQualityManage $legalQualityManage){
        $fundamentLegalQuality = new FundamentLegalQuality();

        foreach ($request->fundament_manage_id as $key => $fundament_manage_id) {
            $fundamentLegalQuality = new FundamentLegalQuality();
            $fundamentLegalQuality->fundament_manage_id = $fundament_manage_id;
            $fundamentLegalQuality->legal_quality_manage_id = $legalQualityManage->id;
            $fundamentLegalQuality->save();
        }

        return redirect()->route('replacement_staff.manage.legal_quality.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LegalQualityManage  $legalQualityManage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LegalQualityManage $legalQualityManage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LegalQualityManage  $legalQualityManage
     * @return \Illuminate\Http\Response
     */
    public function destroy(LegalQualityManage $legalQualityManage)
    {
        //
    }
}
