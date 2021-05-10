<?php

namespace App\Http\Controllers\Agreements;

use App\Agreements\Agreement;
use App\Agreements\Program;
use App\Agreements\Stage;
use App\Agreements\AgreementAmount;
use App\Agreements\AgreementQuota;
use App\Agreements\Addendum;
use App\Agreements\Signer;
use App\Establishment;
use App\Models\Commune;
use App\Municipality;
use App\Rrhh\Authority;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Documents\Signature;
use App\Models\Documents\SignaturesFile;
use App\Models\Documents\SignaturesFlow;
use App\Rrhh\OrganizationalUnit;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            ['id' => 2, 'name' => '2 cuotas, 70% y 30% respectivamente', 'percentages' => '70,30', 'quotas' => 2], 
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
        $agreements = Agreement::with('commune','program','agreement_amounts.program_component')->where('period', $request->period ? $request->period : date('Y'))->latest()->paginate(50);
        
        return view('agreements/agreements/index', compact('agreements'));
    }

    public function indexTracking(Request $request)
    {
        $agreements = Agreement::with('program','stages','agreement_amounts.program_component','addendums','commune')
                               ->when($request->commune, function($q) use ($request){ return $q->where('commune_id', $request->commune); })
                               ->where('period', $request->period ? $request->period : date('Y'))->latest()->paginate(50);

        $communes = Commune::All()->SortBy('name');
        return view('agreements/agreements/trackingIndicator', compact('agreements', 'communes'));
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
        $referrers = User::all()->sortBy('name');
        $quota_options = $this->getQuotaOptions();
        return view('agreements/agreements/create', compact('programs', 'communes', 'referrers', 'quota_options'));
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
        $agreement->load('authority.user', 'commune.establishments', 'referrer');
        $municipality = Municipality::where('commune_id', $agreement->commune->id)->first();
        $establishment_list = unserialize($agreement->establishment_list);
        $referrers = User::all()->sortBy('name');
        $signers = Signer::with('user')->get();
        return view('agreements/agreements/show', compact('agreement', 'municipality', 'establishment_list', 'referrers', 'signers'));
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

        $Agreement->referrer_id = $request->referrer_id;
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
        $agreement = Agreement::with('Program','Commune','agreement_amounts','agreement_quotas')->where('id', $id)->first();

        $agreementTotal = $agreement->agreement_amounts()->sum('amount');

        if($agreement->quotas == 1){
            $quota = $agreement->agreement_quotas->first()->update(['amount' => $agreementTotal]);
        }elseif($agreement->quotas == 12){
            $amountPerQuota = round($agreementTotal/$agreement->quotas);
            $diff = $agreementTotal - $amountPerQuota * $agreement->quotas; //residuo
            foreach ($agreement->agreement_quotas as $quota) {
                $quota->amount = $amountPerQuota;
                if($diff != 0){
                    ($diff > 0) ? $quota->amount++ : $quota->amount--;
                    ($diff > 0) ? $diff-- : $diff++;
                }
                $quota->save();
            }
        } else {
            $quotasWithDecimal = collect();
            foreach ($agreement->agreement_quotas as $quota) {
                $quota->amount = ($quota->percentage * $agreementTotal)/100;
                if(is_float($quota->amount)) $quotasWithDecimal->add($quota);
                $quota->save();
            }

            $diff = $agreementTotal - $agreement->agreement_quotas()->sum('amount'); //residuo
        
            foreach($quotasWithDecimal as $quota){
                $fraction = $quota->amount - floor($quota->amount);
                if($diff != 0)
                    if($diff > 0){ //falta para completar el total agreement
                        if($fraction >= 0.5){ // revisar si está demás esta condición o no
                            $quota->amount++;
                            $diff--;
                            $quota->save();
                        }
                    }else{ //quedé debiendo
                        if($fraction >= 0.5){
                            $quota->amount--;
                            $diff++;
                            $quota->save();
                        }
                    }
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

    public function preview(Agreement $agreement)
    {
        $filename = 'tmp_files/'.$agreement->file;
        if(!Storage::disk('public')->exists($filename))
            Storage::disk('public')->put($filename, Storage::disk('local')->get($agreement->file));
        return Redirect::to('https://view.officeapps.live.com/op/embed.aspx?src='.asset('storage/'.$filename));
    }

    public function downloadAgree(Agreement $file)
    {
        return Storage::response($file->fileAgreeEnd, mb_convert_encoding($file->name,'ASCII'));
    }

    public function downloadRes(Agreement $file)
    {
        return Storage::response($file->fileResEnd, mb_convert_encoding($file->name,'ASCII'));
    }

    public function sign(Agreement $agreement, $type)
    {
        if(!in_array($type, array('visators', 'signer'))) abort(404);

        $agreement->load('program','commune.municipality','referrer');
        $municipio = (!Str::contains($agreement->commune->municipality->name_municipality, 'ALTO HOSPICIO') ? 'Ilustre ' : '').'Municipalidad de '.$agreement->commune->name;
        $first_word = explode(' ',trim($agreement->program->name))[0];
        $programa = $first_word == 'Programa' ? substr(strstr($agreement->program->name," "), 1) : $agreement->program->name;

        $signature = new Signature();
        $signature->request_date = $agreement->date;
        $signature->document_type = 'Convenios';
        $signature->type = $type;
        $signature->subject = 'Convenio programa '.$programa;
        $signature->description = 'Documento convenio de ejecución del programa '.$programa.' año '.$agreement->period;
        $signature->endorse_type = 'Visación en cadena de responsabilidad';
        $signature->recipients = 'sdga.ssi@redsalud.gov.cl,jurídica.ssi@redsalud.gov.cl,cxhenriquez@gmail.com,'.$agreement->referrer->email.',natalia.rivera.a@redsalud.gob.cl,apoyo.convenioaps@redsalud.gob.cl,pablo.morenor@redsalud.gob.cl,finanzas.ssi@redsalud.gov.cl,jaime.abarzua@redsalud.gov.cl,aps.ssi@redsalud.gob.cl';
        $signature->distribution = 'División de Atención Primaria MINSAL,Oficina de Partes SSI,'.$municipio;

        $signaturesFile = new SignaturesFile();
        $signaturesFile->file_type = 'documento';

        $agreement->load('authority');

        if($type == 'signer'){
            $signaturesFlow = new SignaturesFlow();
            $signaturesFlow->type = 'firmante';
            $signaturesFlow->ou_id = $agreement->authority->organizational_unit_id;
            $signaturesFlow->user_id = $agreement->authority->user_id;
            $signaturesFile->signaturesFlows->add($signaturesFlow);
        }

        if($type == 'visators'){
            //visadores por cadena de responsabilidad en orden parte primero por el referente tecnico
            // $visadores = collect([
            //                 ['ou_id' => 12, 'user_id' => 15683706] // DEPTO. ATENCION PRIMARIA DE SALUD - JORGE CRUZ TERRAZAS (JCT)
            //                 ['ou_id' => 61, 'user_id' => 6811637], // DEPTO.ASESORIA JURIDICA  - CARMEN HENRIQUEZ OLIVARES (CHO)
            //                 ['ou_id' => 31, 'user_id' => 9994426], // DEPTO.GESTION FINANCIERA (40) - JAIME ABARZUA CONSTANZO (JAC)
            //                 ['ou_id' => 2, 'user_id' => 14104369], // SUBDIRECCION GESTION ASISTENCIAL - CARLOS CALVO
            //             ]);
            $visadores = collect([$agreement->referrer]); //referente tecnico
            foreach(array(15683706, 6811637, 9994426, 14104369) as $user_id) //resto de visadores por cadena de responsabilidad
                $visadores->add(User::find($user_id));
            
            foreach($visadores as $key => $visador){
                $signaturesFlow = new SignaturesFlow();
                $signaturesFlow->type = 'visador';
                $signaturesFlow->ou_id = $visador->organizational_unit_id;
                $signaturesFlow->user_id = $visador->id;
                $signaturesFlow->sign_position = $key;
                $signaturesFile->signaturesFlows->add($signaturesFlow);
            }
        }

        $signature->signaturesFiles->add($signaturesFile);
        
        $users = User::orderBy('name', 'ASC')->get();
        $organizationalUnits = OrganizationalUnit::orderBy('id', 'asc')->get();
        return view('documents.signatures.create', compact('signature', 'users', 'organizationalUnits'));
    }
}
