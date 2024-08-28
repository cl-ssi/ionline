<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Documents\Approval;
use App\Models\Finance\Cdp;
use App\Models\Parameters\Parameter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CdpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\Finance\Cdp  $cdp
     * @return \Illuminate\Http\Response
     */
    public function show($cdp)
    {
        $cdp = $cdp instanceof Cdp ? $cdp : Cdp::find($cdp);
        $establishment = $cdp->establishment;
        return Pdf::loadView('finance.cdp.show', compact('cdp','establishment'))->stream('download.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Finance\Cdp  $cdp
     * @return \Illuminate\Http\Response
     */
    public function edit(Cdp $cdp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Finance\Cdp  $cdp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cdp $cdp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Finance\Cdp  $cdp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cdp $cdp)
    {
        //
    }

    public function approvalCallback($approval_id) 
    {
        $approval = Approval::find($approval_id);

        if($approval->status === true) {
            $approval->approvable->numeration()->create([
                'automatic' => true,
                'doc_type_id' => Parameter::get('Cdp','doc_type_id'),
                'file_path' => $approval->filename,
                'subject' => "Certificado de Disponibilidad Presupuestaria",
                'user_id' => $approval->approver_id, // Responsable del documento numerado
                'organizational_unit_id' => $approval->approver_ou_id, // Ou del responsable
                'establishment_id' => $approval->approverOu->establishment_id,
            ]);
        }
        else {
            logger()->info('Rechazado: id ' . $approval->id. ' motivo '. $approval->approver_observation);
        }
    }
}
