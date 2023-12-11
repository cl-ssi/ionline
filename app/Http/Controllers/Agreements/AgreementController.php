<?php

namespace App\Http\Controllers\Agreements;

use App\Exports\Agreements\TrackingAgreementsExport;
use App\Models\Agreements\Agreement;
use App\Models\Agreements\Program;
use App\Models\Agreements\Stage;
use App\Models\Agreements\AgreementAmount;
use App\Models\Agreements\AgreementQuota;
use App\Models\Agreements\Signer;
use App\Models\Commune;
use App\Models\Parameters\Municipality;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Documents\Signature;
use App\Models\Documents\SignaturesFile;
use App\Models\Documents\SignaturesFlow;
use App\Models\Documents\Type;
use App\Rrhh\OrganizationalUnit;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

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
        // return $request;
        $query = Agreement::with('program','stages','agreement_amounts.program_component','commune','fileToEndorse.signaturesFlows','addendums.fileToEndorse.signaturesFlows','fileToSign.signaturesFlows','addendums.fileToSign.signaturesFlows')
        ->when($request->program, function($q) use ($request){ return $q->where('program_id', $request->program); })
        ->when($request->commune, function($q) use ($request){ return $q->where('commune_id', $request->commune); })
        ->where('period', $request->period ? $request->period : date('Y'))->latest();

        if($request->has('export')){
            return Excel::download(new TrackingAgreementsExport($query->get()), 'TrackingAgreementsExport_'.Carbon::now().'.xlsx');
        }

        $agreements = $query->paginate(50);
        // return $agreements;
        $programs = Program::orderBy('name')->get();
        $communes = Commune::orderBy('name')->get();

        return view('agreements.agreements.trackingIndicator', compact('programs', 'agreements', 'communes'));
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
        $signers = Signer::all();
        $quota_options = $this->getQuotaOptions();
        return view('agreements.agreements.create', compact('programs', 'communes', 'referrers', 'quota_options', 'signers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $agreement = new Agreement($request->All());
        $agreement->period = Carbon::createFromFormat('Y-m-d', $request->date)->format('Y');

        $municipality = Municipality::where('commune_id', $request->commune_id)->first();
        $agreement->representative = $municipality->name_representative;
        $agreement->representative_rut = $municipality->rut_representative;
        $agreement->representative_appelative = $municipality->appellative_representative;
        $agreement->representative_decree = $municipality->decree_representative;
        $agreement->municipality_adress = $municipality->adress_municipality;
        $agreement->municipality_rut = $municipality->rut_municipality;

        if($request->program_id == 3){ // Convenio con retiro voluntario
            $agreement->total_amount = $request->total_amount;
            $agreement->quotas = $request->quotas;
            $agreement->save();
        } elseif($request->program_id == 50) { // Convenio de colaboración
            $agreement->total_amount = null;
            $agreement->quotas = 0;
            $agreement->save();
        } else { // Convenio de ejecución
            $quota_options = $this->getQuotaOptions();
            $quota_option_selected = $quota_options->firstWhere('id', $request->quota_id);
            $agreement->quotas = $quota_option_selected['quotas'];

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
        }

        session()->flash('info', 'El convenio #'.$agreement->id.' ha sido creado satisfactoriamente.');
        return redirect()->route('agreements.show', $agreement);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agreements\Agreement  $agreement
     * @return \Illuminate\Http\Response
     */
    public function show(Agreement $agreement)
    {
        $agreement->load('director_signer.user', 'commune.establishments', 'referrer', 'fileToEndorse', 'fileToSign', 'addendums.referrer');
        $municipality = Municipality::where('commune_id', $agreement->commune->id)->first();
        $establishment_list = unserialize($agreement->establishment_list);
        // $referrers = User::all()->sortBy('name');
        $signers = Signer::with('user')->get();
        return view('agreements.agreements.show', compact('agreement', 'municipality', 'establishment_list', 'signers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agreements\Agreement  $agreement
     * @return \Illuminate\Http\Response
     */
    public function edit(Agreement $agreement)
    {
        $agreements = Agreement::All();
        $commune = Commune::All();
        return view('agreements.agreements.edit')->withAgreements($agreements)->withCommunes($commune)->withAgreement($agreement);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agreements\Agreement  $agreement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agreement $agreement)
    {
        $agreement->date                = $request->date;
        $agreement->period              = Carbon::createFromFormat('Y-m-d', $request->date)->format('Y');
        $agreement->resolution_date     = $request->resolution_date;
        $agreement->number              = $request->number;
        $agreement->res_exempt_number    = $request->res_exempt_number;
        $agreement->res_exempt_date     = $request->res_exempt_date;
        $agreement->res_resource_number    = $request->res_resource_number;
        $agreement->res_resource_date     = $request->res_resource_date;

        $agreement->representative      = $request->representative;
        $agreement->representative_rut  = $request->representative_rut;
        $agreement->representative_appelative = $request->representative_appelative;
        $agreement->representative_decree = $request->representative_decree;
        $agreement->municipality_adress = $request->municipality_adress;
        $agreement->municipality_rut    = $request->municipality_rut;

        $agreement->quotas = $request->quotas;
        $agreement->total_amount = $request->total_amount;

        $agreement->establishment_list  = serialize($request->establishment);
        if($request->hasFile('file')){

            if($agreement->file != null) Storage::disk('gcs')->delete($agreement->file);
            $agreement->file = $request->file('file')->store('ionline/agreements/agree', ['disk' => 'gcs']);
        }
 
        if($request->hasFile('fileResEnd')){
            if($agreement->fileResEnd != null) Storage::disk('gcs')->delete($agreement->fileResEnd);
            $agreement->fileResEnd = $request->file('fileResEnd')->store('ionline/agreements/agree_res', ['disk' => 'gcs']);
        }

        $agreement->referrer_id = $request->referrer_id;
        $agreement->director_signer_id = $request->director_signer_id;
        $agreement->save();

        session()->flash('info', 'El convenio #'.$agreement->id.' ha sido actualizado.');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agreements\Agreement  $agreement
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
            foreach($agreement->agreement_quotas as $quota)
                $quota->update(['amount' => $agreement->agreement_quotas->last() == $quota && $diff != 0 ? $amountPerQuota + $diff : $amountPerQuota]);
        }else{
            foreach ($agreement->agreement_quotas as $quota)
                $quota->update(['amount' => ($quota->percentage * $agreementTotal)/100]);
            $diff = $agreementTotal - $agreement->agreement_quotas()->sum('amount'); //residuo
            if($diff != 0) $agreement->agreement_quotas->last()->update(['amount' => $agreement->agreement_quotas->last()->amount + $diff]);
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
     * @param  \App\Models\Agreements\Agreement  $agreement
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
            if($Stage->file != null) Storage::disk('gcs')->delete($Stage->file);
            $Stage->file = $request->file('file')->store('ionline/agreements/agg_stage', ['disk' => 'gcs']);
        }
           
        $Stage->save();
        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agreements\Agreement  $agreement
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
        return Storage::disk('gcs')->response($file->file, mb_convert_encoding($file->name,'ASCII'));
    }

    public function preview(Agreement $agreement)
    {
        $filename = 'tmp_files/'.$agreement->file;
        if(!Storage::disk('public')->exists($filename))
            Storage::disk('public')->put($filename, Storage::disk('gcs')->get($agreement->file));
        return Redirect::away('https://view.officeapps.live.com/op/embed.aspx?src='.asset('storage/'.$filename));
    }

    public function downloadAgree(Agreement $file)
    {
        return Storage::disk('gcs')->response($file->fileAgreeEnd, mb_convert_encoding($file->name,'ASCII'));
    }

    public function downloadRes(Agreement $file)
    {
        return Storage::disk('gcs')->response($file->fileResEnd, mb_convert_encoding($file->name,'ASCII'));
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
        $signature->type_id = Type::where('name','Convenio')->first()->id;
        $signature->type = $type;
        $signature->agreement_id = $agreement->id;
        $signature->subject = 'Convenio programa '.$programa.' comuna de '.$agreement->commune->name;
        $signature->description = 'Documento convenio '.($agreement->program_id == 3 ? 'de retiro voluntario por ' : ($agreement->program_id == 50 ? '' : 'de ejecución del programa ')).$programa.' año '.$agreement->period.' comuna de '.$agreement->commune->name;
        $signature->endorse_type = 'Visación en cadena de responsabilidad';
        $signature->recipients = 'sdga.ssi@redsalud.gov.cl,jurídica.ssi@redsalud.gov.cl,cxhenriquez@gmail.com,'.$agreement->referrer->email.',natalia.rivera.a@redsalud.gob.cl,apoyo.convenioaps@redsalud.gob.cl,pablo.morenor@redsalud.gob.cl,finanzas.ssi@redsalud.gov.cl,jaime.abarzua@redsalud.gov.cl,aps.ssi@redsalud.gob.cl';
        $signature->distribution = 'División de Atención Primaria MINSAL,Oficina de Partes SSI,'.$municipio;

        $signaturesFile = new SignaturesFile();
        $signaturesFile->file_type = 'documento';

        if($type == 'signer'){
            $agreement->load('director_signer.user');
            $signaturesFlow = new SignaturesFlow();
            $signaturesFlow->type = 'firmante';
            $signaturesFlow->ou_id = $agreement->director_signer->user->organizational_unit_id;
            $signaturesFlow->user_id = $agreement->director_signer->user->id;
            $signaturesFile->signaturesFlows->add($signaturesFlow);
        }

        if($type == 'visators'){
            /* TODO: Pasar a parametros */
            //visadores por cadena de responsabilidad en orden parte primero por el referente tecnico
            // $visadores = collect([
            //                 ['ou_id' => 12, 'user_id' => 15005047] // DEPTO. ATENCION PRIMARIA DE SALUD - ANA MARIA MUJICA
            //                 ['ou_id' => 61, 'user_id' => 6811637], // DEPTO.ASESORIA JURIDICA  - CARMEN HENRIQUEZ OLIVARES
            //                 ['ou_id' => 31, 'user_id' => 17432199], // DEPTO.GESTION FINANCIERA (40) - ROMINA GARÍN
            //                 ['ou_id' => 2, 'user_id' => 14104369], // SUBDIRECCION GESTION ASISTENCIAL - CARLOS CALVO
            //             ]);
            $visadores = collect([$agreement->referrer]); //referente tecnico
            foreach(array(15005047, 6811637, 17432199, 14104369) as $user_id) //resto de visadores por cadena de responsabilidad
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
