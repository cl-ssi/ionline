<?php

namespace App\Http\Controllers\Agreements;

use App\Agreements\Agreement;
use App\Agreements\Program;
use App\Agreements\Stage;
use App\Agreements\AgreementAmount;
use App\Agreements\AgreementQuota;
use App\Agreements\Addendum;
use App\Establishment;
use App\Models\Commune;
use App\Municipality;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AgreementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->period){
            $agreements = Agreement::where('period', $request->period)->latest()->get();
        } else {
            $agreements = Agreement::where('period', date('Y'))->latest()->paginate(50);
        }

        return view('agreements/agreements/index')->withAgreements($agreements);
    }

    public function indexTracking(Request $request)
    {
        if($request->commune){
            $agreements = Agreement::where('commune_id',$request->commune)->where('period', $request->period)->latest()->get();
        }elseif($request->period){
            $agreements = Agreement::where('period', $request->period)->latest()->get();
        } else {
            $agreements = Agreement::where('period', date('Y'))->latest()->paginate(50);
        }
        $communes = Commune::All()->SortBy('name');
        $stages = Stage::All();

        //$agreements =  Agreement::with('Stages')->get();
        //dd($agreements);
        return view('agreements/agreements/trackingIndicator')->withAgreements($agreements)->withStages($stages)->withCommunes($communes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $programs = Program::All()->SortBy('name');
        $communes = Commune::All()->SortBy('name');
        return view('agreements/agreements/create')->withPrograms($programs)->withCommunes($communes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $agreement = new Agreement($request->All());
        $agreement->period = Carbon::createFromFormat('Y-m-d', $request->date)->format('Y');
        if($request->hasFile('file'))
            $agreement->file = $request->file('file')->store('resolutions');
        $agreement->save();

        foreach($agreement->program->components as $component) {
            $agreement->agreement_amounts()->create(['subtitle' => null, 'amount'=>0, 'program_component_id'=>$component->id]);
        }
        switch ($agreement->quotas) {
            /* Si son 2 cuotas crea una de 70% y otra de 30%*/
            case '2':
                $agreement->agreement_quotas()->create(['description' => '70%', 'percentage' => '70', 'amount'=>0]);
                $agreement->agreement_quotas()->create(['description' => '30%', 'percentage' => '30', 'amount'=>0]);
                break;
            /* Si son 3 cuotas crea una de 50% y dos de 25%*/
            case '3':
                $agreement->agreement_quotas()->create(['description' => '50%', 'percentage' => '50', 'amount'=>0]);
                $agreement->agreement_quotas()->create(['description' => '25%', 'percentage' => '25', 'amount'=>0]);
                $agreement->agreement_quotas()->create(['description' => '25%', 'percentage' => '25', 'amount'=>0]);
                break;
            /* Si son 12 cuotas crea una por cada mes */
            case '12':
                $agreement->agreement_quotas()->create(['description' => 'Enero', 'amount'=>0]);
                $agreement->agreement_quotas()->create(['description' => 'Febrero', 'amount'=>0]);
                $agreement->agreement_quotas()->create(['description' => 'Marzo', 'amount'=>0]);
                $agreement->agreement_quotas()->create(['description' => 'Abril', 'amount'=>0]);
                $agreement->agreement_quotas()->create(['description' => 'Mayo', 'amount'=>0]);
                $agreement->agreement_quotas()->create(['description' => 'Junio', 'amount'=>0]);
                $agreement->agreement_quotas()->create(['description' => 'Julio', 'amount'=>0]);
                $agreement->agreement_quotas()->create(['description' => 'Agosto', 'amount'=>0]);
                $agreement->agreement_quotas()->create(['description' => 'Septiembre', 'amount'=>0]);
                $agreement->agreement_quotas()->create(['description' => 'Octubre', 'amount'=>0]);
                $agreement->agreement_quotas()->create(['description' => 'Noviembre', 'amount'=>0]);
                $agreement->agreement_quotas()->create(['description' => 'Diciembre', 'amount'=>0]);
                break;
            default:
                /* De lo contrario crea la cantidad de cuotas que se agregaron */
                for($i=1; $i<=$agreement->quotas; $i++) {
                    $agreement->agreement_quotas()->create(['description' => 'Descripción '.$i, 'amount'=>0]);
                }
                break;
        }

        return redirect('agreements');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Agreements\Agreement  $agreement
     * @return \Illuminate\Http\Response
     */
    public function show(Agreement $agreement)
    {
        $establishment = Establishment::All();
        $commune = Commune::with('establishments')->Where('id', $agreement->commune->id)->first();
        $municipality = Municipality::where('commune_id', $agreement->Commune->id)->first();
        $establishment_list = unserialize($agreement->establishment_list);
        return view('agreements/agreements/show')->withAgreement($agreement)->withCommune($commune)->withMunicipality($municipality)->with('establishment_list', $establishment_list);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agreements\Agreement  $agreement
     * @return \Illuminate\Http\Response
     */
    public function edit(Agreement $agreement)
    {
        $agreements = Agreement::All();
        $commune = Commune::All();
        return view('agreements/agreements/edit')->withAgreements($agreements)->withCommunes($commune)->withAgreement($agreement);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agreements\Agreement  $agreement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        //dd($request);
        $Agreement = Agreement::find($id);
        $stages = Stage::where('agreement_id', $id)->first();
        //dd($stage->isEmpty());
        $Agreement->date                = $request->date;
        $Agreement->period              = Carbon::createFromFormat('Y-m-d', $request->date)->format('Y');
        $Agreement->resolution_date     = $request->resolution_date;
        $Agreement->number              = $request->number;
        $Agreement->res_exempt_number    = $request->res_exempt_number;
        $Agreement->res_exempt_date     = $request->res_exempt_date;
        $Agreement->res_resource_number    = $request->res_resource_number;
        $Agreement->res_resource_date     = $request->res_resource_date;

        $Agreement->representative      = $request->representative;
        $Agreement->representative_rut  = $request->representative_rut;
        $Agreement->municipality_adress = $request->municipality_adress;
        $Agreement->municipality_rut    = $request->municipality_rut;
        $Agreement->establishment_list  = serialize($request->establishment);
        if($request->hasFile('file')){

            Storage::delete($Agreement->file);
            $Agreement->file = $request->file('file')->store('resolutions');
        }
        if($request->hasFile('fileAgreeEnd')){
            Storage::delete($Agreement->fileAgreeEnd);
            $Agreement->fileAgreeEnd = $request->file('fileAgreeEnd')->store('resolutions');
        }
        if($request->hasFile('fileResEnd')){
            Storage::delete($Agreement->fileResEnd);
            $Agreement->fileResEnd = $request->file('fileResEnd')->store('resolutions');
        }

        $Agreement->referente = $request->referente;
        $Agreement->save();
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agreements\Agreement  $agreement
     * @return \Illuminate\Http\Response
     */
    public function updateAmount(Request $request, AgreementAmount $AgreementAmount)
    {

        $agreements = Agreement::with('Program','Commune','agreement_amounts')->where('id', $AgreementAmount->agreement->id)->first();
        //dd($agreements->agreement_amounts->sum('amount'));
        $AgreementAmount->fill($request->all());
        $AgreementAmount->save();

        return redirect()->back();
    }

    public function updateAutomaticQuota(Request $request, $id)
    {
        $AgreementQuota = AgreementQuota::where('agreement_id', $id)->get();
        $agreements = Agreement::with('Program','Commune','agreement_amounts')->where('id', $id)->first();

        $agreementTotal = $agreements->agreement_amounts->sum('amount');
        //  SI TIENE 2 CUOTAS CALCULA EL PORCENTAJE 70% 30%
       if($agreements->quotas == 2){
            foreach ($AgreementQuota as $key => $quota) {
                $datas =  AgreementQuota::find($quota->id);
                $datas->amount = round((($quota->percentage*$agreementTotal)/100),0);
                $datas->agreement_id = $id;
                $datas->save();
             }
       }
       //  SI TIENE 3 CUOTAS CALCULA EL PORCENTAJE 50% y 2 de 25%
       else if($agreements->quotas == 3){
            foreach ($AgreementQuota as $key => $quota) {
                $datas =  AgreementQuota::find($quota->id);
                $datas->amount = round((($quota->percentage*$agreementTotal)/100),0);
                $datas->agreement_id = $id;
                $datas->save();
             }
       }
       //  DE LO CONTRARIO DIVIDE POR LA CANTIDAD DE CUOTAS
       else{
            foreach ($AgreementQuota as $key => $quota) {
                $datas =  AgreementQuota::find($quota->id);
                $datas->amount = round(($agreementTotal/$agreements->quotas),-1);
                $datas->agreement_id = $id;
                $datas->save();
             }
       }
        return redirect()->back();
    }

     public function destroyAmount($id)
    {
        //dd($id);
      $AgreementAmount = AgreementAmount::find($id);
      $AgreementAmount->delete();
      //$AgreementAmount->save();
      session()->flash('success', 'El Componente ha sido eliminado de este Convenio');
       return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agreements\Agreement  $agreement
     * @return \Illuminate\Http\Response
     */
    public function updateQuota(Request $request, AgreementQuota $AgreementQuota)
    {
        $AgreementQuota->fill($request->all());
        $AgreementQuota->save();
        return redirect()->back();
    }

    // METODO PARA ACTUALIZAR LA ETAPA DESDE LA TABLA DE SEGUIMIENTO DE CONVENIOS
    public function updateStage(Request $request, $id)
    {
        $Stage = Stage::find($id);
        $Stage->date = $request->date;
        $Stage->dateEnd = $request->dateEnd;
        $Stage->date_addendum = $request->date_addendum;
        $Stage->dateEnd_addendum = $request->dateEnd_addendum;
        $Stage->observation = $request->observation;
        
        if($request->hasFile('file')){
            Storage::delete($Stage->file);
            $Stage->file = $request->file('file')->store('agg_stage');
        }
           
        $Stage->save();
        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agreements\Agreement  $agreement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agreement $agreement)
    {
        $agreement->delete();

        session()->flash('success', 'El convenio ha sido eliminado');

        return redirect()->route('agreements.index');
    }

  
    public function download(Agreement $file)
    {
        return Storage::response($file->file, mb_convert_encoding($file->name,'ASCII'));
    }
    public function downloadAgree(Agreement $file)
    {
        return Storage::response($file->fileAgreeEnd, mb_convert_encoding($file->name,'ASCII'));
    }
    public function downloadRes(Agreement $file)
    {
        return Storage::response($file->fileResEnd, mb_convert_encoding($file->name,'ASCII'));
    }
}
