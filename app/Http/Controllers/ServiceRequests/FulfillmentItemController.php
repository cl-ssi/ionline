<?php

namespace App\Http\Controllers\ServiceRequests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Models\ServiceRequests\ServiceRequest;
use App\Models\ServiceRequests\FulfillmentItem;
use App\Models\ServiceRequests\Fulfillment;

use Illuminate\Support\Facades\Auth;
use App\Rrhh\Authority;
use Carbon\Carbon;


class FulfillmentItemController extends Controller
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
      //validation
      if (Auth::user()->can('Service Request: fulfillments rrhh')) {
        if (Fulfillment::where('id',$request->fulfillment_id)->first()->responsable_approver_id == NULL) {
          session()->flash('danger', 'No es posible registrar, puesto que falta aprobación de Responsable.');
          return redirect()->back();
        }
      }

      if (Auth::user()->can('Service Request: fulfillments finance')) {
        if (Fulfillment::where('id',$request->fulfillment_id)->first()->rrhh_approver_id == NULL) {
          session()->flash('danger', 'No es posible registrar, puesto que falta aprobación de RRHH.');
          return redirect()->back();
        }
      }

      //save
      $fulfillmentItem = new FulfillmentItem($request->All());
      if ($request->type == "Inasistencia Injustificada") {
        $fulfillmentItem->start_date = $request->start_date . " " .$request->start_hour;
        $fulfillmentItem->end_date = $request->end_date . " " .$request->end_hour;
      }
      if ($request->type == "Licencia no covid") {
        $fulfillmentItem->start_date = $request->start_date;
        $fulfillmentItem->end_date = $request->end_date;
      }
      if ($request->type == "Renuncia voluntaria") {
        // $fulfillmentItem->start_date = $request->start_date . " " .$request->start_hour;
        $fulfillmentItem->end_date = $request->end_date;
      }
      if ($request->type == "Abandono de funciones") {
        // $fulfillmentItem->start_date = $request->start_date . " " .$request->start_hour;
        $fulfillmentItem->end_date = $request->end_date;
      }
      if ($request->type == "Turno") {
        $fulfillmentItem->start_date = $request->start_date . " " .$request->start_hour;
        $fulfillmentItem->end_date = $request->end_date . " " .$request->end_hour;
      }


      if (Auth::user()->can('Service Request: fulfillments responsable')) {
        $fulfillmentItem->responsable_approbation = 1;
        $fulfillmentItem->responsable_approbation_date = Carbon::now();
        $fulfillmentItem->responsable_approver_id = Auth::user()->id;
      }elseif(Auth::user()->can('Service Request: fulfillments rrhh')){
        $fulfillmentItem->rrhh_approbation = 1;
        $fulfillmentItem->rrhh_approbation_date = Carbon::now();
        $fulfillmentItem->rrhh_approver_id = Auth::user()->id;
      }
      elseif(Auth::user()->can('Service Request: fulfillments finance')){
        $fulfillmentItem->finances_approbation = 1;
        $fulfillmentItem->finances_approbation_date = Carbon::now();
        $fulfillmentItem->finances_approver_id = Auth::user()->id;
      }
      $fulfillmentItem->user_id = Auth::user()->id;
      $fulfillmentItem->save();

      session()->flash('success', 'Se ha registrado la inasistencia del período.');
      return redirect()->back();
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FulfillmentItem $fulfillmentItem)
    {
        $fulfillmentItem->delete();
        session()->flash('success', 'La inasistencia se ha eliminado');
        return redirect()->back();
    }
}
