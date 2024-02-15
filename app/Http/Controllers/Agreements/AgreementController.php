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
use App\Models\Documents\Document;
use App\Models\Documents\Signature;
use App\Models\Documents\SignaturesFile;
use App\Models\Documents\SignaturesFlow;
use App\Models\Documents\Type;
use App\Models\Establishment;
use App\Rrhh\OrganizationalUnit;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Luecano\NumeroALetras\NumeroALetras;
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
        $query = Agreement::with('program','stages','agreement_amounts.program_component','commune','fileToEndorse.signaturesFlows',
                                 'addendums.fileToEndorse.signaturesFlows','fileToSign.signaturesFlows','addendums.fileToSign.signaturesFlows',
                                 'continuities.fileToEndorse.signaturesFlows')
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
        $agreement->load('director_signer.user', 'commune.establishments', 'referrer', 'fileToEndorse', 'fileToSign', 'addendums.referrer', 'continuities.referrer','continuities.director_signer','continuities.document.fileToSign');
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
        
        // $users = User::orderBy('name', 'ASC')->get();
        // $organizationalUnits = OrganizationalUnit::orderBy('id', 'asc')->get();
        return view('documents.signatures.create', compact('signature'));
    }

    public function createDocument(Request $request, Agreement $agreement)
    {
        // SE OBTIENEN DATOS RELACIONADOS AL CONVENIO
    	$agreement->load('Program','Commune.municipality','agreement_amounts.program_component','agreement_quotas','director_signer.user', 'stages', 'referrer');
        // $stage          = Stage::where('agreement_id', $agreement->id)->first();
    	// $amounts        = AgreementAmount::with('program_component')->Where('agreement_id', $id)->get();
        // $quotas         = AgreementQuota::Where('agreement_id', $id)->get();
        // $municipality   = Municipality::where('commune_id', $agreements->Commune->id)->first();
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        // AL MOMENTO DE PREVISUALIZAR EL DOCUMENTO INICIA AUTOMATICAMENTE LA PRIMERA ETAPA
        if($agreement->stages->isEmpty()){
            $agreement->stages()->create(['group' => 'CON','type' => 'RTP', 'date' => Carbon::now()->toDateTimeString()]);
        }

        // SE OBTIENE LAS INSTITUCIONES DE SALUD PERO SÓLO LAS QUE SE HAN SELECCIONADO
        $establishment_list = unserialize($agreement->establishment_list) == null ? [] : unserialize($agreement->establishment_list);
        $establishments = Establishment::where('commune_id', $agreement->Commune->id)
                                       ->whereIn('id', $establishment_list)->get();

        // ARRAY PARA OBTNER LAS INSTITUCIONES ASOCIADAS AL CONVENIO
        // SI EL ARRAY DE INSTITUCIONES VIENE VACIO
        if($establishments->isEmpty()){
            $arrayEstablishmentConcat = '';
        }
        else { 
            foreach ($establishments as $key => $establishment) {
                $arrayEstablishment[] = array('index' => $key+1
                                             ,'establecimientoTipo' => $establishment->type
                                             ,'establecimientoNombre' => $establishment->name
                                             ,'establecimiento' => ucwords(mb_strtolower($establishment->type))." ".$establishment->name
                                         );
            }
            $arrayEstablishmentConcat = implode(", ",array_column($arrayEstablishment, 'establecimiento',));
        }

        // ARRAY PARA OBTENER LOS COMPONENTES ASOCIADOS AL CONVENIO
    	// foreach ($agreement->agreement_amounts as $key => $amount) {
		// 	$arrayComponent[] = array('componenteIndex' => $key+1, 'componenteNombre' => $amount->program_component->name);
    	// }
        $componentesListado = '';
        foreach ($agreement->agreement_amounts as $key => $amount){
            $componentesListado .= '<b>Componente '.($key+1).':</b> '.$amount->program_component->name.'<br><br>';
        }

        // SE CONVIERTE EL VALOR TOTAL DEL CONVENIO EN PALABRAS
        $formatter = new NumeroALetras;
        $formatter->apocope = true;
        $totalConvenio = $agreement->agreement_amounts->sum('amount');
        $totalConvenioLetras = $this->correctAmountText($formatter->toMoney($totalConvenio,0, 'pesos',''));
 
        // ARRAY PARA OBTENER LAS CUOTAS ASOCIADAS AL TOTAL DEL CONVENIO
        foreach ($agreement->agreement_quotas as $key => $quota) {
                $cuotaConvenioLetras = $this->correctAmountText($formatter->toMoney($quota->amount,0, 'pesos',''));
                $arrayQuota[] = array('index' => ($this->ordinal($key+1))
                                      ,'percentage' => $quota->percentage ?? 0
                                      ,'cuotaDescripcion' => $quota->description . ($key+1 == 1 ? ' del total de los recursos del convenio una vez aprobada la resolución exenta que aprueba el presente instrumento y recibidos los recursos del Ministerio de Salud.' : ' restante del total de recursos y se enviará en el mes de octubre, según resultados obtenidos en la primera evaluación definida en la cláusula anterior. Así también, dependerá de la recepción de dichos recursos desde Ministerio de Salud y existencia de rendición financiera según lo establece la resolución N°30 del año 2015, de la Contraloría General de la República que fija normas sobre procedimiento de rendición de cuentas de la Contraloría General de la Republica, por parte de la “MUNICIPALIDAD”.')
                                      ,'cuotaMonto' => number_format($quota->amount,0,",",".")
                                      ,'cuotaLetra' => $cuotaConvenioLetras);
             } 

        $totalQuotas = mb_strtolower($formatter->toMoney(count($agreement->agreement_quotas),0));
        if($totalQuotas == 'un ') $totalQuotas = 'una cuota'; else $totalQuotas .= 'cuotas';

        $periodoConvenio = $agreement->period;
        $fechaConvenio = date('j', strtotime($agreement->date)).' de '.$meses[date('n', strtotime($agreement->date))-1].' del año '.date('Y', strtotime($agreement->date));
    	$numResolucion = $agreement->number;
        $fechaResolucion = $agreement->resolution_date;
        $fechaResolucion = $fechaResolucion != NULL ? date('j', strtotime($fechaResolucion)).' de '.$meses[date('n', strtotime($fechaResolucion))-1].' del año '.date('Y', strtotime($fechaResolucion)) : '';
        $alcaldeApelativo = $agreement->representative_appelative;
        if(Str::contains($alcaldeApelativo, 'Subrogante')){
            $alcaldeApelativoFirma = Str::before($alcaldeApelativo, 'Subrogante') . '(S)';
        }else{
            $alcaldeApelativoFirma = explode(' ',trim($alcaldeApelativo))[0]; // Alcalde(sa)
        }
        $alcalde = $agreement->representative;
        $alcaldeDecreto = $agreement->representative_decree;
    	$municipalidad = $agreement->Commune->municipality->name_municipality;
    	$ilustre = !Str::contains($municipalidad, 'ALTO HOSPICIO') ? 'ILUSTRE': null;
    	$municipalidadDirec = $agreement->municipality_adress;
    	$comunaRut = $agreement->municipality_rut;
    	$alcaldeRut = $agreement->representative_rut;

    	$comuna = $agreement->Commune->name;
        $first_word = explode(' ',trim($agreement->Program->name))[0];
        $programa = $first_word == 'Programa' ? substr(strstr($agreement->Program->name," "), 1) : $agreement->Program->name;

        $totalEjemplares = Str::contains($municipalidad, 'IQUIQUE') ? 'cuatro': 'tres';
        $addEjemplar = Str::contains($municipalidad, 'IQUIQUE') ? 'un ejemplar para CORMUDESI': null;

        $director = mb_strtoupper($agreement->director_signer->user->fullName);
        $directorApelativo = $agreement->director_signer->appellative;
        if(!Str::contains($directorApelativo,'(S)')) $directorApelativo .= ' Titular';
        $directorRut = mb_strtoupper($agreement->director_signer->user->runFormat());
        $directorDecreto = $agreement->director_signer->decree;
        $directorNationality = Str::contains($agreement->director_signer->appellative, 'a') ? 'chilena' : 'chileno';

        if(count($agreement->agreement_quotas) == 12){ // 12 cuotas
            $totalQuotasText = $arrayQuota[0]['cuotaMonto'] == $arrayQuota[11]['cuotaMonto'] 
                                ? 'doce cuotas de $'.$arrayQuota[0]['cuotaMonto'].' ('.$arrayQuota[0]['cuotaLetra'].')'
                                : 'once cuotas de $'.$arrayQuota[0]['cuotaMonto'].' ('.$arrayQuota[0]['cuotaLetra'].') y una cuota de $'.$arrayQuota[11]['cuotaMonto'].' ('.$arrayQuota[11]['cuotaLetra'].')';
        }

        $municipality_emails = $agreement->Commune->municipality->email_municipality."\n".$agreement->Commune->municipality->email_municipality_2;

        $document = new Document();
        $document->type_id = Type::where('name','Convenio')->first()->id;
        $document->agreement_id = $agreement->id;
        // $document->subject = 'Convenio programa '.$programa.' comuna de '.$agreement->commune->name;
        $document->subject = 'Documento convenio de ejecución del programa '.$programa.' año '.$agreement->period.' comuna de '.$agreement->Commune->name;
        $document->distribution = $municipality_emails."\n".$agreement->referrer->email."\nvalentina.ortega@redsalud.gob.cl\naps.ssi@redsalud.gob.cl\nromina.garin@redsalud.gob.cl\njuridica.ssi@redsalud.gob.cl\no.partes2@redsalud.gob.cl\nblanca.galaz@redsalud.gob.cl";
        $document->content = "

        <p style='margin-top:12pt; margin-bottom:0pt;text-align:center'>
    <strong><span style='font-size:12pt; '>CONVENIO DE EJECUCIÓN </span></strong>
</p>
<p style='margin-top:12pt; margin-bottom:0pt;text-align:center'>
    <strong><span style='font-size:12pt; '>“PROGRAMA </span></strong><strong><span
            style='font-size:12pt; background-color:#00ff00'>".mb_strtoupper($programa)."</span></strong><strong><span
            style='font-size:12pt; '> AÑO </span></strong><strong><span
            style='font-size:12pt; background-color:#00ff00'>".$periodoConvenio."</span></strong><strong><span
            style='font-size:12pt; '>”</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:center'>
    <strong><span style='font-size:12pt; '>ENTRE EL SERVICIO DE SALUD TARAPACÁ Y LA
        </span></strong><strong><span style='font-size:12pt; background-color:#ffff00'>".$ilustre."
        </span></strong><strong><span
            style='font-size:12pt;background-color:#00ff00'>".$municipalidad."</span></strong><strong><span
            style='font-size:12pt; '>.</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:center'>
    <strong><span style=' '>&#xa0;</span></strong>
</p>
<p style='margin-top:12pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span style=' font-size:11pt; font-weight:normal'>En Iquique a </span><span
        style=' font-size:11pt; font-weight:normal; background-color:#00ff00'>".$fechaConvenio."</span><span
        style=' font-size:11pt; font-weight:normal'>, entre</span><span
        style=' font-size:11pt'> </span><span
        style=' font-size:11pt; font-weight:normal'>el </span><span
        style=' font-size:11pt'>SERVICIO DE SALUD TARAPACÁ</span><span
        style=' font-size:11pt; font-weight:normal'>, persona jurídica de derecho público,
    </span><span style=' font-size:11pt'>RUT. 61.606.100-3</span><span
        style=' font-size:11pt; font-weight:normal'>, con domicilio en </span><span
        style=' font-size:11pt'>calle Aníbal Pinto N°815</span><span
        style=' font-size:11pt; font-weight:normal'> de la ciudad de Iquique, representado por
        su </span><span
        style=' font-size:11pt; background-color:#00ff00'>".$directorApelativo."</span><span
        style=' font-size:11pt'> D. </span><span
        style=' font-size:11pt; background-color:#00ff00'>".$director."</span><span
        style=' font-size:11pt; font-weight:normal'>,</span><span
        style=' font-size:11pt'> </span><span
        style=' font-size:11pt; font-weight:normal; background-color:#00ff00'>".$directorNationality."</span><span
        style=' font-size:11pt; font-weight:normal'>, Cédula Nacional de Identidad </span><span
        style=' font-size:11pt; background-color:#00ff00'>N°".$directorRut."</span><span
        style=' font-size:11pt; font-weight:normal; background-color:#00ff00'>,</span><span
        style=' font-size:11pt; font-weight:normal'> del mismo domicilio del servicio público
        que representa, en adelante el </span><span style=' font-size:11pt'>“SERVICIO”
    </span><span style=' font-size:11pt; font-weight:normal'>por una parte; y por la
        otra,</span><span style=' font-size:11pt'> </span><span
        style=' font-size:11pt; font-weight:normal'>la </span><span
        style=' font-size:11pt'>".$ilustre."</span><span
        style=' font-size:11pt; font-weight:normal'> </span><span
        style=' font-size:11pt; background-color:#00ff00'>".$municipalidad."</span><span
        style=' font-size:11pt; font-weight:normal'>, persona jurídica de derecho público,
    </span><span style=' font-size:11pt; background-color:#00ff00'>RUT ".$comunaRut."</span><span
        style=' font-size:11pt; font-weight:normal; background-color:#00ff00'>,</span><span
        style=' font-size:11pt; font-weight:normal'> representada por su </span><span
        style=' font-size:11pt; background-color:#00ff00'>".$alcaldeApelativo."</span><span
        style=' font-size:11pt; font-weight:normal'> </span><span
        style=' font-size:11pt; background-color:#00ff00'>".$alcalde."</span><span
        style=' font-size:11pt; font-weight:normal'>, chileno, Cédula Nacional de Identidad
    </span><span style=' font-size:11pt; background-color:#00ff00'>N°".$alcaldeRut."</span><span
        style=' font-size:11pt; font-weight:normal'> ambos domiciliados en</span><span
        style=' font-weight:normal'> </span><span
        style=' font-size:11pt; background-color:#00ff00'>".$municipalidadDirec."</span><span
        style=' font-size:11pt'> </span><span
        style=' font-size:11pt; font-weight:normal'>de la comuna de </span><span
        style=' font-size:11pt; font-weight:normal; background-color:#00ff00'>".$comuna."</span><span
        style=' font-size:11pt; font-weight:normal'>, en adelante la </span><span
        style=' font-size:11pt'>“MUNICIPALIDAD”</span><span
        style=' font-size:11pt; font-weight:normal'>, se ha acordado celebrar un convenio, que
        consta de las siguientes cláusulas:</span>
</p>
<p style='margin-top:0pt; margin-bottom:0pt'>
    &#xa0;
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>PRIMERA: </span></strong><span>Se deja
        constancia que el Estatuto de Atención Primaria de Salud Municipal, aprobado por la Ley N°19.378, en su
        artículo 56 establece que el aporte estatal mensual podrá incrementarse: </span><strong><span
        >“En el caso que las normas técnicas, planes y programas que se impartan
            con posterioridad a la entrada en vigencia de esta ley impliquen un mayor gasto para la “MUNICIPALIDAD”,
            su financiamiento será incorporado a los aportes establecidos en el artículo 49”.</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>Por su parte, el artículo 5º del Decreto Supremo N°37 del año 2021, del
        Ministerio de Salud, reitera dicha norma agregando la forma de materializarla al señalar “para cuyos efectos
        el Ministerio de Salud dictará la correspondiente resolución”.</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>SEGUNDA: </span></strong><span>El
        presente convenio se suscribe conforme a lo establecido en el decreto con fuerza ley N°1-3063 de 1980, del
        Ministerio de Interior y sus normas complementarias; a lo acordado en los convenios celebrados en virtud de
        dichas normas entre el </span><strong><span>“SERVICIO”</span></strong><span
    > y la </span><strong><span
        >“MUNICIPALIDAD”,</span></strong><span>
        especialmente el denominado convenio per cápita, aprobado por los correspondientes decretos supremos del
        Ministerio de Salud; y a lo dispuesto en la ley N°19.378, que aprueba el Estatuto de Atención Primaria de
        Salud Municipal.</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>TERCERA:</span></strong><span> En el
        marco de la Reforma de Salud, cuyos principios orientadores apuntan a la Equidad, Participación,
        Descentralización y Satisfacción de los Usuarios, de las prioridades programáticas emanadas del Ministerio
        de Salud y de la</span><span>&#xa0; </span><span
    >modernización de la Atención Primaria, incorporándola como área y pilar
        relevante en el proceso de cambio a un nuevo modelo de atención, el Ministerio de Salud, ha decidido
        desarrollar el Programa de </span><strong><span
            style='background-color:#00ff00'>“".$programa."”</span></strong><strong><span
        > </span></strong><span>en adelante el
        “</span><strong><span>PROGRAMA”</span></strong><span>,
        a fin de contribuir a mejorar la salud de la población beneficiaria legal del
        Sector Público de Salud, aumentando la capacidad de respuesta oportuna de la atención primaria, a los
        problemas de salud por los cuales consultan las personas, para lograr una red de atención primaria más
        eficaz y cercana a éstas, contribuyendo de tal forma a mejorar los problemas de acceso y resolutividad de la
        atención de salud a la comunidad en el que participarán las partes, en conformidad a lo establecido en el
        presente convenio.</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>El referido “</span><strong><span>PROGRAMA”
        </span></strong><span>ha sido aprobado por Resolución Exenta
        N</span><strong><span>°</span></strong><span
        style='background-color:#00ff00'>".$numResolucion."</span><span>
        de fecha </span><span style='background-color:#00ff00'>".$fechaResolucion."</span><span
    >, del Ministerio de Salud y sus respectivas modificaciones, respecto a las
        exigencias de dicho programa, la </span><strong><span>“MUNICIPALIDAD”
        </span></strong><span>se compromete a desarrollar las acciones atinentes en
        virtud del presente instrumento. </span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>Se deja establecido que, para los fines específicos del presente convenio, el
    </span><strong><span>“PROGRAMA” </span></strong><span>se
        ejecutará</span><strong><span>
        </span></strong><span>en el o los siguientes dispositivos de
        salud</span><strong><span>: </span></strong><strong><span
            style='background-color:#00ff00'>&#xa0;</span></strong><span
        style='background-color:#00ff00'>".$arrayEstablishmentConcat."</span><span
    >, en los cuales se llevará a cabo el </span><strong><span
        >“PROGRAMA”</span></strong><span> a que se
        refiere el presente convenio, y que dependen de la </span><strong><span
        >“MUNICIPALIDAD”.</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>&#xa0;</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>CUARTA: </span></strong><span>El
        Ministerio de Salud, a través del “</span><strong><span
        >SERVICIO”</span></strong><span>, conviene en
        asignar a la </span><strong><span>“MUNICIPALIDAD”</span></strong><span
    > recursos destinados a financiar los siguientes componentes del
    </span><strong><span>“PROGRAMA”:</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>&#xa0;</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span style='background-color:#00ff00'>".$componentesListado."</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>&#xa0;</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>QUINTA:</span></strong><span> Conforme a
        lo señalado en las cláusulas precedentes el </span><strong><span
        >“SERVICIO”</span></strong><span> asignará a la
    </span><strong><span>“MUNICIPALIDAD”</span></strong><span
    >, desde la fecha de total tramitación de la Resolución Exenta que apruebe el
        presente instrumento, la suma anual y única de </span><strong><span
            style='background-color:#00ff00'>$".number_format($totalConvenio, 0, ',', '.')."
            (".$totalConvenioLetras.")</span></strong><span> para alcanzar el propósito y
        cumplimiento de los componentes señalados en la cláusula anterior, en la medida que esos fondos sean
        traspasados por el Ministerio de Salud al </span><strong><span>“SERVICIO”</span></strong><span>.</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>&#xa0;</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>SEXTA: </span></strong><span>La
    </span><strong><span>“MUNICIPALIDAD”</span></strong><span>
        está obligada a cumplir las coberturas definidas en este convenio, así como
        también se compromete a cumplir las acciones señaladas para las estrategias específicas. Asimismo, está
        obligada a implementar y otorgar las prestaciones que correspondan a la atención primaria, señaladas en el
    </span><strong><span>“PROGRAMA”.</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>La </span><strong><span
        >“MUNICIPALIDAD”</span></strong><span>, está
        obligada a utilizar en forma exclusiva para los objetivos del convenio, los recursos asignados según el
        siguiente detalle de objetivos y productos específicos de cada componente, especificados en la cláusula
        cuarta.</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span style='background-color:#ffff00'>Describir indicadores y medios de
        verificación……</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>El </span><strong><span
        >“SERVICIO</span></strong><span>” determinará
        previamente la pertinencia técnica de la compra de servicios o la adquisición de insumos, materiales,
        implementos, o bienes, por parte de la </span><strong><span
        >“MUNICIPALIDAD”</span></strong><span>,
        asegurando que sean acordes a las necesidades del </span><strong><span
        >“PROGRAMA</span></strong><span>” y de acuerdo
        a la normativa vigente, para estos efectos deberá enviar vía correo electrónico a la referente del programa,
        la propuesta de compras, que deberá ser aprobada por el </span><strong><span
        >“SERVICIO”</span></strong><span>, previo a su
        adquisición.</span><span>&#xa0; </span><span>El
    </span><strong><span>“SERVICIO”,</span></strong><span>
        podrá determinar otros criterios de distribución de los recursos destinados, atendiendo a criterios de
        equidad y acortamiento de brechas en el otorgamiento de las prestaciones.</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>&#xa0;</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>SÉPTIMA: </span></strong><span>El
        proceso de monitoreo y evaluación del cumplimiento del presente convenio por parte del </span><strong><span
        >“SERVICIO”,</span></strong><span> se orienta a
        conocer el desarrollo y grado de cumplimiento de los diferentes componentes del </span><strong><span
        >“PROGRAMA”</span></strong><span>, con el
        propósito de mejorar la eficiencia y efectividad de sus objetivos.</span>
</p>";

if($request->has('eval_option'))
    if($request->eval_option == 1)
        $document->content .= "<ul type='square' style='margin:0pt; padding-left:0pt'>
    <li
        style='margin-left:28.03pt; text-align:justify;padding-left:7.97pt;font-size:11pt'>
        <span style='background-color:#00ff00'>La </span><strong><span
                style='background-color:#00ff00'>primera evaluación</span></strong><span
            style='background-color:#00ff00'> técnica se efectuará con corte al
        </span><strong><span style='background-color:#00ff00'>__________ del año
                ".$periodoConvenio."</span></strong><span style='background-color:#00ff00'> por parte del
            referente técnico encargado/a del </span><strong><span
                style='background-color:#00ff00'>“PROGRAMA”</span></strong><span
            style='background-color:#00ff00'> perteneciente al </span><strong><span
                style='background-color:#00ff00'>“SERVICIO”</span></strong><span
            style='background-color:#00ff00'>, en esta instancia la comuna deberá estar al día
            con el envío de las rendiciones mensuales; en caso contrario no se procederá a hacer efectiva la
            transferencia de la segunda cuota de recursos.</span>
    </li>
</ul>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:0pt; text-align:justify; line-height:107%; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<ul type='square' style='margin:0pt; padding-left:0pt'>
    <li
        style='margin-left:28.03pt; text-align:justify;padding-left:7.97pt;font-size:11pt'>
        <span style='background-color:#00ff00'>La </span><strong><span
                style='background-color:#00ff00'>segunda evaluación </span></strong><span
            style='background-color:#00ff00'>técnica y final, se efectuará con corte al
            ___________</span><strong><span style='background-color:#00ff00'> del año
                ".$periodoConvenio."</span></strong><span style='background-color:#00ff00'>, fecha en que el
        </span><strong><span style='background-color:#00ff00'>“PROGRAMA” </span></strong><span
            style='background-color:#00ff00'>deberá tener ejecutado el </span><strong><span
                style='background-color:#00ff00'>100%</span></strong><span
            style='background-color:#00ff00'> de las acciones comprometidas en el convenio y la
        </span><strong><span style='background-color:#00ff00'>“MUNICIPALIDAD”</span></strong><span
            style='background-color:#00ff00'> haber enviado el informe técnico final de
            ejecución al ____________</span><strong><span style='background-color:#00ff00'> del
                año ____</span></strong><span style='background-color:#00ff00'>. Asimismo,
            la</span><strong><span style='background-color:#00ff00'> “MUNICIPALIDAD”
            </span></strong><span style='background-color:#00ff00'>deberá haber hecho en
            ingreso de las rendiciones mensuales hasta el mes de </span><strong><span
                style='background-color:#00ff00'>Diciembre del año ".$periodoConvenio.", </span></strong><span
            style='background-color:#00ff00'>en plataforma habilitada para estos fines. </span>
    </li>
</ul>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:0pt; text-align:justify; line-height:107%; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<ul type='square' style='margin:0pt; padding-left:0pt'>
    <li
        style='margin-left:28.03pt; text-align:justify;padding-left:7.97pt;font-size:11pt'>
        <span style='background-color:#00ff00'>En caso de incumplimiento, el
        </span><strong><span style='background-color:#00ff00'>“SERVICIO” </span></strong><span
            style='background-color:#00ff00'>deberá solicitar a la </span><strong><span
                style='background-color:#00ff00'>“MUNICIPALIDAD” </span></strong><span
            style='background-color:#00ff00'>el reintegro de los recursos que no hayan sido
            ejecutados, a más tardar el </span><strong><span style='background-color:#00ff00'>31 de
                enero del año ".($periodoConvenio+1).".</span></strong><span style='background-color:#00ff00'> </span>
    </li>
</ul>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:10pt; line-height:107%; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<ul type='square' style='margin:0pt; padding-left:0pt'>
    <li
        style='margin-left:28.03pt; text-align:justify;padding-left:7.97pt;font-size:11pt'>
        <span style='background-color:#00ff00'>Conforme los resultados obtenidos en esta
            evaluación se harán efectiva la reliquidación de la segunda cuota.</span>
    </li>
</ul>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:10pt; line-height:107%; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<p style='margin-top:12pt; margin-left:36pt; margin-bottom:12pt; text-align:justify;font-size:11pt'>
    <span style='background-color:#00ff00'>La </span><strong><span
            style='background-color:#00ff00'>Reliquidación</span></strong><span
        style='background-color:#00ff00'> a la </span><strong><span
            style='background-color:#00ff00'>“MUNICIPALIDAD”,</span></strong><span
        style='background-color:#00ff00'> se hará efectiva en el mes de Octubre por parte del
    </span><strong><span style='background-color:#00ff00'>“SERVICIO”,</span></strong><span
        style='background-color:#00ff00'> si es que el resultado final de la ponderación de los
        indicadores de la comuna es inferior al _____%, en relación al 100% de la meta anual. El descuento será
        proporcional al porcentaje de incumplimiento, de acuerdo al siguiente cuadro:</span>
</p>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:0pt; text-align:justify; line-height:107%; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<table style='border-collapse: collapse; width: 370.75pt; border-color: #000000; border-style: solid; margin-left: auto; margin-right: auto; height: 143.695px;' cellspacing='0' cellpadding='0'>
    <tr style='height:6.6pt'>
        <td
            style='width:172.95pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:3.88pt; padding-left:3.88pt; vertical-align:top; background-color:#f2f2f2'>
            <p style='margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt'>
                <strong><span style='background-color:#00ff00'>PORCENTAJE CUMPLIMIENTO METAS
                        DEL PROGRAMA</span></strong>
            </p>
        </td>
        <td
            style='width:180.05pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:3.88pt; padding-left:3.88pt; vertical-align:top; background-color:#f2f2f2'>
            <p style='margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt'>
                <strong><span style='background-color:#00ff00'>PORCENTAJE DE DESCUENTO DE
                        RECURSOS 2ª CUOTA </span></strong>
            </p>
        </td>
    </tr>
    <tr>
        <td
            style='width:172.95pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:3.88pt; padding-left:3.88pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt'>
                <span style='background-color:#00ff00'>Mayor o igual a %</span>
            </p>
        </td>
        <td
            style='width:180.05pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:3.88pt; padding-left:3.88pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt'>
                <span style='background-color:#00ff00'>0%</span>
            </p>
        </td>
    </tr>
    <tr>
        <td
            style='width:172.95pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:3.88pt; padding-left:3.88pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt'>
                <span style='background-color:#00ff00'>Entre % y %</span>
            </p>
        </td>
        <td
            style='width:180.05pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:3.88pt; padding-left:3.88pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt'>
                <span style='background-color:#00ff00'>0%</span>
            </p>
        </td>
    </tr>
    <tr>
        <td
            style='width:172.95pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:3.88pt; padding-left:3.88pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt'>
                <span style='background-color:#00ff00'>Entre % y %</span>
            </p>
        </td>
        <td
            style='width:180.05pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:3.88pt; padding-left:3.88pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt'>
                <span style='background-color:#00ff00'>0%</span>
            </p>
        </td>
    </tr>
    <tr>
        <td
            style='width:172.95pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; padding-right:3.88pt; padding-left:3.88pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt'>
                <span style='background-color:#00ff00'>Menos del %</span>
            </p>
        </td>
        <td
            style='width:180.05pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:3.88pt; padding-left:3.88pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt'>
                <span style='background-color:#00ff00'>0%</span>
            </p>
        </td>
    </tr>
</table>
<p style='margin-top:12pt; margin-left:36pt; margin-bottom:12pt; text-align:justify; line-height:107%; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<p style='margin-top:12pt; margin-left:36pt; margin-bottom:12pt; text-align:justify;font-size:11pt'>
    <span style='background-color:#00ff00'>Excepcionalmente, cuando existan razones fundadas
        del incumplimiento, la “</span><strong><span
            style='background-color:#00ff00'>MUNICIPALIDAD”,</span></strong><span
        style='background-color:#00ff00'> podrá apelar la decisión de reliquidar, mediante
        oficio enviado a Director(a) del </span><strong><span
            style='background-color:#00ff00'>“SERVICIO”</span></strong><span
        style='background-color:#00ff00'>, acompañando un Plan de Trabajo que comprometa un
        cronograma para el cumplimiento de las metas, dentro del periodo vigente del convenio. El
    </span><strong><span style='background-color:#00ff00'>“SERVICIO”,</span></strong><span
        style='background-color:#00ff00'> analizará la apelación y verificará la existencia de
        razones fundadas para el incumplimiento. En caso de comprobar la existencia de razones fundadas, el
    </span><strong><span style='background-color:#00ff00'>“SERVICIO”</span></strong><span
        style='background-color:#00ff00'> podrá pedir al Ministerio de Salud la no
        reliquidación del </span><strong><span
            style='background-color:#00ff00'>“PROGRAMA”</span></strong><span
        style='background-color:#00ff00'> adjuntando los antecedentes que respalden esta
        solicitud.</span>
</p>";
else if($request->eval_option == 2)
    $document->content .= "<ul type='square' style='margin:0pt; padding-left:0pt'>
    <li
        style='margin-left:28.03pt; text-align:justify;padding-left:7.97pt;font-size:11pt'>
        <span style='background-color:#00ff00'>La </span><strong><span
                style='background-color:#00ff00'>primera evaluación</span></strong><span
            style='background-color:#00ff00'> técnica se efectuará con corte al
        </span><strong><span style='background-color:#00ff00'>__________ del año
                ".$periodoConvenio."</span></strong><span style='background-color:#00ff00'> por parte del
            referente técnico encargado/a del </span><strong><span
                style='background-color:#00ff00'>“PROGRAMA”</span></strong><span
            style='background-color:#00ff00'> perteneciente al </span><strong><span
                style='background-color:#00ff00'>“SERVICIO”</span></strong><span
            style='background-color:#00ff00'>, en esta instancia la comuna deberá estar al día
            con el envío de las rendiciones mensuales; en caso contrario no se procederá a hacer efectiva la
            transferencia de la segunda cuota de recursos.</span>
    </li>
</ul>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:0pt; text-align:justify; line-height:107%; font-size:11pt'>
    <strong><span>&#xa0;</span></strong>
</p>
<ul type='square' style='margin:0pt; padding-left:0pt'>
    <li
        style='margin-left:28.03pt; text-align:justify;padding-left:7.97pt;font-size:11pt'>
        <span style='background-color:#00ff00'>La </span><strong><span
                style='background-color:#00ff00'>segunda evaluación </span></strong><span
            style='background-color:#00ff00'>técnica y final, se efectuará con corte al
            ___________</span><strong><span style='background-color:#00ff00'> del año
                ".$periodoConvenio."</span></strong><span style='background-color:#00ff00'>, fecha en que el
        </span><strong><span style='background-color:#00ff00'>“PROGRAMA” </span></strong><span
            style='background-color:#00ff00'>deberá tener ejecutado el </span><strong><span
                style='background-color:#00ff00'>100%</span></strong><span
            style='background-color:#00ff00'> de las acciones comprometidas en el convenio y la
        </span><strong><span style='background-color:#00ff00'>“MUNICIPALIDAD”</span></strong><span
            style='background-color:#00ff00'> haber enviado el informe técnico final de
            ejecución al ____________</span><strong><span style='background-color:#00ff00'> del
                año ____</span></strong><span style='background-color:#00ff00'>. Asimismo,
            la</span><strong><span style='background-color:#00ff00'> “MUNICIPALIDAD”
            </span></strong><span style='background-color:#00ff00'>deberá haber hecho en
            ingreso de las rendiciones mensuales hasta el mes de </span><strong><span
                style='background-color:#00ff00'>Diciembre del año ".$periodoConvenio.", </span></strong><span
            style='background-color:#00ff00'>en plataforma habilitada para estos fines. </span>
    </li>
</ul>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:0pt; text-align:justify; line-height:107%; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<ul type='square' style='margin:0pt; padding-left:0pt'>
    <li
        style='margin-left:28.03pt; text-align:justify;padding-left:7.97pt;font-size:11pt'>
        <span style='background-color:#00ff00'>En caso de incumplimiento, el
        </span><strong><span style='background-color:#00ff00'>“SERVICIO” </span></strong><span
            style='background-color:#00ff00'>deberá solicitar a la </span><strong><span
                style='background-color:#00ff00'>“MUNICIPALIDAD” </span></strong><span
            style='background-color:#00ff00'>el reintegro de los recursos que no hayan sido
            ejecutados, a más tardar el </span><strong><span style='background-color:#00ff00'>31 de
                enero del año ".($periodoConvenio+1).".</span></strong><span style='background-color:#00ff00'> </span>
    </li>
</ul>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:0pt; text-align:justify; line-height:107%; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<ul type='square' style='margin:0pt; padding-left:0pt'>
    <li
        style='margin-left:28.03pt; text-align:justify;padding-left:7.97pt;font-size:11pt'>
        <span style='background-color:#00ff00'>Conforme los resultados obtenidos en esta
            evaluación se harán efectiva la reliquidación de la segunda cuota.</span>
    </li>
</ul>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:0pt; text-align:justify; line-height:107%; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<p style='margin-top:12pt; margin-left:36pt; margin-bottom:12pt; text-align:justify;font-size:11pt'>
    <span style='background-color:#00ff00'>La </span><strong><span
            style='background-color:#00ff00'>Reliquidación</span></strong><span
        style='background-color:#00ff00'> a la </span><strong><span
            style='background-color:#00ff00'>“MUNICIPALIDAD”,</span></strong><span
        style='background-color:#00ff00'> se hará efectiva en el mes de Octubre por parte del
    </span><strong><span style='background-color:#00ff00'>“SERVICIO”,</span></strong><span
        style='background-color:#00ff00'> si es que el resultado final de la ponderación de los
        indicadores de la comuna es inferior al _____%, en relación al 100% de la meta anual. El descuento será
        proporcional al porcentaje de incumplimiento, de acuerdo al siguiente cuadro:</span>
</p>
<table style='border-collapse: collapse; width: 370.75pt; border-color: #000000; border-style: solid; margin-left: auto; margin-right: auto; height: 143.695px;' cellspacing='0' cellpadding='0'>
    <tr style='height:6.6pt'>
        <td
            style='width:172.95pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:3.88pt; padding-left:3.88pt; vertical-align:top; background-color:#f2f2f2'>
            <p style='margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt'>
                <strong><span style='background-color:#00ff00'>PORCENTAJE CUMPLIMIENTO METAS
                        DEL PROGRAMA</span></strong>
            </p>
        </td>
        <td
            style='width:180.05pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:3.88pt; padding-left:3.88pt; vertical-align:top; background-color:#f2f2f2'>
            <p style='margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt'>
                <strong><span style='background-color:#00ff00'>PORCENTAJE DE DESCUENTO DE
                        RECURSOS 2ª CUOTA </span></strong>
            </p>
        </td>
    </tr>
    <tr>
        <td
            style='width:172.95pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:3.88pt; padding-left:3.88pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt'>
                <span style='background-color:#00ff00'>Mayor o igual a %</span>
            </p>
        </td>
        <td
            style='width:180.05pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:3.88pt; padding-left:3.88pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt'>
                <span style='background-color:#00ff00'>0%</span>
            </p>
        </td>
    </tr>
    <tr>
        <td
            style='width:172.95pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:3.88pt; padding-left:3.88pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt'>
                <span style='background-color:#00ff00'>Entre % y %</span>
            </p>
        </td>
        <td
            style='width:180.05pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:3.88pt; padding-left:3.88pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt'>
                <span style='background-color:#00ff00'>0%</span>
            </p>
        </td>
    </tr>
    <tr>
        <td
            style='width:172.95pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:3.88pt; padding-left:3.88pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt'>
                <span style='background-color:#00ff00'>Entre % y %</span>
            </p>
        </td>
        <td
            style='width:180.05pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:3.88pt; padding-left:3.88pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt'>
                <span style='background-color:#00ff00'>0%</span>
            </p>
        </td>
    </tr>
    <tr>
        <td
            style='width:172.95pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; padding-right:3.88pt; padding-left:3.88pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt'>
                <span style='background-color:#00ff00'>Menos del %</span>
            </p>
        </td>
        <td
            style='width:180.05pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:3.88pt; padding-left:3.88pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt'>
                <span style='background-color:#00ff00'>0%</span>
            </p>
        </td>
    </tr>
</table>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:0pt; text-align:justify; line-height:107%; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<p style='margin-top:12pt; margin-left:36pt; margin-bottom:12pt; text-align:justify;font-size:11pt'>
    <span style='background-color:#00ff00'>Excepcionalmente, cuando existan razones fundadas
        del incumplimiento, la “</span><strong><span
            style='background-color:#00ff00'>MUNICIPALIDAD”,</span></strong><span
        style='background-color:#00ff00'> podrá apelar la decisión de reliquidar, mediante
        oficio enviado a Director(a) del </span><strong><span
            style='background-color:#00ff00'>“SERVICIO”</span></strong><span
        style='background-color:#00ff00'>, acompañando un Plan de Trabajo que comprometa un
        cronograma para el cumplimiento de las metas, dentro del periodo vigente del convenio. El
    </span><strong><span style='background-color:#00ff00'>“SERVICIO”,</span></strong><span
        style='background-color:#00ff00'> analizará la apelación y verificará la existencia de
        razones fundadas para el incumplimiento. En caso de comprobar la existencia de razones fundadas, el
    </span><strong><span style='background-color:#00ff00'>“SERVICIO”</span></strong><span
        style='background-color:#00ff00'> podrá pedir al Ministerio de Salud la no
        reliquidación del </span><strong><span
            style='background-color:#00ff00'>“PROGRAMA”</span></strong><span
        style='background-color:#00ff00'> adjuntando los antecedentes que respalden esta
        solicitud.</span>
</p>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:0pt; text-align:justify; line-height:107%; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<ul type='square' style='margin:0pt; padding-left:0pt'>
    <li
        style='margin-left:28.03pt; margin-bottom:12pt; text-align:justify;padding-left:7.97pt;font-size:11pt'>
        <span style='background-color:#00ff00'>La </span><strong><span
                style='background-color:#00ff00'>Tercera evaluación </span></strong><span
            style='background-color:#00ff00'>técnica y final, se efectuará con corte al
            ___________</span><strong><span style='background-color:#00ff00'> del año
                ".$periodoConvenio."</span></strong><span style='background-color:#00ff00'>, fecha en que el
        </span><strong><span style='background-color:#00ff00'>“PROGRAMA” </span></strong><span
            style='background-color:#00ff00'>deberá tener ejecutado el </span><strong><span
                style='background-color:#00ff00'>100%</span></strong><span
            style='background-color:#00ff00'> de las acciones comprometidas en el convenio y la
        </span><strong><span style='background-color:#00ff00'>“MUNICIPALIDAD”</span></strong><span
            style='background-color:#00ff00'> haber enviado el informe técnico final de
            ejecución al ____________</span><strong><span style='background-color:#00ff00'> del
                año ".($periodoConvenio+1)."</span></strong><span style='background-color:#00ff00'>. Asimismo,
            la</span><strong><span style='background-color:#00ff00'> “MUNICIPALIDAD”
            </span></strong><span style='background-color:#00ff00'>deberá haber hecho en
            ingreso de las rendiciones mensuales hasta el mes de </span><strong><span
                style='background-color:#00ff00'>Diciembre del año ".$periodoConvenio." </span></strong><span
            style='background-color:#00ff00'>en plataforma habilitada para estos fines. En caso
            contrario el </span><strong><span style='background-color:#00ff00'>“SERVICIO”
            </span></strong><span style='background-color:#00ff00'>procederá a solicitar a la
        </span><strong><span style='background-color:#00ff00'>“MUNICIPALIDAD”
            </span></strong><span style='background-color:#00ff00'>el reintegro de los recursos
            que no hayan sido ejecutados, a más tardar el </span><strong><span
                style='background-color:#00ff00'>31 de enero del año ".($periodoConvenio+1).".</span></strong>
    </li>
</ul>";

else // eval_option == 3
    $document->content .= "<ul type='square' style='margin:0pt; padding-left:0pt'>
    <li
        style='margin-left:28.03pt; margin-bottom:12pt; text-align:justify;padding-left:7.97pt;font-size:11pt'>
        <span style='background-color:#00ff00'>La única evaluación</span><strong><span
                style='background-color:#00ff00'> </span></strong><span
            style='background-color:#00ff00'>técnica y final, se efectuará con corte al
            ___________</span><strong><span style='background-color:#00ff00'> del año
                ".$periodoConvenio."</span></strong><span style='background-color:#00ff00'>, fecha en que el
        </span><strong><span style='background-color:#00ff00'>“PROGRAMA” </span></strong><span
            style='background-color:#00ff00'>deberá tener ejecutado el </span><strong><span
                style='background-color:#00ff00'>100%</span></strong><span
            style='background-color:#00ff00'> de las acciones comprometidas en el convenio y la
        </span><strong><span style='background-color:#00ff00'>“MUNICIPALIDAD”</span></strong><span
            style='background-color:#00ff00'> haber enviado el informe técnico final de
            ejecución al ____________</span><strong><span style='background-color:#00ff00'> del
                año ".($periodoConvenio+1)."</span></strong><span style='background-color:#00ff00'>. Asimismo,
            la</span><strong><span style='background-color:#00ff00'> “MUNICIPALIDAD”
            </span></strong><span style='background-color:#00ff00'>deberá haber hecho en
            ingreso de las rendiciones mensuales hasta el mes de </span><strong><span
                style='background-color:#00ff00'>Diciembre del año ".$periodoConvenio." </span></strong><span
            style='background-color:#00ff00'>en plataforma habilitada para estos fines. En caso
            contrario el </span><strong><span style='background-color:#00ff00'>“SERVICIO”
            </span></strong><span style='background-color:#00ff00'>procederá a solicitar a la
        </span><strong><span style='background-color:#00ff00'>“MUNICIPALIDAD”
            </span></strong><span style='background-color:#00ff00'>el reintegro de los recursos
            que no hayan sido ejecutados, a más tardar el </span><strong><span
                style='background-color:#00ff00'>31 de enero del año ".($periodoConvenio+1).".</span></strong>
    </li>
</ul>
<p style='margin-top:0pt; margin-left:35.45pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span style='background-color:#00ff00'>Este </span><strong><span
            style='background-color:#00ff00'>“PROGRAMA”</span></strong><span
        style='background-color:#00ff00'> no considera descuentos por concepto de reliquidación
        de recursos asociado a Evaluaciones de cumplimiento técnico, dado debe mantener la continuidad de las
        prestaciones de salud.</span>
</p>";

$document->content .= "

<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>No obstante, el </span><strong><span
        >“SERVICIO”</span></strong><span>, requerirá el
        envío de informes de avances de carácter técnico, con el fin de evaluar el cumplimiento de las actividades
        del </span><strong><span>“PROGRAMA”,</span></strong><span
    > y realizar recomendaciones para su correcta ejecución a través de referente
        técnico del programa de atención primaria.</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>Los datos considerados en las evaluaciones técnicas del </span><strong><span
        >“PROGRAMA”,</span></strong><span> serán
        constatados por el Departamento de Atención Primaria del </span><strong><span
        >“SERVICIO”,</span></strong><span> mediante
        solicitud de informes y visitas inspectivas por parte del/la Referente Técnico Encargado/a del
    </span><strong><span>“PROGRAM</span></strong><span>A”
        perteneciente al</span><span>&#xa0; </span><strong><span
        >“SERVICIO”</span></strong><span>. Por lo
        anterior, la </span><strong><span>“MUNICIPALIDAD”</span></strong><span
    > deberá contar con informes detallados de fácil acceso, que respalden la
        información entregada. </span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>El resultado de los indicadores al mes de diciembre del año ".$periodoConvenio.",</span><span
    >&#xa0; </span><span>podrán tener incidencia en los
        criterios de asignación de recursos del año siguiente, según señala Contraloría General de la República en
        su Resolución N°30/2015: “Los Servicios de Salud, no entregarán nuevos fondos a rendir, sea a disposición de
        unidades internas o a la administración de terceros, mientras la persona o institución que debe recibirlos
        no haya cumplido con la obligación de rendir cuenta de la inversión de los fondos ya concedidos”.</span>
</p>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:0pt; text-align:justify; line-height:107%; font-size:11pt'>
    <span>&#xa0;</span>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>La evaluación del cumplimiento se realizará en forma global para el
    </span><strong><span>“PROGRAMA”,</span></strong><span>
        según el siguiente detalle:</span>
</p>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:0pt; text-align:justify; line-height:107%; font-size:11pt'>
    <span>&#xa0;</span>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>INDICADORES Y MEDIOS DE VERIFICACIÓN:</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span style='background-color:#ffff00'>Incluir los indicadores… </span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>Para efectos de registro de información de prestaciones, solicitudes y órdenes
        de atención, éstas deberán ser registradas en Plataformas: </span><strong><span
        >REM, RAYEN, SIGGES, y OTRAS</span></strong><span>
        habilitadas para estos fines, según corresponda, únicos medios de verificación
        de atención de pacientes</span><strong><span> FONASA</span></strong><span
    >.</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>Adicionalmente el Departamento de Atención Primaria del </span><strong><span
        >“SERVICIO”,</span></strong><span> efectuará la
        fiscalización del uso correcto y adecuado de los recursos, mediante visitas inspectivas, solicitud de
        informes de avances y demás medios previstos por las normas y procedimientos de auditoría de conformidad con
        la normativa vigente. </span>
</p>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:0pt; text-align:justify; line-height:107%; font-size:11pt'>
    <span>&#xa0;</span>


<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>OCTAVA:</span></strong><strong><span
            >&#xa0;</span></strong><span>Los
        </span></a><span>recursos mencionados en la cláusula quinta financiarán
        exclusivamente las actividades relacionadas al </span><strong><span>“PROGRAMA”
        </span></strong><span>y se entregarán en </span><span
        style='background-color:#00ff00'>".$totalQuotas.",</span><span>
        de acuerdo con la siguiente manera y condiciones:</span>
</p>";

if($agreement->agreement_quotas->count() == 2)
    $document->content .= "<ul type='disc' style='margin:0pt; padding-left:0pt'>
    <li
        style='margin-left:27.14pt; margin-bottom:12pt; text-align:justify; padding-left:8.86pt; font-size:9pt; color:#404040'>
        <span style='font-size:11pt; color:#000000; background-color:#00ff00'>La primera cuota
            de $ </span><strong><span
                style='font-size:11pt; color:#000000; background-color:#00ff00'>".$arrayQuota[0]['cuotaMonto']."</span></strong><span
            style='font-size:11pt; color:#000000; background-color:#00ff00'>
        </span><strong><span
                style='font-size:11pt; color:#000000; background-color:#00ff00'>(".$arrayQuota[0]['cuotaLetra']."),</span></strong><span
            style='font-size:11pt; color:#000000; background-color:#00ff00'> correspondiente al
            ".$arrayQuota[0]['percentage']."% del total de los recursos del presente convenio, se transferirá una vez emitida la
            Resolución Exenta que aprueba el presente instrumento y una vez recibidos los recursos desde el
            Ministerio de Salud.</span>
    </li>
    <li
        style='margin-left:28.06pt; margin-bottom:12pt; text-align:justify; padding-left:7.94pt;font-size:11pt'>
        <span style='background-color:#00ff00'>La segunda cuota y final de $
        </span><strong><span style='background-color:#00ff00'>".$arrayQuota[1]['cuotaMonto']."</span></strong><span
            style='background-color:#00ff00'> </span><strong><span
                style='background-color:#00ff00'>(".$arrayQuota[1]['cuotaLetra']."),</span></strong><span
            style='background-color:#00ff00'> correspondiente al ".$arrayQuota[1]['percentage']."% del total de
            los recursos del presente convenio, se transferirá según los resultados obtenidos en la primera
            evaluación definida en la cláusula anterior y una vez sean recibidos los recursos desde el Ministerio de
            Salud.</span>
    </li>
</ul>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span style='background-color:#00ff00'>La entrega de la segunda cuota del programa estará
        condicionada a dos aspectos principales:</span>
</p>
<p
    style='margin-top:0pt; margin-left:35.4pt; margin-bottom:12pt; text-indent:0.6pt; text-align:justify;font-size:11pt'>
    <strong><span style='background-color:#00ff00'>1° Evaluación Técnica del
            Programa:</span></strong><span style='background-color:#00ff00'> Evaluación
        realizada por el Referente Técnico de Atención Primaria del </span><strong><span
            style='background-color:#00ff00'>“SERVICIO”</span></strong><span
        style='background-color:#00ff00'>, encargado del </span><strong><span
            style='background-color:#00ff00'>“PROGRAMA”</span></strong><span
        style='background-color:#00ff00'>, según la cláusula séptima del presente convenio, lo
        cual será informado por el </span><strong><span
            style='background-color:#00ff00'>“SERVICIO”</span></strong><span
        style='background-color:#00ff00'> a través de los oficios correspondientes a la
    </span><strong><span style='background-color:#00ff00'>“MUNICIPALIDAD”,
        </span></strong><span style='background-color:#00ff00'>&#xa0;</span><span
        style='background-color:#00ff00'>posterior a los cortes de evaluación indicados en la
        misma cláusula.</span><span style='background-color:#00ff00'>&#xa0;&#xa0; </span>
</p>
<p
    style='margin-top:0pt; margin-left:35.4pt; margin-bottom:12pt; text-indent:0.6pt; text-align:justify;font-size:11pt'>
    <strong><span style='background-color:#00ff00'>2° Evaluación Financiera del
            Programa:</span></strong><span style='background-color:#00ff00'> Evaluación
        realizada por el Departamento de Finanzas del </span><strong><span
            style='background-color:#00ff00'>“SERVICIO”</span></strong><span
        style='background-color:#00ff00'>, a través de la plataforma habilitada para estos
        fines </span><strong><span style='background-color:#00ff00'>“SISREC”</span></strong><span
        style='background-color:#00ff00'>,</span><span
        style='background-color:#00ff00'>&#xa0; </span><span
        style='background-color:#00ff00'>donde la </span><strong><span
            style='background-color:#00ff00'>“MUNICIPALIDAD”</span></strong><span
        style='background-color:#00ff00'> debe dar cuenta de los recursos otorgados por el
    </span><strong><span style='background-color:#00ff00'>“SERVICIO”,</span></strong><span
        style='background-color:#00ff00'> de forma mensual, según lo dispuesto en la
    </span><strong><span style='background-color:#00ff00'>Resolución N°30/2015 de Contraloría
            General de la República, </span></strong><span style='background-color:#00ff00'>que
        Fija Normas de Procedimiento sobre Rendición de Cuentas.</span>
</p>";

else if($agreement->agreement_quotas->count() == 3)
    $document->content .= "<ul type='disc' style='margin:0pt; padding-left:0pt'>
    <li
        style='margin-left:27.14pt; margin-bottom:12pt; text-align:justify; padding-left:8.86pt;font-size:9pt; color:#404040'>
        <span style='font-size:11pt; color:#000000; background-color:#00ff00'>La primera cuota
            de $ </span><strong><span
                style='font-size:11pt; color:#000000; background-color:#00ff00'>".$arrayQuota[0]['cuotaMonto']."</span></strong><span
            style='font-size:11pt; color:#000000; background-color:#00ff00'>
        </span><strong><span
                style='font-size:11pt; color:#000000; background-color:#00ff00'>(".$arrayQuota[0]['cuotaLetra']."),
            </span></strong><span
            style='font-size:11pt; color:#000000; background-color:#00ff00'>correspondiente al
            ".$arrayQuota[0]['percentage']."% del total de los recursos del presente convenio, se transferirá una vez emitida la
            Resolución Exenta que aprueba el presente instrumento y una vez recibidos los recursos desde el
            Ministerio de Salud.</span>
    </li>
    <li
        style='margin-left:28.06pt; margin-bottom:12pt; text-align:justify; padding-left:7.94pt;font-size:11pt'>
        <span style='background-color:#00ff00'>La segunda cuota de $ </span><strong><span
                style='background-color:#00ff00'>".$arrayQuota[1]['cuotaMonto']."</span></strong><span
            style='background-color:#00ff00'> </span><strong><span
                style='background-color:#00ff00'>(".$arrayQuota[1]['cuotaLetra']."),</span></strong><span
            style='background-color:#00ff00'> correspondiente al ".$arrayQuota[1]['percentage']."%</span><span
            style='background-color:#00ff00'>&#xa0; </span><span
            style='background-color:#00ff00'>del total de los recursos del presente convenio,
            se transferirá según los resultados obtenidos en la primera evaluación definida en la cláusula anterior
            y una vez sean recibidos los recursos desde el Ministerio de Salud.</span>
    </li>
</ul>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span style='background-color:#00ff00'>La entrega de la segunda cuota del programa estará
        condicionada a dos aspectos principales:</span>
</p>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:12pt; text-align:justify;font-size:11pt'>
    <strong><span style='background-color:#00ff00'>1° Evaluación Técnica del
            Programa:</span></strong><span style='background-color:#00ff00'> Evaluación
        realizada por el Referente Técnico de Atención Primaria del </span><strong><span
            style='background-color:#00ff00'>“SERVICIO”</span></strong><span
        style='background-color:#00ff00'>, encargado del </span><strong><span
            style='background-color:#00ff00'>“PROGRAMA”</span></strong><span
        style='background-color:#00ff00'>, según la cláusula séptima del presente convenio, lo
        cual será informado por el </span><strong><span
            style='background-color:#00ff00'>“SERVICIO”</span></strong><span
        style='background-color:#00ff00'> a través de la plataforma habilitada para estos fines
        a la </span><strong><span style='background-color:#00ff00'>“MUNICIPALIDAD”,
        </span></strong><span style='background-color:#00ff00'>posterior a los cortes de
        evaluación indicados en la misma cláusula.</span><span
        style='background-color:#00ff00'>&#xa0;&#xa0; </span>
</p>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:12pt; text-align:justify;font-size:11pt'>
    <strong><span style='background-color:#00ff00'>2° Evaluación Financiera del
            Programa:</span></strong><span style='background-color:#00ff00'> Evaluación
        realizada por el Departamento de Finanzas del </span><strong><span
            style='background-color:#00ff00'>“SERVICIO”</span></strong><span
        style='background-color:#00ff00'>, a través de la plataforma habilitada para estos
        fines,</span><span style='background-color:#00ff00'>&#xa0; </span><span
        style='background-color:#00ff00'>donde la </span><strong><span
            style='background-color:#00ff00'>“MUNICIPALIDAD”</span></strong><span
        style='background-color:#00ff00'> debe dar cuenta de los recursos otorgados por el
    </span><strong><span style='background-color:#00ff00'>“SERVICIO”,</span></strong><span
        style='background-color:#00ff00'> de forma mensual, según lo dispuesto en la
    </span><strong><span style='background-color:#00ff00'>Resolución N°30/2015 de Contraloría
            General de la República, </span></strong><span style='background-color:#00ff00'>que
        Fija Normas de Procedimiento sobre Rendición de Cuentas.</span>
</p>
<ul type='disc' style='margin:0pt; padding-left:0pt'>
    <li
        style='margin-left:28.06pt; margin-bottom:12pt; text-align:justify; padding-left:7.94pt;font-size:11pt'>
        <span style='background-color:#00ff00'>La tercera cuota y final de $
        </span><strong><span style='background-color:#00ff00'>".$arrayQuota[2]['cuotaMonto']."</span></strong><span
            style='background-color:#00ff00'> </span><strong><span
                style='background-color:#00ff00'>(".$arrayQuota[2]['cuotaLetra']."),</span></strong><span
            style='background-color:#00ff00'> correspondiente al ".$arrayQuota[2]['percentage']."% del total de
            los recursos del presente convenio, se transferirá según los resultados obtenidos en la segunda
            evaluación definida en la cláusula anterior y una vez sean recibidos los recursos desde el Ministerio de
            Salud.</span>
    </li>
</ul>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span style='background-color:#00ff00'>La entrega de la tercera cuota del programa estará
        condicionada a dos aspectos principales:</span>
</p>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:12pt; text-align:justify;font-size:11pt'>
    <strong><span style='background-color:#00ff00'>1° Evaluación Técnica del
            Programa:</span></strong><span style='background-color:#00ff00'> Evaluación
        realizada por el Referente Técnico de Atención Primaria del </span><strong><span
            style='background-color:#00ff00'>“SERVICIO”</span></strong><span
        style='background-color:#00ff00'>, encargado del </span><strong><span
            style='background-color:#00ff00'>“PROGRAMA”</span></strong><span
        style='background-color:#00ff00'>, según la cláusula séptima del presente convenio, lo
        cual será informado por el </span><strong><span
            style='background-color:#00ff00'>“SERVICIO”</span></strong><span
        style='background-color:#00ff00'> a través de los oficios correspondientes a la
    </span><strong><span style='background-color:#00ff00'>“MUNICIPALIDAD”,
        </span></strong><span style='background-color:#00ff00'>&#xa0;</span><span
        style='background-color:#00ff00'>posterior a los cortes de evaluación indicados en la
        misma cláusula.</span><span style='background-color:#00ff00'>&#xa0;&#xa0; </span>
</p>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:12pt; text-align:justify;font-size:11pt'>
    <strong><span style='background-color:#00ff00'>2° Evaluación Financiera del
            Programa:</span></strong><span style='background-color:#00ff00'> Evaluación
        realizada por el Departamento de Finanzas del </span><strong><span
            style='background-color:#00ff00'>“SERVICIO”</span></strong><span
        style='background-color:#00ff00'>, a través de la plataforma habilitada para estos
        fines </span><strong><span style='background-color:#00ff00'>“SISREC”</span></strong><span
        style='background-color:#00ff00'>, donde la </span><strong><span
            style='background-color:#00ff00'>“MUNICIPALIDAD”</span></strong><span
        style='background-color:#00ff00'> debe dar cuenta de los recursos otorgados por el
    </span><strong><span style='background-color:#00ff00'>“SERVICIO”,</span></strong><span
        style='background-color:#00ff00'> de forma mensual, según lo dispuesto en la
    </span><strong><span style='background-color:#00ff00'>Resolución N°30/2015 de Contraloría
            General de la República, </span></strong><span style='background-color:#00ff00'>que
        Fija Normas de Procedimiento sobre Rendición de Cuentas.</span>
</p>";

elseif($agreement->agreement_quotas->count() == 1)
    $document->content .= "<ul type='disc' style='margin:0pt; padding-left:0pt'>
    <li
        style='margin-left:28.06pt; margin-bottom:12pt; text-align:justify; padding-left:7.94pt;font-size:11pt'>
        <span style='background-color:#00ff00'>La primera y única cuota de $
        </span><strong><span style='background-color:#00ff00'>".$arrayQuota[0]['cuotaMonto']."</span></strong><span
            style='background-color:#00ff00'> </span><strong><span
                style='background-color:#00ff00'>(".$arrayQuota[0]['cuotaLetra']."),</span></strong><span
            style='background-color:#00ff00'> correspondiente al 100 % del total de los
            recursos del presente convenio, se transferirá a la </span><strong><span
                style='background-color:#00ff00'>“MUNICIPALIDAD”,</span></strong><span
            style='background-color:#00ff00'> una vez emitida la Resolución Exenta que aprueba
            el presente instrumento y una vez recibidos los recursos desde el Ministerio de Salud.</span>
    </li>
</ul>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span style='background-color:#00ff00'>La aprobación de las rendiciones mensuales de este
        Programa, se basará en dos aspectos principales:</span>
</p>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:12pt; text-align:justify;font-size:11pt'>
    <strong><span style='background-color:#00ff00'>1° Evaluación Técnica del
            Programa:</span></strong><span style='background-color:#00ff00'> Evaluación
        realizada por el Referente Técnico de Atención Primaria del </span><strong><span
            style='background-color:#00ff00'>“SERVICIO”</span></strong><span
        style='background-color:#00ff00'>, encargado del </span><strong><span
            style='background-color:#00ff00'>“PROGRAMA”</span></strong><span
        style='background-color:#00ff00'>, según la cláusula séptima del presente convenio, lo
        cual será informado por el </span><strong><span
            style='background-color:#00ff00'>“SERVICIO”</span></strong><span
        style='background-color:#00ff00'> a través de la plataforma habilitada para estos fines
        a la </span><strong><span
            style='background-color:#00ff00'>“MUNICIPALIDAD”,</span></strong><span
        style='background-color:#00ff00'> posterior a los cortes de evaluación indicados en la
        misma cláusula.</span><span style='background-color:#00ff00'>&#xa0;&#xa0; </span>
</p>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:12pt; text-align:justify;font-size:11pt'>
    <strong><span style='background-color:#00ff00'>2° Evaluación Financiera del
            Programa:</span></strong><span style='background-color:#00ff00'> Evaluación
        realizada por el Departamento de Finanzas del </span><strong><span
            style='background-color:#00ff00'>“SERVICIO”</span></strong><span
        style='background-color:#00ff00'>, a través de la plataforma habilitada para estos
        fines, donde la </span><strong><span
            style='background-color:#00ff00'>“MUNICIPALIDAD”</span></strong><span
        style='background-color:#00ff00'> debe dar cuenta de los recursos otorgados por el
    </span><strong><span style='background-color:#00ff00'>“SERVICIO”,</span></strong><span
        style='background-color:#00ff00'> de forma mensual, según lo dispuesto en la
    </span><strong><span style='background-color:#00ff00'>Resolución N°30/2015 de Contraloría
            General de la República, </span></strong><span style='background-color:#00ff00'>que
        Fija Normas de Procedimiento sobre Rendición de Cuentas.</span>
</p>";

else // $agreement->agreement_quotas == 12
    $document->content .= "<ul type='disc' style='margin:0pt; padding-left:0pt'>
    <li
        style='margin-left:28.06pt; margin-bottom:12pt; text-align:justify; padding-left:7.94pt;font-size:11pt'>
        <span style='background-color:#00ff00'>Los recursos mencionados en la Cláusula Quinta,
            financiarán exclusivamente las actividades relacionadas al “PROGRAMA”, y se entregarán en
            ".$totalQuotasText." los que</span><strong><span style='background-color:#00ff00'>
            </span></strong><span style='background-color:#00ff00'>se transferirá a la
        </span><strong><span style='background-color:#00ff00'>“MUNICIPALIDAD”,</span></strong><span
            style='background-color:#00ff00'> una vez emitida la Resolución Exenta que aprueba
            el presente instrumento y una vez recibidos los recursos desde el Ministerio de Salud, de acuerdo a la
            siguiente manera y condiciones:</span>
    </li>
</ul>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<table style='border-collapse: collapse; border-color: #000000; border-style: solid; margin-left: auto; margin-right: auto;' cellspacing='0' cellpadding='0'>
    <tr>
        <td colspan='2'
            style='width:254.7pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:center; font-size:11pt'>
                <span>N° DE CUOTAS</span>
            </p>
        </td>
        <td
            style='width:129.1pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:center; font-size:11pt'>
                <span>MONTO</span>
            </p>
        </td>
    </tr>
    <tr>
        <td
            style='width:16.75pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>1</span>
            </p>
        </td>
        <td
            style='width:227.15pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>ENERO</span>
            </p>
        </td>
        <td
            style='width:129.1pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>$ </span><strong><span
                        style='background-color:#00ff00'>".$arrayQuota[0]['cuotaMonto']."</span></strong>
            </p>
        </td>
    </tr>
    <tr>
        <td
            style='width:16.75pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>2</span>
            </p>
        </td>
        <td
            style='width:227.15pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>FEBRERO</span>
            </p>
        </td>
        <td
            style='width:129.1pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>$ </span><strong><span
                        style='background-color:#00ff00'>".$arrayQuota[1]['cuotaMonto']."</span></strong>
            </p>
        </td>
    </tr>
    <tr>
        <td
            style='width:16.75pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>3</span>
            </p>
        </td>
        <td
            style='width:227.15pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>MARZO</span>
            </p>
        </td>
        <td
            style='width:129.1pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>$ </span><strong><span
                        style='background-color:#00ff00'>".$arrayQuota[2]['cuotaMonto']."</span></strong>
            </p>
        </td>
    </tr>
    <tr>
        <td
            style='width:16.75pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>4</span>
            </p>
        </td>
        <td
            style='width:227.15pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>ABRIL</span>
            </p>
        </td>
        <td
            style='width:129.1pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>$ </span><strong><span
                        style='background-color:#00ff00'>".$arrayQuota[3]['cuotaMonto']."</span></strong>
            </p>
        </td>
    </tr>
    <tr>
        <td
            style='width:16.75pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>5</span>
            </p>
        </td>
        <td
            style='width:227.15pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>MAYO</span>
            </p>
        </td>
        <td
            style='width:129.1pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>$ </span><strong><span
                        style='background-color:#00ff00'>".$arrayQuota[4]['cuotaMonto']."</span></strong>
            </p>
        </td>
    </tr>
    <tr>
        <td
            style='width:16.75pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>6</span>
            </p>
        </td>
        <td
            style='width:227.15pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>JUNIO</span>
            </p>
        </td>
        <td
            style='width:129.1pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>$ </span><strong><span
                        style='background-color:#00ff00'>".$arrayQuota[5]['cuotaMonto']."</span></strong>
            </p>
        </td>
    </tr>
    <tr>
        <td
            style='width:16.75pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>7</span>
            </p>
        </td>
        <td
            style='width:227.15pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>JULIO</span>
            </p>
        </td>
        <td
            style='width:129.1pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>$ </span><strong><span
                        style='background-color:#00ff00'>".$arrayQuota[6]['cuotaMonto']."</span></strong>
            </p>
        </td>
    </tr>
    <tr>
        <td
            style='width:16.75pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>8</span>
            </p>
        </td>
        <td
            style='width:227.15pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>AGOSTO</span>
            </p>
        </td>
        <td
            style='width:129.1pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>$ </span><strong><span
                        style='background-color:#00ff00'>".$arrayQuota[7]['cuotaMonto']."</span></strong>
            </p>
        </td>
    </tr>
    <tr>
        <td
            style='width:16.75pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>9</span>
            </p>
        </td>
        <td
            style='width:227.15pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>SEPTIEMBRE</span>
            </p>
        </td>
        <td
            style='width:129.1pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>$ </span><strong><span
                        style='background-color:#00ff00'>".$arrayQuota[8]['cuotaMonto']."</span></strong>
            </p>
        </td>
    </tr>
    <tr>
        <td
            style='width:16.75pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>10</span>
            </p>
        </td>
        <td
            style='width:227.15pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>OCTUBRE</span>
            </p>
        </td>
        <td
            style='width:129.1pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>$ </span><strong><span
                        style='background-color:#00ff00'>".$arrayQuota[9]['cuotaMonto']."</span></strong>
            </p>
        </td>
    </tr>
    <tr>
        <td
            style='width:16.75pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>11</span>
            </p>
        </td>
        <td
            style='width:227.15pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>NOVIEMBRE</span>
            </p>
        </td>
        <td
            style='width:129.1pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>$ </span><strong><span
                        style='background-color:#00ff00'>".$arrayQuota[10]['cuotaMonto']."</span></strong>
            </p>
        </td>
    </tr>
    <tr>
        <td
            style='width:16.75pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>12</span>
            </p>
        </td>
        <td
            style='width:227.15pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>DICIEMBRE</span>
            </p>
        </td>
        <td
            style='width:129.1pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
            <p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
                <span>$ </span><strong><span
                        style='background-color:#00ff00'>".$arrayQuota[11]['cuotaMonto']."</span></strong>
            </p>
        </td>
    </tr>
</table>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span style='background-color:#00ff00'>La aprobación de las rendiciones mensuales de este
        “PROGRAMA”, se basará en dos aspectos principales:</span>
</p>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:12pt; text-align:justify;font-size:11pt'>
    <strong><span style='background-color:#00ff00'>1° Evaluación Técnica del
            Programa:</span></strong><span style='background-color:#00ff00'> Evaluación
        realizada por el Referente Técnico de Atención Primaria del </span><strong><span
            style='background-color:#00ff00'>“SERVICIO”</span></strong><span
        style='background-color:#00ff00'>, encargado del </span><strong><span
            style='background-color:#00ff00'>“PROGRAMA”</span></strong><span
        style='background-color:#00ff00'>, según la cláusula séptima del presente convenio, lo
        cual será informado por el </span><strong><span
            style='background-color:#00ff00'>“SERVICIO”</span></strong><span
        style='background-color:#00ff00'> a través de los oficios correspondientes a la
    </span><strong><span style='background-color:#00ff00'>“MUNICIPALIDAD”,</span></strong><span
        style='background-color:#00ff00'> posterior a los cortes de evaluación indicados en la
        misma cláusula.</span><span style='background-color:#00ff00'>&#xa0;&#xa0; </span>
</p>
<p style='margin-top:0pt; margin-left:36pt; margin-bottom:12pt; text-align:justify; line-height:115%; font-size:11pt'>
    <strong><span style='background-color:#00ff00'>2° Evaluación Financiera del
            Programa:</span></strong><span style='background-color:#00ff00'> Evaluación
        realizada por el Departamento de Finanzas del </span><strong><span
            style='background-color:#00ff00'>“SERVICIO”</span></strong><span
        style='background-color:#00ff00'>, a través de la plataforma habilitada para estos
        fines </span><strong><span style='background-color:#00ff00'>“SISREC”</span></strong><span
        style='background-color:#00ff00'>,</span><span
        style='background-color:#00ff00'>&#xa0; </span><span
        style='background-color:#00ff00'>donde la </span><strong><span
            style='background-color:#00ff00'>“MUNICIPALIDAD”</span></strong><span
        style='background-color:#00ff00'> debe dar cuenta de los recursos otorgados por el
    </span><strong><span style='background-color:#00ff00'>“SERVICIO”,</span></strong><span
        style='background-color:#00ff00'> de forma mensual, según lo dispuesto en la
    </span><strong><span style='background-color:#00ff00'>Resolución N°30/2015 de Contraloría
            General de la República, </span></strong><span style='background-color:#00ff00'>que
        Fija Normas de Procedimiento sobre Rendición de Cuentas.</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:9pt'>
    <span style='font-family:Menlo; color:#404040'>&#xa0;</span>
</p>";

$document->content .= "
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>NOVENA: </span></strong><span>El
    </span><strong><span>“SERVICIO”</span></strong><span>
        no asume responsabilidad financiera mayor que la que en este convenio se señala. Por ello, en el caso que la
    </span><strong><span>“MUNICIPALIDAD”</span></strong><span>
        se exceda de los fondos destinados por el </span><strong><span
        >“SERVICIO”</span></strong><span> para los
        efectos de este convenio, esta asumirá el gasto excedente, lo que no debe afectar el cumplimiento, ni los
        plazos de ejecución dispuestos por este medio para otorgar las prestaciones y/o acciones propias del
    </span><strong><span>“PROGRAMA”.</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>&#xa0;</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>DÉCIMA: </span></strong><span
        >La Municipalidad deberá rendir los gastos del Programa, únicamente
            utilizando el Sistema de Rendición Electrónica de cuentas de la Contraloría General de la República, en
            adelante, “</span><strong><span>SISREC”</span></strong><span
        > y de conformidad con lo establecido en la </span><strong><span
            >Resolución N° 30/2015, de la Contraloría General de la
                República,</span></strong><span> o de las resoluciones que la modifiquen
            o la reemplacen.</span></a>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
    <span>En plataforma </span><strong><span
        >“SISREC”,</span></strong><span> la rendición
        debe presentar documentos auténticos digitalizados y documentos electrónicos, previa validación del ministro
        de fe de la </span><strong><span>“MUNICIPALIDAD”, </span></strong><span
    >que justifiquen cada uno de los gastos realizados en el mes
        correspondiente.</span>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
    <span>La</span><strong><span>
            “MUNICIPALIDAD”</span></strong><span> por su parte</span><strong><span
        >,</span></strong><span> quedará obligada, en
        su calidad de ejecutor, a lo siguiente:</span>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
    <strong><span>a)</span></strong><span> Utilizar la
        plataforma </span><strong><span>“SISREC”</span></strong><span
    > para la rendición de cuentas a que dé lugar al presente convenio, ocupando las
        funcionalidades que otorga el perfil </span><strong><span
        >“EJECUTOR”,</span></strong><span> dando
        cumplimiento al marco normativo aplicable que instruye la Contraloría General de la República en la
        Resolución N°30/2015.</span>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
    <strong><span>b)</span></strong><span> Asignar a los
        funcionarios que cuenten con las competencias técnicas y atribuciones necesarias para perfilarse en calidad
        de titular, y al menos un subrogante, en los roles de encargado, analista y ministro de fe, en
    </span><strong><span>“SISREC”.</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
    <strong><span>c)</span></strong><span> Disponer de
        medios tecnológicos de hardware y software para realizar la rendición de cuentas con documentación
        electrónica y digital a través del </span><strong><span
        >“SISREC”.</span></strong><span> Lo anterior
        incluye: la adquisición de token para firma electrónica avanzada del encargado ejecutor, scanner para
        digitalización de documentos en papel, contar con casilla de correo electrónico e internet.</span>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
    <strong><span>d)</span></strong><span> Custodiar
        adecuadamente los documentos originales de la rendición garantizando su autenticidad, integridad y
        disponibilidad para las revisiones de la Contraloría General de la República, en el marco de la normativa
        legal pertinente.</span>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
    <strong><span>e)</span></strong><strong><span>&#xa0;
        </span></strong><span>Solicitar el cierre de Proyecto en </span><strong><span
        >“SISREC”.</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
    <strong><span>El “SERVICIO”</span></strong><span>, por
        su parte, quedará obligado, en su calidad de otorgante, a lo siguiente:</span>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
    <strong><span>a)</span></strong><span> Asignar a los
        funcionarios que cuenten con las competencias técnicas y las atribuciones necesarias para perfilarse en
        calidad de titular, y al menos un subrogante, en los roles de encargado y analista de la plataforma
    </span><strong><span>“SISREC”</span></strong><span
    >.</span>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
    <strong><span>b)</span></strong><span> Disponer de
        medios tecnológicos de hardware y software para realizar la rendición de cuentas del proyecto, con
        documentación electrónica y digital a través de la plataforma </span><strong><span
        >“SISREC”,</span></strong><span> durante el
        período de rendición de la totalidad de los recursos transferidos para la ejecución del proyecto. Lo
        anterior incluye: la adquisición de token para la firma electrónica avanzada del encargado otorgante,
        scanner para digitalización de documentos en papel, contar con casilla de correo electrónico e
        internet.</span>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
    <span>&#xa0;</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>La </span><strong><span
        >“MUNICIPALIDAD”</span></strong><span> deberá
        rendir los gastos mensuales del Programa una vez realizada la primera remesa, utilizando la plataforma
    </span><strong><span>“SISREC”</span></strong><span> y
        sujetándose a lo establecido en la Resolución N°30/2015 de la Contraloría General de la República, según las
        siguientes fechas:</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:10pt'>
    <span style='color:#ff6600'>&#xa0;</span>
</p>
<div style='text-align:center'>
<table style='border-collapse: collapse; border-color: #000000; border-style: solid; margin-left: auto; margin-right: auto;' cellspacing='0' cellpadding='0'>
        <tr>
            <td
                style='width:104.65pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top; background-color:#f2f2f2'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <strong><span>MES PARA RENDIR</span></strong>
                </p>
            </td>
            <td
                style='width:150.15pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top; background-color:#f2f2f2'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <strong><span>PLAZO ENVÍO RENDICIÓN</span></strong>
                </p>
            </td>
        </tr>
        <tr>
            <td
                style='width:104.65pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <span>Enero ".$periodoConvenio."</span>
                </p>
            </td>
            <td
                style='width:150.15pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <span>&#xa0;</span><span>Febrero
                        ".$periodoConvenio."</span>
                </p>
            </td>
        </tr>
        <tr>
            <td
                style='width:104.65pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <span>Febrero ".$periodoConvenio."</span>
                </p>
            </td>
            <td
                style='width:150.15pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <span>&#xa0;</span><span>Marzo
                        ".$periodoConvenio."</span>
                </p>
            </td>
        </tr>
        <tr>
            <td
                style='width:104.65pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <span>Marzo ".$periodoConvenio."</span>
                </p>
            </td>
            <td
                style='width:150.15pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <span>&#xa0;</span><span>Abril
                        ".$periodoConvenio."</span>
                </p>
            </td>
        </tr>
        <tr>
            <td
                style='width:104.65pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <span>Abril ".$periodoConvenio."</span>
                </p>
            </td>
            <td
                style='width:150.15pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <span>&#xa0;</span><span>Mayo
                        ".$periodoConvenio."</span>
                </p>
            </td>
        </tr>
        <tr>
            <td
                style='width:104.65pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <span>Mayo ".$periodoConvenio."</span>
                </p>
            </td>
            <td
                style='width:150.15pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <span>&#xa0;</span><span>Junio
                        ".$periodoConvenio."</span>
                </p>
            </td>
        </tr>
        <tr>
            <td
                style='width:104.65pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <span>Junio ".$periodoConvenio."</span>
                </p>
            </td>
            <td
                style='width:150.15pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <span>&#xa0;</span><span>Julio
                        ".$periodoConvenio."</span>
                </p>
            </td>
        </tr>
        <tr>
            <td
                style='width:104.65pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <span>Julio ".$periodoConvenio."</span>
                </p>
            </td>
            <td
                style='width:150.15pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <span>&#xa0;</span><span>Agosto
                        ".$periodoConvenio."</span>
                </p>
            </td>
        </tr>
        <tr>
            <td
                style='width:104.65pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <span>Agosto ".$periodoConvenio."</span>
                </p>
            </td>
            <td
                style='width:150.15pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <span>&#xa0;</span><span>Septiembre
                        ".$periodoConvenio."</span>
                </p>
            </td>
        </tr>
        <tr>
            <td
                style='width:104.65pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <span>Septiembre ".$periodoConvenio."</span>
                </p>
            </td>
            <td
                style='width:150.15pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <span>&#xa0;</span><span>Octubre
                        ".$periodoConvenio."</span>
                </p>
            </td>
        </tr>
        <tr>
            <td
                style='width:104.65pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <span>Octubre ".$periodoConvenio."</span>
                </p>
            </td>
            <td
                style='width:150.15pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <span>&#xa0;</span><span>Noviembre
                        ".$periodoConvenio."</span>
                </p>
            </td>
        </tr>
        <tr>
            <td
                style='width:104.65pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <span>Noviembre ".$periodoConvenio."</span>
                </p>
            </td>
            <td
                style='width:150.15pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <span>&#xa0;</span><span>Diciembre
                        ".$periodoConvenio."</span>
                </p>
            </td>
        </tr>
        <tr>
            <td
                style='width:104.65pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <span>Diciembre ".$periodoConvenio."</span>
                </p>
            </td>
            <td
                style='width:150.15pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <span>&#xa0;</span><span>Enero
                        ".($periodoConvenio+1)."</span>
                </p>
            </td>
        </tr>
        <tr>
            <td
                style='width:104.65pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <strong><span>Enero ".($periodoConvenio+1)."</span></strong>
                </p>
            </td>
            <td
                style='width:150.15pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top'>
                <p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
                    <strong><span>&#xa0;</span></strong><strong><span
                        >Febrero ".($periodoConvenio+1)."</span></strong>
                </p>
            </td>
        </tr>
    </table>
</div>

<p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
    <em><span>&#xa0;</span></em>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
    <em><span>El periodo a rendir del mes de enero ".($periodoConvenio+1).", corresponde únicamente a
            boletas de honorarios y liquidaciones de remuneraciones cuyos montos líquidos son devengados o pagados
            antes del 31 de diciembre de ".$periodoConvenio." y que sus pagos de impuestos e imposiciones son efectuados en enero de
            ".($periodoConvenio+1).", considerando que, por proceso tributario, éstos últimos terminan siendo enterados al fisco al mes
            siguiente. Esto no implica, bajo ningún aspecto, que la ejecución del programa sea hasta el mes de enero
            de ".($periodoConvenio+1).", por lo que no se aceptará la rendición de otros gastos efectuados.</span></em>
</p>
<p style='margin-top:12pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>Dichos informes mensuales, deberán contar con documentación de respaldo, la
        que deberá encontrarse en estado devengado y pagado. Los antecedentes de respaldo deben ser original
        digitalizado o electrónico y deben incluir lo que señala a continuación, según corresponda en cada programa
        de salud:</span>
</p>
<ul type='square' style='margin:0pt; padding-left:0pt'>
    <li style='margin-left:28.03pt; padding-left:7.97pt;font-size:11pt'>
        <span>Copia de comprobantes de ingreso digitalizado o electrónico.</span>
    </li>
    <li style='margin-left:28.03pt; padding-left:7.97pt;font-size:11pt'>
        <span>Copia de comprobantes de egreso digitalizado o electrónico.</span>
    </li>
    <li style='margin-left:28.03pt; padding-left:7.97pt;font-size:11pt'>
        <span>Copia boletas de honorario de RRHH digitalizado o electrónico.</span>
    </li>
    <li style='margin-left:28.03pt; padding-left:7.97pt;font-size:11pt'>
        <span>Contrato de personal RRHH digitalizado o electrónico.</span>
    </li>
    <li style='margin-left:28.03pt; padding-left:7.97pt;font-size:11pt'>
        <span>Facturas y/o boletas compras de insumos o equipamiento digitalizado o
            electrónico.</span>
    </li>
    <li style='margin-left:28.03pt; margin-bottom:12pt; padding-left:7.97pt;font-size:11pt'>
        <span>Boletas de respaldo en caso de tener caja chica</span><span>&#xa0;</span><span>o
                fondo por rendir digitalizado o electrónico.</span>
    </li>
</ul>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>Asimismo, toda la documentación original de respaldo, deberá estar disponible
        en la </span><strong><span>“MUNICIPALIDAD' </span></strong><span
    >para cuando el </span><strong><span
        >“SERVICIO”</span></strong><span> así lo
        requiera, para su fiscalización, en caso de ser necesario.</span>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
    <strong><span style='font-family:Calibri; color:#ff0000'>&#xa0;</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
    <strong><span>DÉCIMA PRIMERA:</span></strong><span> En
        el caso que se registren excedentes de los recursos financieros en el ítem de Recursos Humanos del programa,
        la “</span><strong><span>MUNICIPALIDAD”</span></strong><span
    > podrá redestinarlos para el pago de extensión u horas extras de los recursos
        humanos contratados para la ejecución del </span><strong><span
        >“PROGRAMA”</span></strong><span> y/o contratar
        recurso humano de acuerdo al convenio y a las necesidades del </span><strong><span
        >“PROGRAMA”</span></strong><span> para su
        eficiente ejecución, siempre con previa autorización del Referente Técnico del Servicio, encargado/a del
    </span><strong><span>“PROGRAMA”.</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>&#xa0;</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>DÉCIMA SEGUNDA: </span></strong><span>La
    </span><strong><span>“MUNICIPALIDAD”</span></strong><span
    >, deberá dar cumplimiento a las normas de procedimientos establecidos, de manera
        que el Organismo Público receptor estará obligado a enviar a la Unidad otorgante un comprobante de ingreso
        por los recursos percibidos y un informe mensual de su inversión, que deberá señalar, el monto de los
        recursos recibidos en el mes, el monto detallado de la inversión realizada y el saldo disponible para el mes
        siguiente. </span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>Por lo anterior, y con el fin de monitorear, controlar y asegurar la oportuna
        entrega de recursos al Departamento de Salud, la </span><strong><span
        >“MUNICIPALIDAD”</span></strong><span> deberá
        rendir el informe mensual en </span><strong><span>“SISREC”,</span></strong><span
    > dentro de
    </span><strong><span>los quince primeros días hábiles administrativos siguientes
            al que se informa</span></strong><span>, incluso en aquellos meses en que no
        exista inversión de los fondos traspasados, y deberá señalar, el monto de los recursos recibidos en el mes,
        el monto detallado de la inversión y el saldo disponible para el mes siguiente. Cuando el organismo
        receptor, esto es, la </span><strong><span>“MUNICIPALIDAD”</span></strong><span
    > tenga la
        calidad de ejecutor, deberá proporcionar información sobre el avance de las actividades realizadas.</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>Asimismo, la </span><strong><span
        >“MUNICIPALIDAD”</span></strong><span>, deberá
        registrar en plataforma </span><strong><span>“SISREC”,</span></strong><span
    > en un periodo no superior a 07 días hábiles, al </span><strong><span
        >“SERVICIO”</span></strong><span>, el
        comprobante de ingreso municipal que acredita que la </span><strong><span
        >“MUNICIPALIDAD”</span></strong><span>, recibió
        la transferencia de fondos, materia de este convenio.</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>El </span><strong><span
        >“PROGRAMA”</span></strong><span> estará sujeto
        a que el Departamento de Atención Primaria de Salud, Departamento de finanzas y/o las respectivas
        Subdirecciones del </span><strong><span>“SERVICIO”</span></strong><span
    >, valide en terreno las rendiciones financieras para lo cual, la
    </span><strong><span>“MUNICIPALIDAD”</span></strong><span>
        se compromete a tener la documentación original que respalde su gasto en
        función del </span><strong><span>“PROGRAMA”</span></strong><span
    >.</span><span>&#xa0; </span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>&#xa0;</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>DÉCIMA TERCERA:</span></strong><span>
        Será responsabilidad de la </span><strong><span
        >“MUNICIPALIDAD”</span></strong><span>, velar
        por la correcta administración de los fondos recibidos, gastados e invertidos en las diferentes unidades de
        Salud. Lo anterior, independientemente de las atribuciones que le competen al </span><strong><span
        >“SERVICIO”</span></strong><span>, en el
        sentido de exigir oportunamente la rendición de cuentas de los fondos entregados y de las revisiones que
        pudiese efectuar, el Departamento de Atención Primaria, Subdirección Médica y/o el Departamento de Gestión
        Financiera, o Subdirección Administrativa del </span><strong><span
        >“SERVICIO”</span></strong><span>.</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>Por su parte, la </span><strong><span
        >“MUNICIPALIDAD”</span></strong><span> se
        compromete a facilitar al </span><strong><span>“SERVICIO”</span></strong><span
    > todos los informes y datos que sean requeridos para la evaluación del
        cumplimiento de las actividades y ejecución de los recursos en su formato original. El incumplimiento de la
        entrega de cualquier documento a que se refiere esta cláusula, requerido por el </span><strong><span
        >“SERVICIO”</span></strong><span>, se pondrá en
        conocimiento de las autoridades de control, tanto interno como externo de la Administración del Estado, para
        que adopten las medidas consignadas en la normativa vigente.</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>&#xa0;</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>DÉCIMA CUARTA:</span></strong><span
        > El presente convenio tendrá vigencia a partir del </span><strong><span
            >01 de enero del año ".$periodoConvenio." al 31 de diciembre del año ".$periodoConvenio."
            </span></strong><span>para la ejecución de las actividades comprendidas en
            este convenio.</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>Sin perjuicio de lo anterior, las partes acuerdan que el presente convenio se
        prorrogará de forma automática y sucesiva, siempre que el programa a ejecutar cuente con la disponibilidad
        presupuestaria según la ley de presupuestos del sector público del año respectivo, salvo que las partes
        decidan ponerle termino por motivos fundados.</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>La prórroga del convenio comenzará a regir desde el 01 de enero del año
        presupuestario siguiente y su duración se extenderá hasta el 31 de diciembre del mismo.</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>Para todos los efectos legales, la prórroga automática da inicio a un nuevo
        convenio de transferencia, cuyo monto a transferir se establecerá mediante Resolución Exenta del
    </span><strong><span>“SERVICIO”</span></strong><span>,
        de conformidad a lo que se disponga en la Ley de Presupuestos del Sector Público respectiva.</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>&#xa0;</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>DÉCIMA QUINTA: </span></strong><span
    >Considerando la necesidad de asegurar la continuidad de la atención y
        prestaciones de salud, las partes dejan constancia que por tratarse de un </span><strong><span
        >“PROGRAMA”</span></strong><span> ministerial
        que se ejecuta todos los años, las prestaciones descritas en éste se comenzaron a otorgar desde el
    </span><strong><span>01 de enero del año ".$periodoConvenio."</span></strong><span
    >, razón por la cual dichas atenciones se imputarán a los recursos que se
        transferirán en conformidad a lo señalado en el presente convenio. Lo anterior según se establece en la Ley
        de Bases N°19.880 en su artículo 52.</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>&#xa0;</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>DÉCIMA SEXTA</span></strong><strong><em><span
                >:</span></em></strong><strong><span
            >&#xa0;</span></strong><span>Finalizado el
            período de vigencia del presente convenio, los saldos transferidos no utilizados, deberán ser
            reintegrados por la</span><span>&#xa0;</span><strong><span
            >“MUNICIPALIDAD”</span></strong><span>, a
            Rentas Generales de la nación, a más tardar</span><span
        >&#xa0;</span><strong><span>el 31 de enero del
                año ".($periodoConvenio+1)."</span></strong><span>, según señala el artículo 7° de la Ley
            N°21.516 de Presupuesto para el sector público, correspondiente al año ".$periodoConvenio.", salvo casos excepcionales
            debidamente fundados.</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>Los fondos transferidos a la “</span><strong><span
        >MUNICIPALIDAD”, </span></strong><span>solo
        podrán ser destinados a los objetivos y actividades que determine el programa en las cláusulas sexta y
        séptima del presente convenio. </span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <span>En el caso que la </span><strong><span
        >“MUNICIPALIDAD”</span></strong><span> por
        razones debidamente fundadas, no cumpla con las acciones y ejecuciones presupuestarias establecidas en el
        convenio, puede solicitar una modificación a través de Oficio dirigido a Director(a) del
    </span><strong><span>“SERVICIO”</span></strong><span>
        para su aprobación, exponiendo los fundamentos pertinentes y respaldos hasta el </span><strong><span
        >30 de octubre del año ".$periodoConvenio."</span></strong><span
    >.</span><span>&#xa0; </span><span
    >El Referente Técnico del </span><strong><span
        >“PROGRAMA”</span></strong><span> del
    </span><strong><span>“SERVICIO”</span></strong><span>
        es el encargado de ponderar esta solicitud, considerando que la destinación de estos recursos es solo para
        acciones atingentes al programa. Excepcionalmente y en la medida que se reciban nuevos recursos
        se procederá a
        elaborar addendum correspondiente.</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>&#xa0;</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>DÉCIMA SÉPTIMA: </span></strong><span>El
        envío de información financiera e informes técnicos solicitados en el presente convenio, deberán realizarse
        en sistema de Rendiciones </span><strong><span>“SISREC”,</span></strong><span
    > único medio habilitado para estos fines. Para efectos de prestaciones y
        solicitudes u órdenes de atención, deberán realizarse en sistema de registro </span><strong><span
        >REM, RAYEN,</span></strong><span>
        plataformas</span> <span>y
        planillas normadas según corresponda, medios de verificación de atención de
        pacientes </span><strong><span>FONASA.</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>&#xa0;</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>DÉCIMA OCTAVA:</span></strong><span> Las
        partes fijan su domicilio en la Primera Región, sometiéndose a la competencia de sus tribunales de
        Justicia.</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>&#xa0;</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:11pt'>
    <strong><span>DÉCIMA NOVENA:</span></strong><span>
        Déjese constancia que la personería de </span><strong><span
            style='background-color:#00ff00'>D. ".$director."</span></strong><strong><span
        > </span></strong><span>para representar al
        Servicio de Salud de Tarapacá, consta en el </span><span
        style='background-color:#00ff00'>".$directorDecreto."</span><span
    >. La representación de D. </span><strong><span
            style='background-color:#00ff00'>".$alcalde."</span></strong><span
    > para actuar en nombre de la </span><span
        style='background-color:#ffff00'>".ucfirst(mb_strtolower($ilustre))."</span><span>
        Municipalidad de </span><span style='background-color:#00ff00'>".$comuna."</span><span
    >, emana del </span><span
        style='background-color:#00ff00'>".$alcaldeDecreto."</span><span>
        de la </span><span style='background-color:#ffff00'>".ucfirst(mb_strtolower($ilustre))."</span><span
    >
        Municipalidad de </span><span style='background-color:#00ff00'>".$comuna."</span><span
    >.</span>
</p>
<p style='margin-top:0pt; margin-bottom:0pt; text-align:justify; font-size:10pt'>
    <span>&#xa0;</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>&#xa0;</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>VIGÉSIMA:</span></strong><span> El
        presente Convenio se firma digitalmente en un ejemplar, quedando este en poder del </span><strong><span
        >“SERVICIO”. </span></strong><span>Por su
        parte,</span><strong><span> </span></strong><span>la
    </span><strong><span>“MUNICIPALIDAD”
        </span></strong><span>contraparte de este convenio y la División de Atención
        Primaria de Ministerio de Salud e involucrados, recibirán el documento original digitalizado. </span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>&#xa0;</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>VIGÉSIMA PRIMERA:</span></strong><span>
        Los bienes, equipos e infraestructura adquiridos con los fondos del presente convenio, deberán contar con un
        logo del Servicio de Salud Tarapacá y deberán mantener su destino conforme a los objetivos del presente
        programa, no pudiendo destinarse a otros fines.</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>&#xa0;</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:11pt'>
    <strong><span>VIGÉSIMA SEGUNDA:</span></strong><span>
        El gasto que irrogue el presente convenio se imputará al Ítem </span><span
        style='background-color:#ffff00'>N°24-03 298-002</span><span>
    </span><strong><span>“Presupuesto vigente del
            Servicio de Salud Tarapacá año ".$periodoConvenio."”.</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:10pt'>
    <span>&#xa0;</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:10pt'>
    <span>&#xa0;</span>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:10pt'>
    <strong><span>&#xa0;</span></strong>
</p>
<p style='margin-top:0pt; margin-bottom:12pt; text-align:justify; font-size:10pt'>
    <strong><span>&#xa0;</span></strong>
</p>
<div style='text-align:center'>
    <table cellspacing='0' cellpadding='0'
        style='width:339.75pt; margin-right:auto; margin-left:auto; border-collapse:collapse'>
        <tr style='height:25.05pt'>
            <td style='width:339.75pt; vertical-align:top'>
                <p style='margin:0pt 2.1pt 0pt 7.1pt; text-align:center; font-size:11pt'>
                    <strong><span style='background-color:#00ff00'>".$alcalde."</span></strong>
                </p>
                <p style='margin:0pt 2.1pt 0pt 7.1pt; text-align:center; font-size:11pt'>
                    <strong><span
                            style='background-color:#00ff00'>".$alcaldeApelativoFirma."</span></strong>
                </p>
                <p style='margin:0pt 2.1pt 0pt 7.1pt; text-align:center; font-size:11pt'>
                    <strong><span style='background-color:#00ff00'>".$ilustre." ".
                            $municipalidad."</span></strong>
                </p>
            </td>
        </tr>
    </table>
</div>

";
        
        $types = Type::whereNull('partes_exclusive')->pluck('name','id');
        return view('documents.create', compact('document', 'types'));
    }

    public function ordinal($n){
        $ordinales = array('primera','segunda','tercera','cuarta','quinta','sexta','septima','octava','novena','decima','onceava','doceava');

        if ($n<=count ($ordinales)){
            return $ordinales[$n-1];
        }
        return $n.'-esimo';
    }

    public function correctAmountText($amount_text)
    {
        $amount_text = ucwords(mb_strtolower($amount_text));
        // verificamos si antes de cerrar en pesos la ultima palabra termina en Millón o Millones, de ser así se agregar "de" antes de cerrar con pesos
        $words_amount = explode(' ',trim($amount_text));
        return ($words_amount[count($words_amount) - 2] == 'Millon' || $words_amount[count($words_amount) - 2] == 'Millones') ? substr_replace($amount_text, 'de ', (strlen($amount_text) - 5), 0) : $amount_text;
    }

    public function formatDate($date)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        return date('j', strtotime($date)).' de '.$meses[date('n', strtotime($date))-1].' del año '.date('Y', strtotime($date));
    }
}
