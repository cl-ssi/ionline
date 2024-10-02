<?php

namespace App\Http\Controllers\PurchasePlan;

use App\Models\PurchasePlan\PurchasePlan;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Documents\Approval;
use App\Models\Parameters\Parameter;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PurchasePlanController extends Controller
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

    public function own_index()
    {
        return view('purchase_plan.own_index');
    }

    public function all_index()
    {
        return view('purchase_plan.all_index');
    }

    public function pending_index()
    {
        return view('purchase_plan.pending_index');
    }

    public function assign_purchaser_index()
    {
        return view('purchase_plan.assign_purchaser_index');
    }

    public function my_assigned_plans_index()
    {
        return view('purchase_plan.my_assigned_plans_index');
    }

    public function show_ppl_items(){
        return view('purchase_plan.reports.show_ppl_items');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('purchase_plan.create');
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
     * @param  \App\Models\PurchasePlan\PurchasePlan  $purchasePlan
     * @return \Illuminate\Http\Response
     */
    public function show(PurchasePlan $purchasePlan)
    {
        return view('purchase_plan.show', compact('purchasePlan'));
    }

    public function show_approval($purchase_plan_id)
    {
        $purchasePlan = PurchasePlan::find($purchase_plan_id);
        return view('purchase_plan.show_approval', compact('purchasePlan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchasePlan\PurchasePlan  $purchasePlan
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchasePlan $purchasePlan)
    {
        return view('purchase_plan.edit', compact('purchasePlan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchasePlan\PurchasePlan  $purchasePlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchasePlan $purchasePlan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchasePlan\PurchasePlan  $purchasePlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchasePlan $purchasePlan)
    {
        $purchasePlan->delete();
        session()->flash('success', 'Estimado Usuario, se ha eliminado exitosamente el plan de compra');
        return redirect()->back();
    }

    public function send(PurchasePlan $purchasePlan)
    {
        if($purchasePlan->status == 'sent'){
            session()->flash('warning', 'Ya se ha iniciado proceso aprobación para este plan de compras.');
            return redirect()->back();
        }
        
        $purchasePlan->load('purchasePlanItems', 'organizationalUnit');
        if(!$purchasePlan->hasDistributionCompleted()){
            session()->flash('warning', 'No se ha iniciado proceso de aprobación ya que presenta items sin completar detalle de distribución.');
            return redirect()->back();
        }

        /* APROBACION CORRESPONDIENTE A JEFATURA DEPARTAMENTO O UNIDAD */
        $prev_approval = $purchasePlan->approvals()->create([
            "module"                        => "Plan de Compras",
            "module_icon"                   => "fas fa-shopping-cart",
            "subject"                       => 'Solicitud de Aprobacion Jefatura <br>'.
                                                '<small><b>Asunto</b>: '.$purchasePlan->subject.'<br>'.
                                                '<b>Subtitulo</b>: '.$purchasePlan->program.'</small>',
            "sent_to_ou_id"                 => $purchasePlan->organizational_unit_id,
            "document_route_name"           => "purchase_plan.show_approval",
            "document_route_params"         => json_encode(["purchase_plan_id" => $purchasePlan->id]),
            "active"                        => true,
            "callback_controller_method"    => "App\Http\Controllers\PurchasePlan\PurchasePlanController@approvalCallback",
            "callback_controller_params"    => json_encode([
                'purchase_plan_id'  => $purchasePlan->id,
                "process"           => null
            ])
        ]);
    
        if(in_array($purchasePlan->organizationalUnit->establishment_id, explode(',', Parameter::get('establishment', 'EstablecimientosDispositivos')))){
            /* APROBACION CORRESPONDIENTE A JEFATURA DEPARTAMENTO SALUD MENTAL EN CASO DE SER GESTIONADO POR ESTABLECIMIENTOS Y DISPOSITIVOS */
            $prev_approval = $purchasePlan->approvals()->create([
                "module"                        => "Plan de Compras",
                "module_icon"                   => "fas fa-shopping-cart",
                "subject"                       => 'Solicitud de Aprobacion Jefatura Depto. Salud Mental<br>'.
                                                    '<small><b>Asunto</b>: '.$purchasePlan->subject.'<br>'.
                                                    '<b>Subtitulo</b>: '.$purchasePlan->program.'</small>',
                "sent_to_ou_id"                 => Parameter::get('ou', 'SaludMentalSSI'),
                "document_route_name"           => "purchase_plan.show_approval",
                "document_route_params"         => json_encode(["purchase_plan_id" => $purchasePlan->id]),
                "previous_approval_id"          => $prev_approval->id,
                "active"                        => false,
                "callback_controller_method"    => "App\Http\Controllers\PurchasePlan\PurchasePlanController@approvalCallback",
                "callback_controller_params"    => json_encode([
                    'purchase_plan_id'  => $purchasePlan->id,
                    "process"           => null
                ]),
            ]);
        }

        /* APROBACION CORRESPONDIENTE A ABASTECIMIENTO */
        $prev_approval = $purchasePlan->approvals()->create([
            "module"                        => "Plan de Compras",
            "module_icon"                   => "fas fa-shopping-cart",
            "subject"                       => 'Solicitud de Aprobacion Abastecimiento<br>'.
                                                '<small><b>Asunto</b>: '.$purchasePlan->subject.'<br>'.
                                                '<b>Subtitulo</b>: '.$purchasePlan->program.'</small>',
            "sent_to_ou_id"                 => Parameter::get('ou', 'AbastecimientoSSI'),
            "document_route_name"           => "purchase_plan.show_approval",
            "document_route_params"         => json_encode(["purchase_plan_id" => $purchasePlan->id]),
            "previous_approval_id"          => $prev_approval->id,
            "active"                        => false,
            "callback_controller_method"    => "App\Http\Controllers\PurchasePlan\PurchasePlanController@approvalCallback",
            "callback_controller_params"    => json_encode([
                'purchase_plan_id'  => $purchasePlan->id,
                "process"           => null
            ]),
        ]);

        /* APROBACION CORRESPONDIENTE A FINANZAS */
        $prev_approval = $purchasePlan->approvals()->create([
            "document_route_name"           => "purchase_plan.show_approval",
            "document_route_params"         => json_encode(["purchase_plan_id" => $purchasePlan->id]),
            "previous_approval_id"          => $prev_approval->id,
            "active"                        => false,
            "callback_controller_method"    => "App\Http\Controllers\PurchasePlan\PurchasePlanController@approvalCallback",
            "callback_controller_params"    => json_encode([
                'purchase_plan_id'  => $purchasePlan->id,
                "process"           => null
            ]),

            "module"                => "Plan de Compras",
            "module_icon"           => "fas fa-shopping-cart",
            "subject"               => 'Solicitud de Aprobacion Depto. Gestion Financiera<br>'.
                                        '<small><b>Asunto</b>: '.$purchasePlan->subject.'<br>'.
                                        '<b>Subtitulo</b>: '.$purchasePlan->program.'</small>',
            "sent_to_ou_id"         => Parameter::get('ou', 'FinanzasSSI'),
            "document_route_name"   => "purchase_plan.documents.show_purchase_plan_pdf",
            "document_route_params" => json_encode(["purchase_plan_id" => $purchasePlan->id]),
            "active"                => false,
            "previous_approval_id"  => $prev_approval->id,
            "position"              => "right",
            "start_y"               => -30,
            "filename"              => "ionline/purchase_plan/pdf/".$purchasePlan->id.".pdf",
            "digital_signature"     => true,
            "callback_controller_method"        => "App\Http\Controllers\PurchasePlan\PurchasePlanController@approvalCallback",
            "callback_controller_params"        => json_encode([
                'purchase_plan_id'  => $purchasePlan->id,
                'process'           => 'end'
            ]),
        ]);

        /* APROBACION CORRESPONDIENTE A SDA

        SE ELIMINA 02-10-2024 

        $prev_approval = $purchasePlan->approvals()->create([
            "module"                => "Plan de Compras",
            "module_icon"           => "fas fa-shopping-cart",
            "subject"               => 'Solicitud de Aprobacion Subdir. Recursos Fisicos y Financieros<br>'.
                                        '<small><b>Asunto</b>: '.$purchasePlan->subject.'<br>'.
                                        '<b>Subtitulo</b>: '.$purchasePlan->program.'</small>',
            "sent_to_ou_id"         => Parameter::get('ou', 'SDASSI'),
            "document_route_name"   => "purchase_plan.documents.show_purchase_plan_pdf",
            "document_route_params" => json_encode(["purchase_plan_id" => $purchasePlan->id]),
            "active"                => false,
            "previous_approval_id"  => $prev_approval->id,
            "position"              => "right",
            "start_y"               => -30,
            "filename"              => "ionline/purchase_plan/pdf/".$purchasePlan->id.".pdf",
            "digital_signature"     => true,
            "callback_controller_method"        => "App\Http\Controllers\PurchasePlan\PurchasePlanController@approvalCallback",
            "callback_controller_params"        => json_encode([
                'purchase_plan_id'  => $purchasePlan->id,
                'process'           => 'end'
            ]),
        ]);
        */

        $purchasePlan->update(['status' => 'sent']);

        session()->flash('success', 'Estimado Usuario, se ha enviado el plan de compra con éxito para su proceso de aprobación.');
        return redirect()->back();
    }

    public function show_purchase_plan_pdf($purchase_plan_id){
        $purchasePlan = PurchasePlan::find($purchase_plan_id);
        $establishment = $purchasePlan->organizationalUnit->establishment;
        return Pdf::loadView('purchase_plan.documents.purchase_plan_pdf', [
            'purchasePlan' => $purchasePlan,
            'establishment' => $establishment
        ])->stream('download.pdf');
    }

    public function approvalCallback($approval_id, $purchase_plan_id, $process){
        $approval = Approval::find($approval_id);
        $purchasePlan = PurchasePlan::find($purchase_plan_id);
        
        /* Aprueba */
        if($approval->status == 1){
            if($process == 'end'){
                $purchasePlan->status = 'approved';
                $purchasePlan->save();
            }
        }

        /* Rechaza */
        if($approval->status == 0){
            $purchasePlan->status = 'rejected';
            $purchasePlan->save();

        }
    }

    public function download_resol_pdf(PurchasePlan $purchasePlan)
    {
        if( Storage::exists($purchasePlan->approvals->last()->filename) ) {
            return Storage::response($purchasePlan->approvals->last()->filename);
        } 
        else {
            return redirect()->back()->with('warning', 'El archivo no se ha encontrado.');
        }
    }
}
