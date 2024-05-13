<?php

namespace App\Http\Controllers\Agreements;

use App\Models\Agreements\Addendum;
use App\Models\Agreements\Signer;
use App\Models\Documents\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Documents\Signature;
use App\Models\Documents\SignaturesFile;
use App\Models\Documents\SignaturesFlow;
use App\Models\Documents\Type;
use App\Models\Parameters\Municipality;
use App\Rrhh\OrganizationalUnit;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Luecano\NumeroALetras\NumeroALetras;

class AddendumController extends Controller
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
        $addendum = new Addendum($request->all());
        $municipality = Municipality::where('name_representative', $request->representative)->first();
        if($municipality != null){ // es alcalde
            $addendum->representative = $municipality->name_representative;
            $addendum->representative_appellative = $municipality->appellative_representative;
            $addendum->representative_rut = $municipality->rut_representative;
            $addendum->representative_decree = $municipality->decree_representative;
        }
        $municipality = Municipality::where('name_representative_surrogate', $request->representative)->first();
        if($municipality != null){ // es alcalde subrogante
            $addendum->representative = $municipality->name_representative_surrogate;
            $addendum->representative_appellative = $municipality->appellative_representative_surrogate;
            $addendum->representative_rut = $municipality->rut_representative_surrogate;
            $addendum->representative_decree = $municipality->decree_representative_surrogate;
        }
        $addendum->save();

        session()->flash('info', 'El nuevo addendum ha sido creado.');

        return redirect()->back();
    }

    // METODO PARA ACTUALIZAR LA ETAPA DESDE LA TABLA DE SEGUIMIENTO DE CONVENIOS
    public function update(Request $request, Addendum $addendum)
    {
        // $attributes = $this->validate($request, $rules);
        // $addendum->update($attributes);

        // $validated = $request->validate([
        //     'title' => 'required|unique:posts|max:255',
        //     'body' => 'required',
        // ]);
        $addendum->update($request->All());
        $municipality = Municipality::where('name_representative', $request->representative)->first();
        if($municipality != null){ // es alcalde
            $addendum->representative = $municipality->name_representative;
            $addendum->representative_appellative = $municipality->appellative_representative;
            $addendum->representative_rut = $municipality->rut_representative;
            $addendum->representative_decree = $municipality->decree_representative;
        }
        $municipality = Municipality::where('name_representative_surrogate', $request->representative)->first();
        if($municipality != null){ // es alcalde subrogante
            $addendum->representative = $municipality->name_representative_surrogate;
            $addendum->representative_appellative = $municipality->appellative_representative_surrogate;
            $addendum->representative_rut = $municipality->rut_representative_surrogate;
            $addendum->representative_decree = $municipality->decree_representative_surrogate;
        }
        
        if($request->hasFile('file')){
            Storage::disk('gcs')->delete($addendum->file);
            $addendum->file = $request->file('file')->store('ionline/agreements/addendum', ['disk' => 'gcs']);
        }

        if($request->hasFile('res_file')){
            Storage::disk('gcs')->delete($addendum->res_file);
            $addendum->res_file = $request->file('res_file')->store('ionline/agreements/addendum_res', ['disk' => 'gcs']);
        }
        $addendum->save();

        session()->flash('info', 'El addendum #'.$addendum->id.' ha sido actualizado.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agreements\Addendum  $addendum
     * @return \Illuminate\Http\Response
     */
    public function show(Addendum $addendum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agreements\Addendum  $addendum
     * @return \Illuminate\Http\Response
     */
    public function edit(Addendum $addendum)
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
    public function destroy(Addendum $addendum)
    {
        //
    }

    public function download(Addendum $addendum)
    {
        return Storage::disk('gcs')->response($addendum->file, mb_convert_encoding($addendum->name,'ASCII'));
    }

    public function downloadRes(Addendum $addendum)
    {
        return Storage::disk('gcs')->response($addendum->res_file, mb_convert_encoding($addendum->name,'ASCII'));
    }

    public function preview(Addendum $addendum)
    {
        $filename = 'tmp_files/'.$addendum->file;
        if(!Storage::disk('public')->exists($filename))
            Storage::disk('public')->put($filename, Storage::disk('gcs')->get($addendum->file));
        return Redirect::away('https://view.officeapps.live.com/op/embed.aspx?src='.asset('storage/'.$filename));
    }

    public function sign(Addendum $addendum, $type)
    {
        if(!in_array($type, array('visators', 'signer'))) abort(404);

        $addendum->load('agreement.commune.municipality','agreement.program','referrer', 'director_signer.user');
        $municipio = (!Str::contains($addendum->agreement->commune->municipality->name_municipality, 'ALTO HOSPICIO') ? 'Ilustre ' : '').'Municipalidad de '.$addendum->agreement->commune->name;
        $first_word = explode(' ',trim($addendum->agreement->program->name))[0];
        $programa = $first_word == 'Programa' ? substr(strstr($addendum->agreement->program->name," "), 1) : $addendum->agreement->program->name;

        $signature = new Signature();
        $signature->request_date = $addendum->date;
        $signature->type_id = Type::where('name','Convenio')->first()->id;
        $signature->type = $type;
        $signature->addendum_id = $addendum->id;
        $signature->subject = 'Addendum Convenio programa '.$programa.' comuna de '.$addendum->agreement->commune->name;
        $signature->description = 'Documento addendum de convenio de ejecución del programa '.$programa.' año '.$addendum->agreement->period.' comuna de '.$addendum->agreement->commune->name;
        $signature->endorse_type = 'Visación en cadena de responsabilidad';
        $signature->recipients = 'sdga.ssi@redsalud.gov.cl,jurídica.ssi@redsalud.gov.cl,cxhenriquez@gmail.com,'.$addendum->referrer->email.',natalia.rivera.a@redsalud.gob.cl,apoyo.convenioaps@redsalud.gob.cl,pablo.morenor@redsalud.gob.cl,finanzas.ssi@redsalud.gov.cl,jaime.abarzua@redsalud.gov.cl,aps.ssi@redsalud.gob.cl';
        $signature->distribution = 'División de Atención Primaria MINSAL,Oficina de Partes SSI,'.$municipio;

        $signaturesFile = new SignaturesFile();
        $signaturesFile->file_type = 'documento';

        if($type == 'signer'){
            $signaturesFlow = new SignaturesFlow();
            $signaturesFlow->type = 'firmante';
            $signaturesFlow->ou_id = $addendum->director_signer->user->organizational_unit_id;
            $signaturesFlow->user_id = $addendum->director_signer->user->id;
            $signaturesFile->signaturesFlows->add($signaturesFlow);
        }

        if($type == 'visators'){
            //visadores por cadena de responsabilidad en orden parte primero por el referente tecnico
            // $visadores = collect([
            //                 ['ou_id' => 12, 'user_id' => 15005047] // DEPTO. ATENCION PRIMARIA DE SALUD - ANA MARIA MUJICA
            //                 ['ou_id' => 61, 'user_id' => 12834358], // DEPTO.ASESORIA JURIDICA  - LUIS MENA BUGUEÑO
            //                 ['ou_id' => 31, 'user_id' => 17432199], // DEPTO.GESTION FINANCIERA (40) - ROMINA GARÍN
            //                 ['ou_id' => 2, 'user_id' => 14104369], // SUBDIRECCION GESTION ASISTENCIAL - CARLOS CALVO
            //             ]);
            $visadores = collect([$addendum->referrer]); //referente tecnico
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

    public function createDocument(Addendum $addendum) 
    {
        /** Variables del addendum */
        $municipality   = Municipality::where('commune_id', $addendum->agreement->commune->id)->first();
        // // $addendum->director_signer = Signer::with('user')->find($request->signer_id);
        $totalConvenio = $addendum->agreement->agreement_amounts->sum('amount');
        $formatter = new NumeroALetras;
        $formatter->apocope = true;
        $totalConvenioLetras = $this->correctAmountText($formatter->toMoney($totalConvenio,0, 'pesos',''));
        $first_word = explode(' ',trim($addendum->agreement->program->name))[0];
        $programa = $first_word == 'Programa' ? substr(strstr($addendum->agreement->program->name," "), 1) : $addendum->agreement->program->name;
        if($addendum->agreement->period >= 2022) $programa = mb_strtoupper($programa);
        $ilustre = !Str::contains($municipality->name_municipality, 'ALTO HOSPICIO') ? 'ILUSTRE': null;
        $municipalidad = $municipality->name_municipality;
        $fechaAddendum = $this->formatDate($addendum->date);
        $fechaConvenio = $this->formatDate($addendum->agreement->date);
        $fechaResolucionConvenio = $this->formatDate($addendum->agreement->res_exempt_date);
        $directorApelativo = $addendum->director_signer->appellative;
        $directorRut = $addendum->director_signer->user->runFormat;
        if(!Str::contains($directorApelativo,'(S)')) $directorApelativo .= ' Titular';
        //construir nombre director
        $first_name = explode(' ',trim($addendum->director_signer->user->name))[0];
        $director = mb_strtoupper($addendum->director_signer->user->fullName);
        $directorNationality = Str::contains($addendum->director_signer->appellative, 'a') ? 'chilena' : 'chileno';

        $alcaldeNationality = Str::endsWith($addendum->representative_appellative, 'a') ? 'chilena' : 'chileno';
        $alcaldeApelativo = $addendum->representative_appellative;
        $alcaldeApelativoCorto = Str::beforeLast($alcaldeApelativo, ' ');
        if(Str::contains($alcaldeApelativo, 'Subrogante')){
            $alcaldeApelativoFirma = Str::before($alcaldeApelativo, 'Subrogante') . '(S)';
        }else{
            $alcaldeApelativoFirma = explode(' ',trim($alcaldeApelativo))[0]; // Alcalde(sa)
        }

        // dd($ilustre);

        $document = new Document();
        $document->type_id = Type::where('name','Convenio')->first()->id;
        $document->antecedent = 'Convenio Rex. '. $addendum->agreement->res_exempt_number . ' ' . $addendum->agreement->res_exempt_date;
        $document->subject = 'Adendum de convenio '.$programa.' comuna de '.$addendum->agreement->commune->name;
        $document->distribution = "\nvalentina.ortega@redsalud.gob.cl\naps.ssi@redsalud.gob.cl\nromina.garin@redsalud.gob.cl\njuridica.ssi@redsalud.gob.cl\no.partes2@redsalud.gob.cl\nblanca.galaz@redsalud.gob.cl";
        $document->content = '
            <p style="text-align: center;"><strong>ADDENDUM DE CONVENIO</strong></p>
            <p style="text-align: center;"><strong>&ldquo;PROGRAMA <span style="background-color: yellow;">${programaTitulo}</span> A&Ntilde;O <span style="background-color: yellow;">${periodoConvenio}</span>&rdquo;</strong></p>
            <p style="text-align: center;"><strong>ENTRE EL SERVICIO DE SALUD TARAPAC&Aacute; Y LA <span style="background-color: yellow;">${ilustreTitulo}</span> <span style="background-color: yellow;">${municipalidad}</span></strong></p>
            <p style="text-align: center;">&nbsp;</p>
            <p style="text-align: justify;">En Iquique a&nbsp;<strong><span style="background-color: yellow;">${fechaAddendum}</span></strong>, entre el SERVICIO DE SALUD TARAPAC&Aacute;, persona jur&iacute;dica de derecho p&uacute;blico, RUT. 61.606.100-3, con domicilio en calle An&iacute;bal Pinto N&ordm; 815 de la ciudad de Iquique, representado por su <strong><span style="background-color: yellow;">${directorApelativo}</span> <span style="background-color: yellow;">${director}</span></strong>, <span style="background-color: yellow;"><strong>${directorNationality}</strong></span>, C&eacute;dula Nacional de Identidad N&deg; <strong><span style="background-color: yellow;">${directorRut}</span></strong>, del mismo domicilio del servicio p&uacute;blico que representa, en adelante el &ldquo;SERVICIO&rdquo;, por una parte; y por la otra, la <span style="background-color: yellow;"><strong>${ilustreTitulo}</strong> <strong>${municipalidad}</strong></span>, persona jur&iacute;dica de derecho p&uacute;blico, RUT <span style="background-color: yellow;"><strong>${comunaRut}</strong></span>, representada por su <span style="background-color: yellow;"><strong>${alcaldeApelativo}</strong> <strong>${alcalde}</strong></span>, chileno, C&eacute;dula Nacional de Identidad N&deg; <span style="background-color: yellow;"><strong>${alcaldeRut}</strong></span> ambos domiciliados en <span style="background-color: yellow;"><strong>${municipalidadDirec}</strong></span> de la comuna de <span style="background-color: yellow;"><strong>${comuna}</strong></span>, en adelante la &ldquo;MUNICIPALIDAD&rdquo;, se ha acordado celebrar un adendum de convenio, que consta de las siguientes cl&aacute;usulas:</p>

            <p style="text-align: justify;"><strong><u>PRIMERA</u>:</strong> Con fecha <span style="background-color: yellow;"><strong>${fechaConvenio}</strong></span>, las partes comparecientes firmaron el &ldquo;CONVENIO DEL PROGRAMA <span style="background-color: yellow;"><strong>${programaTitulo}</strong></span> A&Ntilde;O <span style="background-color: yellow;"><strong>${periodoConvenio}</strong></span>&rdquo; entre el SERVICIO DE SALUD TARAPAC&Aacute; y la <span style="background-color: yellow;"><strong>${ilustreTitulo}</strong> <strong>${municipalidad}</strong></span> aprobado por Resoluci&oacute;n Exenta N&deg; <span style="background-color: yellow;"><strong>${numResolucionConvenio}</strong></span> del <span style="background-color: yellow;"><strong>${fechaResolucionConvenio}</strong></span> del Servicio de Salud de Tarapac&aacute;.</p>
            <p style="text-align: justify;"><strong><u>SEGUNDA</u></strong><strong>: </strong>Por este acto e instrumento las partes comparecientes, de com&uacute;n acuerdo, vienen en modificar las siguientes cl&aacute;usulas del convenio ya individualizado quedando del siguiente tenor:</p>
            <p style="text-align: justify; padding-left: 40px;"><strong>A)&nbsp;</strong><strong>DONDE DICE:</strong></p>
            <p style="text-align: justify; padding-left: 40px;"><strong>QUINTA:</strong> Conforme a lo se&ntilde;alado en las cl&aacute;usulas precedentes el Ministerio de Salud, a trav&eacute;s del <strong>&ldquo;SERVICIO&rdquo;</strong>, conviene en asignar a la <strong>&ldquo;MUNICIPALIDAD&rdquo;</strong>, desde la fecha de total tramitaci&oacute;n de la resoluci&oacute;n exenta que apruebe el presente instrumento y recibidos los recursos desde el Ministerio de Salud, la suma anual y &uacute;nica de <strong>$XXXXXXXXXXXX (PESOS) </strong>para alcanzar el prop&oacute;sito y cumplimiento de los componentes se&ntilde;alados en la cl&aacute;usula anterior.</p>
            <p class="MsoListParagraph" style="text-align: justify; padding-left: 40px;"><strong>B)&nbsp;</strong><strong>DEBE DECIR:</strong></p>
            <p style="text-align: justify; padding-left: 40px;"><strong>QUINTA:</strong> Conforme a lo se&ntilde;alado en las cl&aacute;usulas precedentes el Ministerio de Salud, a trav&eacute;s del <strong>&ldquo;SERVICIO&rdquo;</strong>, conviene en asignar a la <strong>&ldquo;MUNICIPALIDAD&rdquo;</strong>, desde la fecha de total tramitaci&oacute;n de la resoluci&oacute;n exenta que apruebe el presente instrumento y recibidos los recursos desde el Ministerio de Salud, la suma anual y &uacute;nica de <strong>$XXXXXXXXX (PESOS) </strong>para alcanzar el prop&oacute;sito y cumplimiento de los componentes se&ntilde;alados en la cl&aacute;usula anterior.</p>
            <p style="text-align: justify; padding-left: 40px;"><strong>A)&nbsp;</strong><strong>DONDE DICE:</strong></p>
            <p style="text-align: justify; padding-left: 40px;"><strong>SEXTA: </strong>La <strong>&ldquo;MUNICIPALIDAD&rdquo;</strong> est&aacute; obligada a cumplir las coberturas definidas en este convenio, as&iacute; como tambi&eacute;n se compromete a cumplir las acciones se&ntilde;aladas para las estrategias espec&iacute;ficas. Asimismo, est&aacute; obligada a implementar y otorgar las prestaciones que correspondan a la atenci&oacute;n primaria, se&ntilde;aladas en el <strong>&ldquo;PROGRAMA&rdquo;.</strong></p>
            <p style="text-align: justify; padding-left: 40px;">La <strong>&ldquo;MUNICIPALIDAD&rdquo;</strong>, est&aacute; obligada a utilizar los recursos obtenidos seg&uacute;n el siguiente detalle de objetivos y productos espec&iacute;ficos de cada componente, especificados en la cl&aacute;usula cuarta.</p>
            <div style="padding-left: 40px;">
            <table class="MsoTableGrid" style="border-collapse: collapse; width: 100%;" border="1">
            <tbody style="padding-left: 40px;">
            <tr>
            <td><span style="text-align: justify;">Componente </span></td>
            <td><span style="text-align: justify;">Objetivo</span></td>
            <td><span style="text-align: justify;">Estrategia</span></td>
            <td><span style="text-align: justify;">Monto</span></td>
            </tr>
            <tr>
            <td><span style="text-align: justify;">Componente 1</span></td>
            <td><span style="text-align: justify;">XXX</span></td>
            <td>XXX</td>
            <td>$ XXX.XXX</td>
            </tr>
            <tr>
            <td>Componente 2</td>
            <td><span style="text-align: justify;">XXX</span></td>
            <td><span style="text-align: justify;">XXX</span></td>
            <td>$ XXX.XXX</td>
            </tr>
            <tr>
            <td></td>
            <td><span style="text-align: justify;"></span></td>
            <td><span style="text-align: justify;"></span></td>
            <td></td>
            </tr>
            <tr>
            <td>Total</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>$ X.XXX.XXX</td>
            </tr>
            </tbody>
            </table>
            </div>
            <p style="text-align: justify; padding-left: 40px;">&nbsp;</p>
            <p style="text-align: justify; padding-left: 40px;">*toda contrataci&oacute;n o asignaci&oacute;n de estrategia deber&aacute; tener el Visto Bueno del Servicio de Salud, a trav&eacute;s de su referente, v&iacute;a correo electr&oacute;nico al REFERENTE.</p>
            <p style="text-align: justify; padding-left: 40px;">&ldquo;El <strong>&ldquo;SERVICIO</strong>&rdquo; determinar&aacute; la pertinencia de la compra de servicios o la adquisici&oacute;n de insumos, materiales, implementos o bienes por parte de la <strong>&ldquo;MUNICIPALIDAD&rdquo;</strong>, asegurando que sean acordes a las necesidades del <strong>&ldquo;PROGRAMA</strong>&rdquo; y de acuerdo a la normativa vigente, para estos efectos deber&aacute; enviar v&iacute;a correo electr&oacute;nico a la referente del programa la propuesta de compras, que deber&aacute; ser aprobada por el <strong>&ldquo;SERVICIO&rdquo;</strong>, previo a su adquisici&oacute;n. El &ldquo;<strong>SERVICIO</strong>&rdquo;, podr&aacute; determinar otros criterios de distribuci&oacute;n de los recursos destinados, atendiendo a criterios de equidad y acortamiento de brechas en el otorgamiento de las prestaciones.</p>
            <p style="text-align: justify; padding-left: 40px;"><strong>B) DEBE DECIR:</strong></p>
            <p style="text-align: justify; padding-left: 40px;"><strong>SEXTA: </strong>La <strong>&ldquo;MUNICIPALIDAD&rdquo;</strong> est&aacute; obligada a cumplir las coberturas definidas en este convenio, as&iacute; como tambi&eacute;n se compromete a cumplir las acciones se&ntilde;aladas para las estrategias espec&iacute;ficas. Asimismo, est&aacute; obligada a implementar y otorgar las prestaciones que correspondan a la atenci&oacute;n primaria, se&ntilde;aladas en el <strong>&ldquo;PROGRAMA&rdquo;.</strong></p>
            <p style="text-align: justify; padding-left: 40px;">La <strong>&ldquo;MUNICIPALIDAD&rdquo;</strong>, est&aacute; obligada a utilizar los recursos obtenidos seg&uacute;n el siguiente detalle de objetivos y productos espec&iacute;ficos de cada componente, especificados en la cl&aacute;usula cuarta.</p>
            <div style="padding-left: 40px;">
            <table class="MsoTableGrid" style="border-collapse: collapse; width: 100%;" border="1">
            <tbody style="padding-left: 40px;">
            <tr>
            <td><span style="text-align: justify;">Componente </span></td>
            <td><span style="text-align: justify;">Objetivo</span></td>
            <td><span style="text-align: justify;">Estrategia</span></td>
            <td><span style="text-align: justify;">Monto</span></td>
            </tr>
            <tr>
            <td><span style="text-align: justify;">Componente 1</span></td>
            <td><span style="text-align: justify;">XXXXXXXXXXX</span></td>
            <td><span style="text-align: justify;">XXXXXXXXXXXXXXXXXXX</span></td>
            <td>$XXXXXXXXXXXXXXXXXX</td>
            </tr>
            <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
            <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
            <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
            </tbody>
            </table>
            </div>
            <p style="text-align: justify; padding-left: 40px;">&nbsp;</p>
            <p style="text-align: justify; padding-left: 40px;">*toda contrataci&oacute;n o asignaci&oacute;n de estrategia deber&aacute; tener el Visto Bueno del Servicio de Salud, a trav&eacute;s de su referente, v&iacute;a correo electr&oacute;nico al, correo referente</p>
            <p style="text-align: justify; padding-left: 40px;">&ldquo;El <strong>&ldquo;SERVICIO</strong>&rdquo; determinar&aacute; la pertinencia de la compra de servicios o la adquisici&oacute;n de insumos, materiales, implementos o bienes por parte de la <strong>&ldquo;MUNICIPALIDAD&rdquo;</strong>, asegurando que sean acordes a las necesidades del <strong>&ldquo;PROGRAMA</strong>&rdquo; y de acuerdo a la normativa vigente, para estos efectos deber&aacute; enviar v&iacute;a correo electr&oacute;nico a la referente del programa la propuesta de compras, que deber&aacute; ser aprobada por el <strong>&ldquo;SERVICIO&rdquo;</strong>, previo a su adquisici&oacute;n. El &ldquo;<strong>SERVICIO</strong>&rdquo;, podr&aacute; determinar otros criterios de distribuci&oacute;n de los recursos destinados, atendiendo a criterios de equidad y acortamiento de brechas en el otorgamiento de las prestaciones.</p>
            <p style="text-align: justify;"><strong><u>TERCERA:</u></strong>&nbsp;La personer&iacute;a de <strong>D.</strong> <span style="background-color: yellow;"><strong>${director}</strong></span>, para representar al Servicio de Salud de Tarapac&aacute;, consta en el <span style="background-color: yellow;"><strong>${directorDecreto}</strong></span>. La representaci&oacute;n de <strong>D.</strong> <span style="background-color: yellow;"><strong>${alcalde}</strong></span> para actuar en nombre de la <span style="background-color: yellow;"><strong>${ilustreTitulo}</strong></span> Municipalidad de <span style="background-color: yellow;"><strong>${comuna}</strong></span>, emana del <strong><span style="background-color: yellow;">${alcaldeDecreto}</span></strong> de la <strong><span style="background-color: yellow;">${ilustreTitulo}</span></strong> Municipalidad de <span style="background-color: yellow;"><strong>${comuna}</strong></span>.</p>
            <p style="text-align: justify;"><strong><u>CUARTA:</u></strong> El presente adendum se firma digitalmente en un ejemplar, quedando este en poder del <strong>&ldquo;SERVICIO&rdquo;. </strong>Por su parte, la <strong>&ldquo;MUNICIPALIDAD&rdquo; </strong>contraparte de este convenio y la <strong>Divisi&oacute;n de Atenci&oacute;n Primaria de Ministerio de Salud</strong> e involucrados, recibir&aacute;n el documento original digitalizado.</p>
            <p style="text-align: justify;"><strong><u>QUINTA:</u></strong> El convenio individualizado en la cl&aacute;usula primera de este instrumento se mantendr&aacute; plenamente vigente, subsistiendo todas sus cl&aacute;usulas, salvo en lo modificado por el presente adendum.</p>
            <p style="text-align: justify;">&nbsp;</p>
            <p style="text-align: justify;">&nbsp;</p>
            <p style="text-align: justify;">&nbsp;</p>
            <p style="text-align: center;"><span style="background-color: yellow;"><strong>${alcalde}</strong></span></p>
            <p style="text-align: center;"><span style="background-color: yellow;"><strong>${alcaldeApelativoFirma}</strong></span></p>
            <p style="text-align: center;"><span style="background-color: yellow;"><strong>${ilustreTitulo} ${municipalidad}</strong></span></p>';



        // Buscar y reemplazar en $document->content las variables ${...} por los valores correspondientes
        $document->content = str_replace('${programaTitulo}', $programa, $document->content);
        $document->content = str_replace('${periodoConvenio}', $addendum->agreement->period, $document->content);
        $document->content = str_replace('${ilustreTitulo}', $ilustre, $document->content);
        $document->content = str_replace('${municipalidad}', $municipalidad, $document->content);
        $document->content = str_replace('${fechaAddendum}', $this->formatDate($addendum->date), $document->content);
        $document->content = str_replace('${directorApelativo}', $addendum->director_signer->appellative, $document->content);
        $document->content = str_replace('${director}', mb_strtoupper($addendum->director_signer->user->fullName), $document->content);
        $document->content = str_replace('${directorNationality}', Str::contains($addendum->director_signer->appellative, 'a') ? 'chilena' : 'chileno', $document->content);
        $document->content = str_replace('${directorRut}', $addendum->director_signer->user->runFormat, $document->content);
        $document->content = str_replace('${alcaldeApelativo}', $addendum->representative_appelative, $document->content);
        $document->content = str_replace('${alcalde}', $addendum->representative, $document->content);
        $document->content = str_replace('${alcaldeRut}', $addendum->representative_rut, $document->content);
        $document->content = str_replace('${alcaldeApelativoFirma}', $alcaldeApelativoFirma, $document->content);
        $document->content = str_replace('${comuna}', $addendum->agreement->commune->name, $document->content);
        $document->content = str_replace('${comunaRut}', $addendum->agreement->commune->rut, $document->content);
        $document->content = str_replace('${municipalidadDirec}', $municipality->address, $document->content);
        $document->content = str_replace('${fechaConvenio}', $this->formatDate($addendum->agreement->date), $document->content);
        $document->content = str_replace('${numResolucionConvenio}', $addendum->agreement->res_exempt_number, $document->content);
        $document->content = str_replace('${fechaResolucionConvenio}', $this->formatDate($addendum->agreement->res_exempt_date), $document->content);
        $document->content = str_replace('${directorDecreto}', $addendum->director_signer->decree, $document->content);
        $document->content = str_replace('${alcaldeDecreto}', $addendum->representative_decree, $document->content);


        $types = Type::whereNull('partes_exclusive')->pluck('name','id');
        return view('documents.create', compact('document', 'types'));
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
