<?php

namespace App\Http\Controllers\Agreements;

use App\Models\Agreements\Addendum;
use App\Models\Agreements\Signer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Agreements\ContinuityResolution;
use App\Models\Documents\Document;
use App\Models\Documents\Signature;
use App\Models\Documents\SignaturesFile;
use App\Models\Documents\SignaturesFlow;
use App\Models\Documents\Type;
use App\Models\Establishment;
use App\Models\Parameters\Municipality;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Luecano\NumeroALetras\NumeroALetras;

class ContinuityResolutionController extends Controller
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $continuityResolution = new ContinuityResolution($request->all());
        $continuityResolution->save();

        session()->flash('info', 'La nueva resolución de continuidad ha sido creado.');
        return redirect()->back();
    }

    // METODO PARA ACTUALIZAR LA ETAPA DESDE LA TABLA DE SEGUIMIENTO DE CONVENIOS
    public function update(Request $request, ContinuityResolution $continuityResolution)
    {
        // $attributes = $this->validate($request, $rules);
        // $addendum->update($attributes);

        // $validated = $request->validate([
        //     'title' => 'required|unique:posts|max:255',
        //     'body' => 'required',
        // ]);
        $continuityResolution->update($request->All());
        
        if($request->hasFile('file')){
            Storage::disk('gcs')->delete($continuityResolution->file);
            $continuityResolution->file = $request->file('file')->store('ionline/agreements/continuity', ['disk' => 'gcs']);
        }

        if($request->hasFile('res_file')){
            Storage::disk('gcs')->delete($continuityResolution->res_file);
            $continuityResolution->res_file = $request->file('res_file')->store('ionline/agreements/continuity_res', ['disk' => 'gcs']);
        }

        $continuityResolution->save();

        session()->flash('info', 'La resolución de continuidad #'.$continuityResolution->id.' ha sido actualizado.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agreements\Addendum  $addendum
     * @return \Illuminate\Http\Response
     */
    public function show(ContinuityResolution $continuityResolution)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agreements\Addendum  $addendum
     * @return \Illuminate\Http\Response
     */
    public function edit(ContinuityResolution $continuityResolution)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agreements\Addendum  $addendum
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agreements\Addendum  $addendum
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContinuityResolution $continuityResolution)
    {
        //
    }

    public function download(ContinuityResolution $continuityResolution)
    {
        return Storage::disk('gcs')->response($continuityResolution->file, mb_convert_encoding($continuityResolution->name,'ASCII'));
    }

    public function downloadRes(ContinuityResolution $continuityResolution)
    {
        return Storage::disk('gcs')->response($continuityResolution->res_file, mb_convert_encoding($continuityResolution->name,'ASCII'));
    }

    public function preview(ContinuityResolution $continuityResolution)
    {
        $filename = 'tmp_files/'.$continuityResolution->file;
        if(!Storage::disk('public')->exists($filename))
            Storage::disk('public')->put($filename, Storage::disk('gcs')->get($continuityResolution->file));
        return Redirect::away('https://view.officeapps.live.com/op/embed.aspx?src='.asset('storage/'.$filename));
    }

    public function sign(ContinuityResolution $continuityResolution, $type)
    {
        if(!in_array($type, array('visators', 'signer'))) abort(404);

        $continuityResolution->load('agreement.commune.municipality','agreement.program','referrer', 'director_signer.user');
        $municipio = (!Str::contains($continuityResolution->agreement->commune->municipality->name_municipality, 'ALTO HOSPICIO') ? 'Ilustre ' : '').'Municipalidad de '.$continuityResolution->agreement->commune->name;
        $first_word = explode(' ',trim($continuityResolution->agreement->program->name))[0];
        $programa = $first_word == 'Programa' ? substr(strstr($continuityResolution->agreement->program->name," "), 1) : $continuityResolution->agreement->program->name;

        $signature = new Signature();
        $signature->request_date = $continuityResolution->date;
        $signature->type_id = Type::where('name','Resolución')->first()->id;
        $signature->type = $type;
        $signature->continuity_resol_id = $continuityResolution->id;
        $signature->subject = 'Resolución prórroga automática Convenio programa '.$programa.' comuna de '.$continuityResolution->agreement->commune->name;
        $signature->description = 'Documento de resolución prórroga automática de convenio de ejecución del programa '.$programa.' año '.date('Y', strtotime($continuityResolution->date)).' comuna de '.$continuityResolution->agreement->commune->name;
        $signature->endorse_type = 'Visación en cadena de responsabilidad';
        $signature->recipients = 'sdga.ssi@redsalud.gov.cl,jurídica.ssi@redsalud.gov.cl,cxhenriquez@gmail.com,'.$continuityResolution->referrer->email.',natalia.rivera.a@redsalud.gob.cl,apoyo.convenioaps@redsalud.gob.cl,pablo.morenor@redsalud.gob.cl,finanzas.ssi@redsalud.gov.cl,jaime.abarzua@redsalud.gov.cl,aps.ssi@redsalud.gob.cl';
        $signature->distribution = 'División de Atención Primaria MINSAL,Oficina de Partes SST,'.$municipio;

        $signaturesFile = new SignaturesFile();
        $signaturesFile->file_type = 'documento';

        if($type == 'signer'){
            $signaturesFlow = new SignaturesFlow();
            $signaturesFlow->type = 'firmante';
            $signaturesFlow->ou_id = $continuityResolution->director_signer->user->organizational_unit_id;
            $signaturesFlow->user_id = $continuityResolution->director_signer->user->id;
            $signaturesFile->signaturesFlows->add($signaturesFlow);
        }

        if($type == 'visators'){
            //visadores por cadena de responsabilidad en orden parte primero por el referente tecnico
            // $visadores = collect([
            //                 ['ou_id' => 12, 'user_id' => 15005047] // DEPTO. ATENCION PRIMARIA DE SALUD - ANA MARIA MUJICA
            //                 ['ou_id' => 61, 'user_id' => 12834358], // DEPTO.ASESORIA JURIDICA  - LUIS MUENA BUGUEÑO
            //                 ['ou_id' => 31, 'user_id' => 17432199], // DEPTO.GESTION FINANCIERA (40) - ROMINA GARÍN
            //                 ['ou_id' => 2, 'user_id' => 14104369], // SUBDIRECCION GESTION ASISTENCIAL - CARLOS CALVO
            //             ]);
            $visadores = collect([$continuityResolution->referrer]); //referente tecnico
            foreach(array(15005047, 12834358, 17432199, 14104369) as $user_id) //resto de visadores por cadena de responsabilidad
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

    public function createDocumentResContinuity(ContinuityResolution $continuityResolution)
    {
        $continuityResolution->load('agreement.program','agreement.commune.municipality', 'referrer', 'director_signer.user', 'agreement.addendums');
        $year = $continuityResolution->date != NULL ? date('Y', strtotime($continuityResolution->date)) : '';
        $municipality   = Municipality::where('commune_id', $continuityResolution->agreement->commune->id)->first();
        
        // No se guarda los cambios en el res continuidad ya que es solo para efectos de generar el documento
        $formatter = new NumeroALetras;
        $formatter->apocope = true;
        $totalConvenio = $continuityResolution->amount;
        $totalConvenioLetras = $this->correctAmountText($formatter->toMoney($totalConvenio,0, 'pesos',''));
        $totalConvenio = number_format($totalConvenio,0,",",".");

        $first_word = explode(' ',trim($continuityResolution->agreement->program->name))[0];
        $programa = $first_word == 'Programa' ? substr(strstr($continuityResolution->agreement->program->name," "), 1) : $continuityResolution->agreement->program->name;
        $comuna = $continuityResolution->agreement->commune->name;
        if($continuityResolution->agreement->period >= 2022) $programa = mb_strtoupper($programa);
        $ilustre = !Str::contains($municipality->name_municipality, 'ALTO HOSPICIO') ? 'Ilustre': null;
        $fechaResolucionConvenio = $this->formatDate($continuityResolution->agreement->res_exempt_date);
		$periodoConvenio = $continuityResolution->agreement->period;
        $yearResolucionConvenio = $continuityResolution->agreement->res_exempt_date != NULL ? date('Y', strtotime($continuityResolution->agreement->res_exempt_date)) : '';
        $directorDecreto = $continuityResolution->director_signer->decree;
        $numResolucion = $continuityResolution->agreement->number;
        $yearResolucion = $continuityResolution->agreement->resolution_date != NULL ? date('Y', strtotime($continuityResolution->agreement->resolution_date)) : '';
        $fechaResolucion = $this->formatDate($continuityResolution->agreement->resolution_date);
        $numResourceResolucion = $continuityResolution->agreement->res_resource_number;
        $yearResourceResolucion = $continuityResolution->agreement->res_resource_date != NULL ? date('Y', strtotime($continuityResolution->agreement->res_resource_date)) : '';
        $fechaResourceResolucion = $this->formatDate($continuityResolution->agreement->res_resource_date);
        $numResolucionConvenio = $continuityResolution->agreement->res_exempt_number;

        // SE OBTIENE LAS INSTITUCIONES DE SALUD PERO SÓLO LAS QUE SE HAN SELECCIONADO
        $establishment_list = unserialize($continuityResolution->agreement->establishment_list) == null ? [] : unserialize($continuityResolution->agreement->establishment_list);
        $establishments = Establishment::where('commune_id', $continuityResolution->agreement->Commune->id)
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
            $arrayEstablishmentConcat = implode(", ",array_column($arrayEstablishment, 'establecimiento'));
        }

        //CARGAR ADDENDUMS EN VISTOS Y CONSIDERANDOS
        $vistosAddendums = '';
        $considerandoAddendums = '';

        $len = $continuityResolution->agreement->addendums->count();
        if($continuityResolution->agreement->addendums->isNotEmpty()){
            $considerandoAddendums .= $len > 1 ? 'Resoluciones Exentas ' : 'Resolución Exenta ';
            foreach($continuityResolution->agreement->addendums as $key => $addendum){
                if($key+1 == $len && $len > 1){
                    $vistosAddendums .= ' y '; 
                    $considerandoAddendums .= ' y '; 
                }
                $vistosAddendums .= 'Resolución Exenta N°'.($addendum->res_number ?? '____').' de fecha '.($this->formatDate($addendum->res_date) ?? '______________');
                $considerandoAddendums .= 'N°'.($addendum->res_number ?? '____').'/'.($addendum->res_date != NULL ? date('Y', strtotime($addendum->res_date)) : '______');
                if($key+2 < $len){
                    $vistosAddendums .= ', ';
                    $considerandoAddendums .= ', ';
                }
            }

            $vistosAddendums .= ' del Servicio de Salud Tarapacá que modifica'.($len > 1 ? 'n' : '').' la resolución anterior';
            $considerandoAddendums .= ' que modifica'.($len > 1 ? 'n' : '').' la resolución anterior';
        }

        if($vistosAddendums == '') $vistosAddendums = 'Resoluciones modificatorias si es que existieran';
        if($considerandoAddendums == '') $considerandoAddendums = 'Resoluciones modificatorias si es que existieran';

        // return $considerandoAddendums;

        $establecimientosListado = $arrayEstablishmentConcat;

        $municipality_emails = $continuityResolution->agreement->commune->municipality->email_municipality."\n".$continuityResolution->agreement->commune->municipality->email_municipality_2;


        $document = new Document();
        $document->continuity_resol_id = $continuityResolution->id;
        $document->date = $continuityResolution->date;
        $document->type_id = Type::where('name','Resolución Continuidad Convenio')->first()->id;
        $document->subject = 'Resolución prórroga automática Convenio programa '.$programa.' comuna de '.$continuityResolution->agreement->commune->name;
        $document->distribution = $municipality_emails."\n".$continuityResolution->referrer->email."\nvalentina.ortega@redsalud.gob.cl\naps.ssi@redsalud.gob.cl\nromina.garin@redsalud.gob.cl\njuridica.ssi@redsalud.gob.cl\no.partes2@redsalud.gob.cl\nblanca.galaz@redsalud.gob.cl";
        $document->content = "
        <p><strong>VISTOS,</strong></p>
    
        <p style='text-align: justify;'>
        Lo dispuesto en el Decreto con Fuerza de Ley N<span style='color:black;'>&ordm;</span> 01 del
        a&ntilde;o 2000, del Ministerio Secretar&iacute;a General de la Presidencia que fija el texto refundido, coordinado
        y sistematizado de la Ley N<span style='color:black;'>&ordm;</span>18.575, Org&aacute;nica Constitucional de Bases
        Generales de la Administraci&oacute;n del Estado; D.F.L. N<span style='color:black;'>&ordm;</span>01/2005, del
        Ministerio de Salud, &nbsp; que fija el texto refundido, coordinado y sistematizado del Decreto Ley N<span
            style='color:black;'>&ordm;</span>2.763 de 1979 y de las Leyes Nos. 18.933 y 18.469; Ley 19.937 de Autoridad
        Sanitaria;&nbsp;Ley N<span style='color:black;'>&ordm;</span>19.880 que establece Bases de Procedimientos
        Administrativos que rigen los actos de los &Oacute;rganos de la Administraci&oacute;n del Estado; Decreto
        N&deg;140/04 del Ministerio de Salud que aprob&oacute; el Reglamento org&aacute;nico de los Servicios de
        Salud,&nbsp;<span style='background:lime;'>".$directorDecreto."</span>;&nbsp;lo dispuesto en el art&iacute;culo 55 bis, 56 y 57 inciso segundo de la Ley N<span
            style='color:black;'>&ordm;</span>19.378; art&iacute;culo 6 del Decreto Supremo N<span
            style='color:black;'>&ordm;</span>118 del 2007, del Ministerio de Salud;&nbsp;Resoluci&oacute;n Exenta N<span
            style='color:black;'>&ordm;</span><span style='background:lime;'>".$numResolucion."/".$yearResolucion."</span> del Ministerio de Salud, que
        aprob&oacute; <span style='background:lime;'>el Programa de ".$programa." a&ntilde;o ".$periodoConvenio."; <span style='background:lime;'>".$vistosAddendums."</span>; Resoluci&oacute;n
            Exenta&nbsp;N&deg;".$numResourceResolucion."/".$yearResourceResolucion."</span> del Ministerio de Salud, que distribuy&oacute; los recursos del citado Programa;
            &nbsp;Resoluci&oacute;n Exenta N<span
            style='color:black;'>&ordm;</span><span style='background:lime;'>_____/".($year)."</span> del Ministerio de Salud, que
        aprob&oacute; <span style='background:lime;'>el Programa de ".$programa." a&ntilde;o ".($year)."; Resoluci&oacute;n
            Exenta&nbsp;N&deg;_____/".($year)."</span> del Ministerio de Salud, que distribuy&oacute; los recursos del citado Programa;
        Resoluci&oacute;n Exenta N<span style='color:black;'>&ordm;</span>007 de 2019 de la Contralor&iacute;a General de la
        Rep&uacute;blica. Art&iacute;culo 7&deg; de la Ley N<span style='color:black;'>&ordm; 21.640 de Presupuesto para el
            sector p&uacute;blico, correspondiente al a&ntilde;o 2024.</span></p>
            
        <p><strong>CONSIDERANDO,</strong></p>
        
        <p style='text-align: justify;'>
            <strong>1.- </strong> Que, durante el a&ntilde;o presupuestario 2023, a trav&eacute;s de Resoluci&oacute;n 
            Exenta <span style='background:lime;'>N&deg;".$numResolucionConvenio."/".$yearResolucionConvenio." y ".$considerandoAddendums."</span>, 
            entre el Municipio de <span style='background:lime;'>".$comuna."</span> y este Servicio de Salud, 
            se aprob&oacute; el convenio correspondiente <strong>al <span style='background:lime;'>PROGRAMA &ldquo; 
            ".$programa." A&Ntilde;O ".$periodoConvenio."&rdquo;</span>.</strong>
        </p>

        <p style='text-align: justify;'>
            <strong>2.- </strong> Que, el citado Convenio incorpora en su cl&aacute;usula D&eacute;cimo Cuarta, 
            una pr&oacute;rroga autom&aacute;tica, la que consigna 
            <em>
            &ldquo;Las partes acuerdan que el presente convenio se prorrogar&aacute; 
            de forma autom&aacute;tica y sucesiva, siempre que el programa a ejecutar
            cuente con la disponibilidad presupuestaria seg&uacute;n la ley de presupuestos del sector p&uacute;blico del
            a&ntilde;o respectivo, salvo que las partes decidan ponerle termino por motivos fundados. La pr&oacute;rroga del
            convenio comenzar&aacute; a regir desde el 01 de enero del a&ntilde;o presupuestario siguiente y su
            duraci&oacute;n se extender&aacute; hasta el 31 de diciembre del mismo.
        </p>
        <p style='text-align: justify;'>
            <em>
            Para todos los efectos legales, la pr&oacute;rroga autom&aacute;tica da inicio a un nuevo convenio de
            transferencia, cuyo monto a transferir se establecer&aacute; mediante Resoluci&oacute;n Exenta del
            <strong>&ldquo;SERVICIO&rdquo;</strong>, de conformidad a lo que se disponga en la Ley de Presupuestos del
            Sector P&uacute;blico respectiva
            &rdquo;.
            </em>
        </p>

        <p style='text-align: justify;'>
            <strong>3.- </strong> Que, a trav&eacute;s de Resoluci&oacute;n Exenta 
            <span style='background:lime;'>N&deg;_____</span> de fecha <span style='background:lime;'>__ de _____ del a&ntilde;o 2024</span> 
            del Ministerio de Salud, se aprueba el Programa <span style='background:lime;'><strong>".$programa."</strong> para el a&ntilde;o
            2024.</span>
        </p>

        <p style='text-align: justify;'>
            <strong>4.- </strong> Que, a trav&eacute;s de Resoluci&oacute;n Exenta 
            <span style='background:lime;'>N&deg;_____</span> de fecha 
            <span style='background:lime;'>__ de _____ del a&ntilde;o 2024</span> 
            del Ministerio de Salud, se aprueban los Recursos que distribuye los Recursos para el Programa 
            <span style='background:lime;'><strong> ".$programa." </strong> para el a&ntilde;o 2024.
            </span>
        </p>

        <p style='text-align: justify;'>
            <strong>5.- </strong> Que, de acuerdo a lo señalado en Ley de presupuesto N°21.640 para el año 2024, 
            aprobado el 18 de diciembre del 2023, en la Partida 16, Capítulo 02, Programa 02; 
            <em>
                “Se podrá incorporar en estos convenios, una cláusula que permita su prórroga automática, 
                en la medida que los programas a ejecutar cuenten con recursos disponibles según la Ley de 
                Presupuestos del Sector Público del año respectivo. Las metas y recursos asociados a 
                dichas prórrogas serán fijadas por el Servicio de Salud, mediante resolución y deberán 
                estar sujetos a las instrucciones que dicte el Ministerio de Salud”.
            </em>
        </p>

        <p style='text-align: justify;'>
            <strong>6.- </strong> <span style='background:yellow;'> Que, través de Resoluci&oacute;n Exenta 
            N &deg;__ de fecha __ de _____ del a&ntilde;o 2024, el Servicio de Salud Tarapac&aacute;, 
            autoriz&oacute; Prorroga de Continuidad del Convenio Programa 
            <strong> ".$programa." </strong> comuna de ".$comuna." para el a&ntilde;o 2024.</span>
        </p>
        <br>
        
        <p><strong>RESUELVO,</strong></p>

        <p style='text-align: justify;'>
            <strong>1.- APRU&Eacute;BASE</strong> la Pr&oacute;rroga de continuidad de convenio del Programa 
            <span style='background:lime;'>&ldquo;<strong> ".$programa." &rdquo;</strong>, Comuna de </span>
            <span style='background:lime;'> ".$comuna." </span>, para ser ejecutado desde el 01 de enero del a&ntilde;o 2024 
            al 31 de diciembre del mismo a&ntilde;o, por lo cual se modifican las cláusulas que se indican a continuación, 
            conforme el texto que se transcribe respecto de cada una de ellas, el que pasa a reemplazar totalmente la anterior.
        </p>
        <br>

        <ol>
            <li>
                <strong>Cl&aacute;usula Tercera (Aprobatoria del Programa):</strong>
                <br>
                <p style='text-align: justify;'>
                    El referido &ldquo;<strong>PROGRAMA&rdquo;&nbsp;</strong>ha sido aprobado por Resoluci&oacute;n Exenta 
                    N&deg; <span style='background:lime;'>_____ de fecha __ de _____ del a&ntilde;o 2024</span> 
                    del Ministerio de Salud y sus respectivas modificaciones, respecto a las exigencias de dicho programa, 
                    la <strong>&ldquo;MUNICIPALIDAD&rdquo;&nbsp;</strong>se compromete a desarrollar las acciones atinentes
                    en virtud del presente instrumento.</p>
                <p style='text-align: justify;'>
                    Se deja establecido que, para los fines espec&iacute;ficos del presente convenio,
                    el <strong>&ldquo;PROGRAMA&rdquo;</strong> se ejecutar&aacute; en el o los 
                    <span style='background:lime;'>siguientes dispositivos de salud <strong>".$establecimientosListado."</strong></span>, 
                    en los cuales se llevar&aacute; a cabo el <strong>&ldquo;PROGRAMA&rdquo;</strong> a que se refiere el presente
                    convenio, y que dependen de la <strong>&ldquo;MUNICIPALIDAD&rdquo;.</strong>
                </p>
            </li>
            <li>
                <strong>Cl&aacute;usula Cuarta (Componentes):</strong>
                <br>
                <p style='text-align: justify;'>
                    El Ministerio de Salud, a trav&eacute;s del &ldquo;<strong>SERVICIO&rdquo;</strong>, conviene en asignar a la 
                    <strong>&ldquo;MUNICIPALIDAD&rdquo;</strong> recursos destinados a financiar los siguientes componentes del 
                    <strong>&ldquo;PROGRAMA&rdquo;</strong>:
                </p>
                <br>
                <table style='border-collapse: collapse; width: 100%;' border='1'>
                    <tbody>
                        <tr>
                            <td style='width: 100%;'>
                                <p><span style='background:lime;'>(cuadro de texto)</span></p>
                                <ol>
                                    <li><span style='background:lime;'>.....</span>
                                        <ol style='list-style-type: lower-alpha;'>
                                            <li><span style='background:lime;'>.....</span></li>
                                            <li><span style='background:lime;'>.....</span></li>
                                            <li><span style='background:lime;'>.....</span></li>
                                        </ol>
                                    </li>
                                </ol>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
            </li>
            <li>
                <strong>Cl&aacute;usula Quinta (Financiamiento)</strong>
                <br>
                <p style='text-align: justify; background: yellow;'>
                    Conforme a lo se&ntilde;alado en las cl&aacute;usulas precedentes el 
                    <strong>&ldquo;SERVICIO&rdquo;</strong> asignar&aacute; a la&nbsp;
                    <strong>&ldquo;MUNICIPALIDAD&rdquo;</strong>, desde la fecha de total tramitaci&oacute;n de la Resoluci&oacute;n Exenta 
                    que apruebe el presente instrumento, la suma anual y &uacute;nica de&nbsp;
                    <strong>$".$totalConvenio." (".$totalConvenioLetras.")</strong>, de acuerdo a Resoluci&oacute;n que Aprueba 
                    &nbsp;Recursos del referido programa, por parte del Ministerio de Salud, a&ntilde;o 2024 y su respectiva 
                    redistribuci&oacute;n, para alcanzar el prop&oacute;sito y cumplimiento de los componentes se&ntilde;alados en 
                    la cl&aacute;usula anterior, en la medida que esos fondos sean traspasados por el Ministerio de Salud al 
                    <strong>&ldquo;SERVICIO&rdquo;</strong>.
                </p>
            </li>
            <li>
                <strong><span style='background: lime;'>Cl&aacute;usula Sexta (Objetivos)</span></strong>
                <br>
                <p style='text-align: justify;'>
                    La <strong>&ldquo;MUNICIPALIDAD&rdquo;</strong>, est&aacute; obligada a utilizar en forma exclusiva para los 
                    objetivos del convenio, los recursos asignados seg&uacute;n el siguiente detalle de objetivos y productos 
                    espec&iacute;ficos de cada componente, especificados en la cl&aacute;usula cuarta, pudiendo ser destinado el recurso 
                    para uno o m&aacute;s componentes seg&uacute;n la necesidad del <strong>&ldquo;PROGRAMA&rdquo;</strong>:
                </p>
                <br>
                <table style='border-collapse: collapse; width: 100%;' border='1'>
                    <tbody>
                        <tr>
                            <td style='text-align: center;'><strong>RECURSOS</strong></td>
                            <td style='text-align: center;'><strong>OBJETIVOS</strong></td>
                        </tr>
                        <tr>
                            <td rowspan='4'>$</td>
                            <td>TEXTO</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td rowspan='5'>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td rowspan='3'>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
                <br>
            </li>
            <li>
                <strong>Cl&aacute;usula S&eacute;ptima (Evaluaciones de Cumplimiento)</strong>
                <br>
                <p style='text-align: justify;'>
                    El proceso de monitoreo y evaluaci&oacute;n del cumplimiento del presente convenio por parte del 
                    <strong>&ldquo;SERVICIO&rdquo;</strong>, se orienta a conocer el desarrollo y grado de cumplimiento de los 
                    diferentes componentes del <strong>&ldquo;PROGRAMA&rdquo;</strong>, con el prop&oacute;sito de mejorar la eficiencia 
                    y efectividad de sus objetivos:
                </p>
                <table style='border-collapse: collapse; width: 100%;' border='1'>
                    <tbody>
                        <tr>
                            <td style='width: 100%;'>
                                <ol style='list-style-type: upper-roman;'>
                                    <li><span style='background:lime;'>&Uacute;nica Evaluaci&oacute;n.</span></li>
                                    <li><span style='background:lime;'>Dos Evaluaciones.</span></li>
                                    <li><span style='background:lime;'>Tres Evaluaciones.</span></li>
                                    <li><span style='background:lime;'>Evaluaciones mensuales.</span></li>
                                </ol>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <p style='text-align: justify;'>
                    La evaluaci&oacute;n del cumplimiento se realizar&aacute; en forma global para el 
                    <strong>&ldquo;PROGRAMA&rdquo;</strong>, seg&uacute;n el siguiente detalle:
                </p>

                <p style='text-align: justify;'>
                    <strong><span style='color:black;'>INDICADORES Y MEDIOS DE VERIFICACI&Oacute;N:</span></strong>
                </p>
                <table style='border-collapse: collapse; width: 100%;' border='1'>
                    <tbody>
                        <tr>
                            <td><strong>INDICADOR N&deg;</strong></td>
                            <td colspan='2'><strong>NOMBRE DEL INDICADOR</strong></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td colspan='2'>&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan='2'><strong>F&Oacute;RMULA</strong></td>
                            <td><strong>VALOR ESPERADO</strong></td>
                        </tr>
                        <tr>
                            <td colspan='2'>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><strong>NUMERADOR</strong></td>
                            <td>&nbsp;</td>
                            <td><strong>FUENTE DE INFORMACI&Oacute;N</strong></td>
                        </tr>
                        <tr>
                            <td><strong>DENOMINADOR</strong></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <p style='text-align: justify;'>
                    Este <strong>&ldquo;PROGRAMA&rdquo;</strong> considera/no considera descuentos por concepto de 
                    reliquidaci&oacute;n de recursos asociado a Evaluaciones de cumplimiento t&eacute;cnico, 
                    dado debe mantener la continuidad de las prestaciones de salud.</span>
                </p>
            </li>
            <li>
                <strong>Cl&aacute;usula Octava (Entrega de Recursos)</strong>
                <br>
                <p style='text-align: justify;'>
                    Los&nbsp;recursos mencionados en la cl&aacute;usula quinta financiar&aacute;n exclusivamente las actividades
                    relacionadas al <strong>&ldquo;PROGRAMA&rdquo;&nbsp;</strong>y se <span style='background:lime;'>entregar&aacute;n
                        en _____</span><span style='background:lime;'>&nbsp;cuotas</span>, de acuerdo con la siguiente manera y
                    condiciones:
                </p>
                <table style='border-collapse: collapse; width: 100%;' border='1'>
                    <tbody>
                        <tr>
                            <td>
                                <ul>
                                    <li><span style='background:lime;'>La primera y &uacute;nica cuota de</span></li>
                                    <li><span style='background:lime;'>Dos cuotas</span></li>
                                    <li><span style='background:lime;'>Tres cuotas</span></li>
                                    <li><span style='background:lime;'>12 cuotas</span></li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
            </li>
            <li>
                <strong>Cl&aacute;usula D&eacute;cima Cuarta (Vigencia)</strong>
                <br>
                <p style='text-align: justify;'>
                    La presente Resoluci&oacute;n de Continuidad, tendr&aacute; vigencia a partir del <strong>01 de enero del a&ntilde;o
                        2024 al 31 de diciembre del a&ntilde;o 2024&nbsp;</strong>para la ejecuci&oacute;n de las actividades
                    comprendidas en este convenio.
                </p>
                <p style='text-align: justify;'>
                    Sin perjuicio de lo anterior, las partes acuerdan que el presente convenio se prorrogar&aacute; de forma
                    autom&aacute;tica y sucesiva, siempre que el programa a ejecutar cuente con la disponibilidad presupuestaria
                    seg&uacute;n la ley de presupuestos del sector p&uacute;blico del a&ntilde;o respectivo, salvo que las partes
                    decidan ponerle termino por motivos fundados.
                </p>
            </li>
            <li>
                <strong>Cl&aacute;usula D&eacute;cimo Sexta (Reintegro de recursos)</strong>
                <br>
                <p style='text-align: justify;'>
                    Finalizado el per&iacute;odo de vigencia de la presente Resoluci&oacute;n de Continuidad, los saldos transferidos y
                    no utilizados, deber&aacute;n ser reintegrados por la&nbsp;<strong>&ldquo;MUNICIPALIDAD&rdquo;</strong>, a Rentas
                    Generales de la naci&oacute;n, a m&aacute;s tardar&nbsp;el<strong>&nbsp;31 de enero del a&ntilde;o 2025,</strong>
                    seg&uacute;n se&ntilde;ala el art&iacute;culo 7&deg; de la <span style='background:lime;'>Ley N&deg;21.640 de</span>
                    Presupuesto para el sector p&uacute;blico, correspondiente al a&ntilde;o 2024, salvo casos excepcionales debidamente fundados.
                </p>
                <p style='text-align: justify;'>
                    En el caso que la <strong>&ldquo;MUNICIPALIDAD&rdquo;</strong> por razones debidamente fundadas, no cumpla con las
                    acciones y ejecuciones presupuestarias establecidas en el convenio, puede solicitar una modificaci&oacute;n a
                    trav&eacute;s de Oficio dirigido a Director(a) del <strong>&ldquo;SERVICIO&rdquo;</strong> para su
                    aprobaci&oacute;n, exponiendo los fundamentos pertinentes y respaldos hasta el <strong>30 de octubre del a&ntilde;o
                        2024</strong>. &nbsp;El Referente T&eacute;cnico del <strong>&ldquo;PROGRAMA&rdquo;</strong> del
                    <strong>&ldquo;SERVICIO&rdquo;</strong> es el encargado de ponderar esta solicitud, considerando que la
                    destinaci&oacute;n de estos recursos es solo para acciones atingentes al programa. Excepcionalmente y en la medida
                    que se reciban nuevos recursos se<span style='color:red;'>&nbsp;
                </p>
            </li>
        </ol>

        <p style='text-align: justify;'>&nbsp;</p>

        <p style='text-align: justify;'>
            <strong>2.- IMP&Uacute;TESE</strong> el gasto total de 
            <strong><span style='background:lime;'>$".$totalConvenio." (".$totalConvenioLetras.")&nbsp;</span></strong> 
            que irrogue la presente Resoluci&oacute;n de Continuidad del Convenio, correspondiente al Programa 
            <span style='background:lime;'>&ldquo;<strong>".$programa."</strong><strong>&rdquo; a&ntilde;o 2024</span></strong>, 
            entre el Servicio de Salud Tarapac&aacute; y la&nbsp;<span style='background:lime;'>".$ilustre." Municipalidad 
            de ".$comuna."</span> al &iacute;tem N&deg;24-03 298-002 correspondiente a 
            <strong>&ldquo;Reforzamiento Municipal del Presupuesto vigente del Servicio de Salud Tarapac&aacute; a&ntilde;o
            2024&rdquo;</strong>.
        </p>

        <p style='text-align: justify;'>&nbsp;</p>
    
        <p style='text-align: justify;'>
            <strong>3.-</strong> El convenio individualizado en la cl&aacute;usula primera de este instrumento se
            mantendr&aacute; plenamente vigente, subsistiendo todas sus cl&aacute;usulas, salvo en lo modificado por la presente
            Resoluci&oacute;n.
        </p>

        <p style='text-align: justify;'>&nbsp;</p>

        <p style='text-align: center;'>
            <strong>AN&Oacute;TESE, COMUN&Iacute;QUESE, ARCH&Iacute;VESE.&nbsp;</strong>
        </p>
        ";

        $types = Type::whereNull('partes_exclusive')->pluck('name','id');
        return view('documents.create', compact('document', 'types'));
    }

    public function formatDate($date)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        return date('j', strtotime($date)).' de '.$meses[date('n', strtotime($date))-1].' del año '.date('Y', strtotime($date));
    }

    public function correctAmountText($amount_text)
    {
        $amount_text = ucwords(mb_strtolower($amount_text));
        // verificamos si antes de cerrar en pesos la ultima palabra termina en Millón o Millones, de ser así se agregar "de" antes de cerrar con pesos
        $words_amount = explode(' ',trim($amount_text));
        return ($words_amount[count($words_amount) - 2] == 'Millon' || $words_amount[count($words_amount) - 2] == 'Millones') ? substr_replace($amount_text, 'de ', (strlen($amount_text) - 5), 0) : $amount_text;
    }
}
