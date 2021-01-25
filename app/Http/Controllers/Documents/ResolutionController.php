<?php

namespace App\Http\Controllers\Documents;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Documents\Resolution;
use App\Models\ServiceRequests\SignatureFlow;
use App\Rrhh\OrganizationalUnit;
use App\User;

use Illuminate\Support\Facades\Auth;
use App\Rrhh\Authority;
use Carbon\Carbon;

class ResolutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //saber la organizationalUnit que tengo a cargo
        $authorities = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', Auth::user()->id);

        //si es autoridad se devuelven las resoluciones pendientes de aprobación
        $resolutionsPending = [];
        if ($authorities!=null) {
          $ou_id = $authorities[0]->organizational_unit_id;

          $resolutionsPending = Resolution::whereDoesntHave("SignatureFlows", function($subQuery) use($ou_id){
                                             $subQuery->where('ou_id', $ou_id)->whereNotNull('status');
                                           })
                                           ->where('user_id','!=',Auth::user()->id)->orderBy('id','asc')->get();
                                     // dd($resolutionsPending);


          //no se consideran las resoluciones que sean para la unidad organizacional mía
          foreach ($resolutionsPending as $key => $resolution) {
            if ($resolution->SignatureFlows->last()->ou_id != $ou_id) {
              $resolutionsPending->forget($key);
            }
          }
        }

        $myResolutions = Resolution::whereHas("SignatureFlows", function($subQuery) {
                                       $subQuery->where('user_id',Auth::user()->id)->whereNotNull('status');
                                     })->orderBy('id','asc')->get();

        return view('documents.signatures.index', compact('resolutionsPending','myResolutions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
     {
       $users = User::orderBy('name','ASC')->get();
       $organizationalUnits = OrganizationalUnit::orderBy('id','asc')->get();
       return view('documents.signatures.create', compact('users','organizationalUnits'));
     }

     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function store(Request $request)
     {
         $resolution = new Resolution($request->All());
         $resolution->user_id = Auth::id();
         $resolution->save();

         //saber la organizationalUnit que tengo a cargo
         $authorities = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', Auth::user()->id);
         $employee = Auth::user()->position;
         if ($authorities!=null) {
           $employee = $authorities[0]->position . " - " . $authorities[0]->organizationalUnit->name;
           $ou_id = $authorities[0]->organizational_unit_id;
         }else{
           $ou_id = Auth::user()->organizational_unit_id;
         }

         //se crea la primera firma
         $SignatureFlow = new SignatureFlow($request->All());
         $SignatureFlow->user_id = Auth::id();
         $SignatureFlow->ou_id = $ou_id;
         $SignatureFlow->resolution_id = $resolution->id;
         $SignatureFlow->type = "creador";
         $SignatureFlow->employee = $employee;
         $SignatureFlow->signature_date = Carbon::now();
         $SignatureFlow->status = 1;
         $SignatureFlow->save();

         if($request->visators <> null){
           foreach ($request->visators as $key => $ou_visator_id) {
             $SignatureFlow = new SignatureFlow($request->All());
             $SignatureFlow->ou_id = $ou_visator_id;
             $SignatureFlow->resolution_id = $resolution->id;
             $SignatureFlow->type = "visador";
             $SignatureFlow->save();
           }
         }

         if($request->signers <> null){
           foreach ($request->signers as $key => $ou_signers_id) {
             $SignatureFlow = new SignatureFlow($request->All());
             $SignatureFlow->ou_id = $ou_signers_id;
             $SignatureFlow->resolution_id = $resolution->id;
             $SignatureFlow->type = "firmante";
             $SignatureFlow->save();
           }
         }



         session()->flash('info', 'La resolución '.$resolution->id.' ha sido creada.');
         return redirect()->route('rrhh.resolutions.index');
     }

     /**
      * Display the specified resource.
      *
      * @param  \App\Pharmacies\Establishment  $establishment
      * @return \Illuminate\Http\Response
      */
     public function show(Resolution $resolution)
     {
         //
     }

     /**
      * Show the form for editing the specified resource.
      *
      * @param  \App\Pharmacies\Establishment  $establishment
      * @return \Illuminate\Http\Response
      */
     public function edit(Resolution $resolution)
     {
         // $subdirections = Subdirection::orderBy('name', 'ASC')->get();
         // $responsabilityCenters = ResponsabilityCenter::orderBy('name', 'ASC')->get();
         // $SignatureFlow = $serviceRequest->SignatureFlows->where('employee','Supervisor de servicio')->first();

         $users = User::orderBy('name','ASC')->get();
         $organizationalUnits = organizationalUnit::orderBy('id','asc')->get();

         //saber la organizationalUnit que tengo a cargo
         $authorities = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', Auth::user()->id);
         $employee = Auth::user()->position;
         if ($authorities!=null) {
           $employee = $authorities[0]->position . " - " . $authorities[0]->organizationalUnit->name;
         }

         // dd($SignatureFlow);
         return view('documents.signatures.edit', compact('resolution', 'users', 'organizationalUnits','employee'));
     }

     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  \App\Pharmacies\Establishment  $establishment
      * @return \Illuminate\Http\Response
      */
     public function update(Request $request, Resolution $resolution)
     {
         //saber la organizationalUnit que tengo a cargo
         $authorities = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', Auth::user()->id);

         //si es autoridad se devuelven las resoluciones pendientes de aprobación
         $resolutions = [];
         if ($authorities!=null) {
           $ou_id = $authorities[0]->organizational_unit_id;

           //se guarda resolución
           $resolution->fill($request->all());
           $resolution->save();

           //si seleccionó una opción, se agrega visto bueno.
           if ($request->status != null) {

             $SignatureFlow = SignatureFlow::where('ou_id',$ou_id)
                                           ->where('resolution_id',$resolution->id)
                                           ->first();
             $SignatureFlow->user_id = Auth::id();
             $SignatureFlow->employee = $request->employee;
             $SignatureFlow->signature_date = Carbon::now();
             $SignatureFlow->status = $request->status;
             $SignatureFlow->save();
          }

          //si existen visadores
          if($request->visators <> null){

            foreach ($request->visators as $key => $ou_visator_id) {
              $SignatureFlow = new SignatureFlow($request->All());
              $SignatureFlow->ou_id = $ou_visator_id;
              $SignatureFlow->resolution_id = $resolution->id;
              $SignatureFlow->type = "visador";
              $SignatureFlow->save();
            }
          }

          //si existen firmantes
          if($request->signers <> null){
            foreach ($request->signers as $key => $ou_signers_id) {
              $SignatureFlow = new SignatureFlow($request->All());
              $SignatureFlow->ou_id = $ou_signers_id;
              $SignatureFlow->resolution_id = $resolution->id;
              $SignatureFlow->type = "firmante";
              $SignatureFlow->save();
            }
          }

         }

         session()->flash('info', 'La resolución '.$resolution->id.' ha sido modificada.');
         return redirect()->route('rrhh.resolutions.index');
     }

     /**
      * Remove the specified resource from storage.
      *
      * @param  \App\Pharmacies\Establishment  $establishment
      * @return \Illuminate\Http\Response
      */
     public function destroy(Resolution $resolution)
     {
         //
     }
}
