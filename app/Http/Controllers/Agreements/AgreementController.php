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
use App\Rrhh\Authority;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AgreementController extends Controller
{
    /**
     * Return a listing of quota options.
     *
     * @return \Illuminate\Http\Response
     */
    public function getQuotaOptions()
    {
        return collect([
            ['id' => 1, 'name' => '1 cuota', 'percentages' => '100', 'quotas' => 1],
            ['id' => 2, 'name' => '2 cuotas, 30% y 70% respectivamente', 'percentages' => '30,70', 'quotas' => 2], 
            ['id' => 3, 'name' => '3 cuotas, 50%, 20% y 30% respectivamente', 'percentages' => '50,20,30', 'quotas' => 3], 
            ['id' => 4, 'name' => '3 cuotas, 50%, 25% y 25% respectivamente', 'percentages' => '50,25,25', 'quotas' => 3],
            ['id' => 5, 'name' => '12 cuotas', 'percentages' => null, 'quotas' => 12]
        ]);
     }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->period){
            $agreements = Agreement::where('period', $request->period)->latest()->paginate(50);
        } else {
            $agreements = Agreement::where('period', date('Y'))->latest()->paginate(50);
        }

        return view('agreements/agreements/index')->withAgreements($agreements);
    }

    public function indexTracking(Request $request)
    {
        if($request->commune){
            $agreements = Agreement::where('commune_id',$request->commune)->where('period', $request->period)->latest()->paginate(50);
        }elseif($request->period){
            $agreements = Agreement::where('period', $request->period)->latest()->paginate(50);
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
        $quota_options = $this->getQuotaOptions();
        return view('agreements/agreements/create', compact('programs', 'communes', 'quota_options'));
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

        $municipality = Municipality::where('commune_id', $request->commune_id)->first();
        $agreement->representative = $municipality->name_representative;
        $agreement->representative_rut = $municipality->rut_representative;
        $agreement->representative_appelative = $municipality->appellative_representative;
        $agreement->representative_decree = $municipality->decree_representative;
        $agreement->municipality_adress = $municipality->adress_municipality;
        $agreement->municipality_rut = $municipality->rut_municipality;

        $quota_options = $this->getQuotaOptions();
        $quota_option_selected = $quota_options->firstWhere('id', $request->quota_id);
        $agreement->quotas = $quota_option_selected['quotas'];
        
        $agreement->authority_id = Authority::getAuthorityFromDate(1, $request->date, 'manager')->id;
        $agreement->save();
        
        foreach($agreement->program->components as $component) {
            $agreement->agreement_amounts()->create(['subtitle' => null, 'amount'=>0, 'program_component_id'=>$component->id]);
        }
        
        $months = array (1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre');
        $quota_percentages = explode(',', $quota_option_selected['percentages']);
        
        if($quota_option_selected['quotas'] == 1)
            $agreement->agreement_quotas()->create(['description' => 'Descripción 1', 'amount' => 0]);
        elseif($quota_option_selected['quotas'] == 12)
            for($i = 1; $i <= 12; $i++) 
                $agreement->agreement_quotas()->create(['description' => $months[$i], 'amount' => 0]);
        else
            for($i = 0; $i < $quota_option_selected['quotas']; $i++)
                $agreement->agreement_quotas()->create(['description' => $quota_percentages[$i].'%', 'percentage' => $quota_percentages[$i], 'amount' => 0]);

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
        $agreement->load('authority.user', 'commune.establishments');
        $municipality = Municipality::where('commune_id', $agreement->commune->id)->first();
        $establishment_list = unserialize($agreement->establishment_list);
        return view('agreements/agreements/show', compact('agreement', 'municipality', 'establishment_list'));
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

        // return $request;
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
        $Agreement->representative_appelative = $request->representative_appelative;
        $Agreement->representative_decree = $request->representative_decree;
        $Agreement->municipality_adress = $request->municipality_adress;
        $Agreement->municipality_rut    = $request->municipality_rut;

        $Agreement->establishment_list  = serialize($request->establishment);
        if($request->hasFile('file')){

            Storage::delete($Agreement->file);
            $Agreement->file = $request->file('file')->store('resolutions');
        }
        // if($request->hasFile('fileAgreeEnd')){
        //     Storage::delete($Agreement->fileAgreeEnd);
        //     $Agreement->fileAgreeEnd = $request->file('fileAgreeEnd')->store('resolutions');
        // }
        if($request->hasFile('fileResEnd')){
            Storage::delete($Agreement->fileResEnd);
            $Agreement->fileResEnd = $request->file('fileResEnd')->store('resolutions');
        }

        $Agreement->referente = $request->referente;
        // $Agreement->authority_id = $request->authority_id;
        $Agreement->authority_id = Authority::getAuthorityFromDate(1, $request->date, 'manager')->id;
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
