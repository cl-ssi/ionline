<?php

namespace App\Http\Controllers\PurchasePlan;

use App\Models\PurchasePlan\PurchasePlan;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Parameters\Parameter;

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
            "module"                => "Plan de Compras",
            "module_icon"           => "fas fa-shopping-cart",
            "subject"               => "Solicitud de Aprobación Jefatura",
            "sent_to_ou_id"        => $purchasePlan->organizational_unit_id,
            "document_route_name"   => "purchase_plan.show_approval",
            "document_route_params" => json_encode(["purchase_plan_id" => $purchasePlan->id])
        ]);

        if(in_array($purchasePlan->organizationalUnit->establishment_id, explode(',', Parameter::get('establishment', 'EstablecimientosDispositivos')))){
            /* APROBACION CORRESPONDIENTE A JEFATURA DEPARTAMENTO SALUD MENTAL EN CASO DE SER GESTIONADO POR ESTABLECIMIENTOS Y DISPOSITIVOS */
            $prev_approval = $purchasePlan->approvals()->create([
                "module"                => "Plan de Compras",
                "module_icon"           => "fas fa-shopping-cart",
                "subject"               => "Solicitud de Aprobación Jefatura Depto. Salud Mental",
                "sent_to_ou_id"         => Parameter::get('ou', 'SaludMentalSSI'),
                "document_route_name"   => "purchase_plan.show_approval",
                "document_route_params" => json_encode(["purchase_plan_id" => $purchasePlan->id])
            ]);
        }

        /* APROBACION CORRESPONDIENTE A ABASTECIMIENTO */
        $prev_approval = $purchasePlan->approvals()->create([
            "module"                => "Plan de Compras",
            "module_icon"           => "fas fa-shopping-cart",
            "subject"               => "Solicitud de Aprobación Abastecimiento",
            "sent_to_ou_id"        => Parameter::where('module', 'ou')->where('parameter', 'AbastecimientoSSI')->first()->value,
            "document_route_name"   => "purchase_plan.show_approval",
            "document_route_params" => json_encode(["purchase_plan_id" => $purchasePlan->id]),
            "previous_approval_id"  => $prev_approval->id,
            "active"                => false
        ]);

        /* APROBACION CORRESPONDIENTE A FINANZAS */
        $prev_approval = $purchasePlan->approvals()->create([
            "module"                => "Plan de Compras",
            "module_icon"           => "fas fa-shopping-cart",
            "subject"               => "Solicitud de Aprobación Depto. Gestión Financiera",
            "sent_to_ou_id"        => Parameter::where('module', 'ou')->where('parameter', 'FinanzasSSI')->first()->value,
            "document_route_name"   => "purchase_plan.show_approval",
            "document_route_params" => json_encode(["purchase_plan_id" => $purchasePlan->id]),
            "previous_approval_id"  => $prev_approval->id,
            "active"                => false
        ]);

        /* APROBACION CORRESPONDIENTE A SDA */
        $prev_approval = $purchasePlan->approvals()->create([
            "module"                => "Plan de Compras",
            "module_icon"           => "fas fa-shopping-cart",
            "subject"               => "Solicitud de Aprobación Subdir. Recursos Físicos y Financieros",
            "sent_to_ou_id"        => Parameter::where('module', 'ou')->where('parameter', 'SDASSI')->first()->value,
            "document_route_name"   => "purchase_plan.show_approval",
            "document_route_params" => json_encode(["purchase_plan_id" => $purchasePlan->id]),
            "previous_approval_id"  => $prev_approval->id,
            "active"                => false
        ]);

        $purchasePlan->update(['status' => 'sent']);

        session()->flash('success', 'Estimado Usuario, se ha enviado el plan de compra con éxito para su proceso de aprobación.');
        return redirect()->back();
    }
}
