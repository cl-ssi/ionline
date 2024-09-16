<?php

namespace App\Http\Controllers\Agreements;

use App\Http\Controllers\Controller;
use App\Models\Agreements\Addendum;
use App\Models\Agreements\Signer;
use App\Models\Documents\Document;
use App\Models\Documents\Signature;
use App\Models\Documents\SignaturesFile;
use App\Models\Documents\SignaturesFlow;
use App\Models\Documents\Template;
use App\Models\Documents\Type;
use App\Models\Parameters\Municipality;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
    public function create() {}

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $addendum = new Addendum($request->all());
        $municipality = Municipality::where('name_representative', $request->representative)->first();
        if ($municipality != null) { // es alcalde
            $addendum->representative = $municipality->name_representative;
            $addendum->representative_appellative = $municipality->appellative_representative;
            $addendum->representative_rut = $municipality->rut_representative;
            $addendum->representative_decree = $municipality->decree_representative;
        }
        $municipality = Municipality::where('name_representative_surrogate', $request->representative)->first();
        if ($municipality != null) { // es alcalde subrogante
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
        if ($municipality != null) { // es alcalde
            $addendum->representative = $municipality->name_representative;
            $addendum->representative_appellative = $municipality->appellative_representative;
            $addendum->representative_rut = $municipality->rut_representative;
            $addendum->representative_decree = $municipality->decree_representative;
        }
        $municipality = Municipality::where('name_representative_surrogate', $request->representative)->first();
        if ($municipality != null) { // es alcalde subrogante
            $addendum->representative = $municipality->name_representative_surrogate;
            $addendum->representative_appellative = $municipality->appellative_representative_surrogate;
            $addendum->representative_rut = $municipality->rut_representative_surrogate;
            $addendum->representative_decree = $municipality->decree_representative_surrogate;
        }

        if ($request->hasFile('file')) {
            Storage::disk('gcs')->delete($addendum->file);
            $addendum->file = $request->file('file')->store('ionline/agreements/addendum', ['disk' => 'gcs']);
        }

        if ($request->hasFile('res_file')) {
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
     * @return \Illuminate\Http\Response
     */
    public function show(Addendum $addendum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
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
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Addendum $addendum)
    {
        //
    }

    public function download(Addendum $addendum)
    {
        return Storage::disk('gcs')->response($addendum->file, mb_convert_encoding($addendum->name, 'ASCII'));
    }

    public function downloadRes(Addendum $addendum)
    {
        return Storage::disk('gcs')->response($addendum->res_file, mb_convert_encoding($addendum->name, 'ASCII'));
    }

    public function preview(Addendum $addendum)
    {
        $filename = 'tmp_files/'.$addendum->file;
        if (! Storage::disk('public')->exists($filename)) {
            Storage::disk('public')->put($filename, Storage::disk('gcs')->get($addendum->file));
        }

        return Redirect::away('https://view.officeapps.live.com/op/embed.aspx?src='.asset('storage/'.$filename));
    }

    public function sign(Addendum $addendum, $type)
    {
        if (! in_array($type, ['visators', 'signer'])) {
            abort(404);
        }

        $addendum->load('agreement.commune.municipality', 'agreement.program', 'referrer', 'director_signer.user');
        $municipio = (! Str::contains($addendum->agreement->commune->municipality->name_municipality, 'ALTO HOSPICIO') ? 'Ilustre ' : '').'Municipalidad de '.$addendum->agreement->commune->name;
        $first_word = explode(' ', trim($addendum->agreement->program->name))[0];
        $programa = $first_word == 'Programa' ? substr(strstr($addendum->agreement->program->name, ' '), 1) : $addendum->agreement->program->name;

        $signature = new Signature;
        $signature->request_date = $addendum->date;
        $signature->type_id = Type::where('name', 'Convenio')->first()->id;
        $signature->type = $type;
        $signature->addendum_id = $addendum->id;
        $signature->subject = 'Addendum Convenio programa '.$programa.' comuna de '.$addendum->agreement->commune->name;
        $signature->description = 'Documento addendum de convenio de ejecución del programa '.$programa.' año '.$addendum->agreement->period.' comuna de '.$addendum->agreement->commune->name;
        $signature->endorse_type = 'Visación en cadena de responsabilidad';
        $signature->recipients = ''; // 'sdga.ssi@redsalud.gov.cl,jurídica.ssi@redsalud.gov.cl,cxhenriquez@gmail.com,'.$addendum->referrer->email.',natalia.rivera.a@redsalud.gob.cl,apoyo.convenioaps@redsalud.gob.cl,pablo.morenor@redsalud.gob.cl,finanzas.ssi@redsalud.gov.cl,jaime.abarzua@redsalud.gov.cl,aps.ssi@redsalud.gob.cl';
        $signature->distribution = 'blanca.galaz@redsalud.gob.cl' ;//'División de Atención Primaria MINSAL,Oficina de Partes SSI,'.$municipio;

        $signaturesFile = new SignaturesFile;
        $signaturesFile->file_type = 'documento';

        if ($type == 'signer') {
            $signaturesFlow = new SignaturesFlow;
            $signaturesFlow->type = 'firmante';
            $signaturesFlow->ou_id = $addendum->director_signer->user->organizational_unit_id;
            $signaturesFlow->user_id = $addendum->director_signer->user->id;            
            $signaturesFile->signaturesFlows->add($signaturesFlow);
        }

        if ($type == 'visators') {
            //visadores por cadena de responsabilidad en orden parte primero por el referente tecnico
            // $visadores = collect([
            //                 ['ou_id' => 61, 'user_id' => 6811637], // DEPTO.ASESORIA JURIDICA  - Cármen Henriquez
            //                 ['ou_id' => 61, 'user_id' => 17289587], // JEFE APS  - Valentina Ortiga
            //                 ['ou_id' => 2, 'user_id' => 14104369], // SUBDIRECCION GESTION ASISTENCIAL - CARLOS CALVO
            //                 ['ou_id' => 31, 'user_id' => 17432199], // DEPTO.GESTION FINANCIERA (40) - ROMINA GARÍN
            //             ]);
            $visadores = collect([$addendum->referrer]); //referente tecnico
            foreach ([6811637, 17289587, 14104369, 17432199] as $user_id) { //resto de visadores por cadena de responsabilidad
                $visadores->add(User::find($user_id));
            }

            foreach ($visadores as $key => $visador) {
                $signaturesFlow = new SignaturesFlow;
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
        $document = new Document;
        $document->addendum_id = $addendum->id;
        $document->type_id = Type::where('name', 'Convenio')->first()->id;
        $document->antecedent = 'Convenio Rex. '.$addendum->agreement->res_exempt_number.' del '.$addendum->agreement->res_exempt_date;
        $document->subject = 'Adendum de convenio '.$addendum->agreement->program->name.' comuna de '.$addendum->agreement->commune->name;
        $document->distribution = "\nvalentina.ortega@redsalud.gob.cl\naps.ssi@redsalud.gob.cl\nromina.garin@redsalud.gob.cl\njuridica.ssi@redsalud.gob.cl\no.partes2@redsalud.gob.cl\nblanca.galaz@redsalud.gob.cl";
        $document->content = '
            <p style="text-align: center;"><strong>ADDENDUM DE CONVENIO</strong></p>
            <p style="text-align: center;"><strong>&ldquo;PROGRAMA <span style="background-color: yellow;">${programaTitulo}</span> A&Ntilde;O <span style="background-color: yellow;">${periodoConvenio}</span>&rdquo;</strong></p>
            <p style="text-align: center;"><strong>ENTRE EL SERVICIO DE SALUD TARAPAC&Aacute; Y LA <span style="background-color: yellow;">${ilustreTitulo}</span> <span style="background-color: yellow;">${municipalidad}</span></strong></p>
            <p style="text-align: center;">&nbsp;</p>

            <p style="text-align: justify;">En Iquique a&nbsp;<strong><span style="background-color: yellow;">${fechaAddendum}</span></strong>, entre el SERVICIO DE SALUD TARAPAC&Aacute;, persona jur&iacute;dica de derecho p&uacute;blico, RUT 61.606.100-3, con domicilio en calle An&iacute;bal Pinto N&ordm; 815 de la ciudad de Iquique, representado por su <strong><span style="background-color: yellow;">${directorApelativo}</span> <span style="background-color: yellow;">${director}</span></strong>, <span style="background-color: yellow;"><strong>${directorNationality}</strong></span>, C&eacute;dula Nacional de Identidad N&deg; <strong><span style="background-color: yellow;">${directorRut}</span></strong>, del mismo domicilio del servicio p&uacute;blico que representa, en adelante el &ldquo;SERVICIO&rdquo;, por una parte; y por la otra, la <span style="background-color: yellow;"><strong>${ilustreTitulo}</strong> <strong>${municipalidad}</strong></span>, persona jur&iacute;dica de derecho p&uacute;blico, RUT <span style="background-color: yellow;"><strong>${comunaRut}</strong></span>, representada por su <span style="background-color: yellow;"><strong>${alcaldeApelativo}</strong> <strong>${alcalde}</strong></span>, ${alcaldeNationality}, C&eacute;dula Nacional de Identidad N&deg; <span style="background-color: yellow;"><strong>${alcaldeRut}</strong></span> ambos domiciliados en <span style="background-color: yellow;"><strong>${municipalidadDirec}</strong></span> de la comuna de <span style="background-color: yellow;"><strong>${comuna}</strong></span>, en adelante la &ldquo;MUNICIPALIDAD&rdquo;, se ha acordado celebrar un adendum de convenio, que consta de las siguientes cl&aacute;usulas:</p>

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
            <td style="text-align: right;"><span style="text-align: justify;">Monto</span></td>
            </tr>
            <tr>
            <td><span style="text-align: justify;">Componente 1</span></td>
            <td><span style="text-align: justify;">XXX</span></td>
            <td>XXX</td>
            <td style="text-align: right;">$ XXX.XXX</td>
            </tr>
            <tr>
            <td>Componente 2</td>
            <td><span style="text-align: justify;">XXX</span></td>
            <td><span style="text-align: justify;">XXX</span></td>
            <td style="text-align: right;">$ XXX.XXX</td>
            </tr>
            <tr>
            <td></td>
            <td><span style="text-align: justify;"></span></td>
            <td><span style="text-align: justify;"></span></td>
            <td style="text-align: right;"></td>
            </tr>
            <tr>
            <td>Total</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: right;">$ X.XXX.XXX</td>
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
            <td style="text-align: right;">Monto</td>
            </tr>
            <tr>
            <td><span style="text-align: justify;">Componente 1</span></td>
            <td><span style="text-align: justify;">XXXXXXXXXXX</span></td>
            <td><span style="text-align: justify;">XXXXXXXXXXXXXXXXXXX</span></td>
            <td style="text-align: right;">$ XXX.XXX.XXX</td>
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
        $document->content = str_replace('${programaTitulo}', mb_strtoupper(preg_replace('/^Programa /', '', trim($addendum->agreement->program->name))), $document->content);
        $document->content = str_replace('${fechaAddendum}', $addendum->date->day.' de '.$addendum->date->monthName.' de '.$addendum->date->year, $document->content);
        $document->content = str_replace('${fechaConvenio}', $addendum->agreement->date->day.' de '.$addendum->agreement->date->monthName.' de '.$addendum->agreement->date->year, $document->content);
        $document->content = str_replace('${fechaResolucionConvenio}', $addendum->agreement->res_exempt_date->day.' de '.$addendum->agreement->res_exempt_date->monthName.' de '.$addendum->agreement->res_exempt_date->year, $document->content);
        $document->content = str_replace('${periodoConvenio}', $addendum->agreement->period, $document->content);
        $document->content = str_replace('${numResolucionConvenio}', $addendum->agreement->res_exempt_number, $document->content);
        $document->content = str_replace('${director}', mb_strtoupper($addendum->director_signer->user->fullName), $document->content);
        $document->content = str_replace('${directorRut}', $addendum->director_signer->user->runFormat, $document->content);
        $document->content = str_replace('${directorApelativo}', $addendum->director_signer->appellative, $document->content);
        $document->content = str_replace('${directorNationality}', Str::contains($addendum->director_signer->appellative, 'a') ? 'chilena' : 'chileno', $document->content);
        $document->content = str_replace('${directorDecreto}', $addendum->director_signer->decree, $document->content);
        $document->content = str_replace('${ilustreTitulo}', ! Str::contains($addendum->agreement->commune->municipality->name_municipality, 'ALTO HOSPICIO') ? 'ILUSTRE' : null, $document->content);
        $document->content = str_replace('${municipalidad}', $addendum->agreement->commune->municipality->name_municipality, $document->content);
        $document->content = str_replace('${alcalde}', $addendum->representative, $document->content);
        $document->content = str_replace('${alcaldeRut}', $addendum->representative_rut, $document->content);
        $document->content = str_replace('${alcaldeDecreto}', $addendum->representative_decree, $document->content);
        $document->content = str_replace('${alcaldeNationality}', Str::endsWith($addendum->representative_appellative, 'a') ? 'chilena' : 'chileno', $document->content);
        $document->content = str_replace('${alcaldeApelativo}', $addendum->representative_appellative, $document->content);
        $document->content = str_replace('${alcaldeApelativoFirma}', Str::beforeLast($addendum->representative_appellative, ' ').(Str::contains($addendum->representative_appellative, 'Subrogante') ? '(S)' : ''), $document->content);
        $document->content = str_replace('${municipalidadDirec}', $addendum->agreement->commune->municipality->address, $document->content);
        $document->content = str_replace('${comuna}', $addendum->agreement->commune->name, $document->content);
        $document->content = str_replace('${comunaRut}', $addendum->agreement->commune->municipality->rut_municipality, $document->content);

        $types = Type::whereNull('partes_exclusive')->pluck('name', 'id');

        return view('documents.create', compact('document', 'types'));
    }

    public function createResolution(Addendum $addendum)
    {
        /** Variables a reemplazar */
        $data['directorDecreto'] = $addendum->director_signer->decree;
        $data['numResolucion'] = $addendum->agreement->number;
        $data['yearResolucion'] = $addendum->agreement->resolution_date != null ? date('Y', strtotime($addendum->agreement->resolution_date)) : '';
        $data['programa'] = mb_strtoupper(preg_replace('/^Programa /', '', trim($addendum->agreement->program->name)));
        $data['periodoConvenio'] = $addendum->agreement->period;
        $data['numResourceResolucion'] = $addendum->agreement->res_resource_number;
        $data['yearResourceResolucion'] = $addendum->agreement->res_resource_date != null ? date('Y', strtotime($addendum->agreement->res_resource_date)) : '';
        $data['fechaResolucion'] = $addendum->res_date->day.' de '.$addendum->res_date->monthName.' de '.$addendum->res_date->year;
        $data['fechaResourceResolucion'] = $addendum->agreement->res_resource_date != null ? date('d', strtotime($addendum->agreement->res_resource_date)).' de '.date('F', strtotime($addendum->agreement->res_resource_date)).' de '.date('Y', strtotime($addendum->agreement->res_resource_date)) : '';
        $data['numResolucionConvenio'] = $addendum->agreement->res_exempt_number;
        $data['fechaResolucionConvenio'] = $addendum->agreement->res_exempt_date->day.' de '.$addendum->agreement->res_exempt_date->monthName.' de '.$addendum->agreement->res_exempt_date->year;
        $data['fechaConvenio'] = $addendum->agreement->date->day.' de '.$addendum->agreement->date->monthName.' de '.$addendum->agreement->date->year;
        $data['ilustre'] = $addendum->agreement->commune->municipality->name_municipality;
        $data['comuna'] = $addendum->agreement->commune->name;
        $data['fechaAddendum'] = $addendum->date->day.' de '.$addendum->date->monthName.' de '.$addendum->date->year;
        $data['directorApelativo'] = $addendum->director_signer->appellative;
        $data['director'] = $addendum->director_signer->user->fullName;
        $data['alcaldeApelativoCorto'] = Str::beforeLast($addendum->representative_appellative, ' ').(Str::contains($addendum->representative_appellative, 'Subrogante') ? '(S)' : '');
        $data['alcalde'] = $addendum->representative;
        $data['comuna'] = $addendum->agreement->commune->name;

        // Importar los templates
        $header = Template::where('key', 'agreements.addendum.resolution.header.2024')->first()->toArray();
        $footer = Template::where('key', 'agreements.addendum.resolution.footer.2024')->first()->toArray();

        // Importar el contenido del adendum y eliminar las útlimas 4 líneas del contenido
        $addendum_content = implode("\n", array_slice(explode("\n", $addendum->document->content), 0, -4));

        $document = new Document;
        $document->type_id = Type::where('name', 'Resolución')->first()->id;
        $document->antecedent = 'Convenio Rex. '.$addendum->agreement->res_exempt_number.' del '.$addendum->agreement->res_exempt_date;
        $document->subject = 'Resolución de adendum de convenio '.$addendum->agreement->program->name.' comuna de '.$addendum->agreement->commune->name;
        $document->distribution = 'APS';

        $templateContent = $header['content'].$addendum_content.$footer['content'];
        $document->content = Document::parseTemplate($templateContent, $data);

        $types = Type::whereNull('partes_exclusive')->pluck('name', 'id');

        return view('documents.create', compact('document', 'types'));
    }
}
