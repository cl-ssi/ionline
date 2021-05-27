<?php

namespace App\Http\Controllers\Agreements;

use App\Agreements\Addendum;
use App\Agreements\Signer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Documents\Signature;
use App\Models\Documents\SignaturesFile;
use App\Models\Documents\SignaturesFlow;
use App\Municipality;
use App\Rrhh\OrganizationalUnit;
use App\User;
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
        $addendum = new Addendum();
        $addendum->agreement_id = $request->agreement_id;
        $addendum->date = $request->date;
        $addendum->referrer_id = $request->referrer_id;
        $signer = Signer::findOrFail($request->signer_id);
        $addendum->director_id = $signer->user_id;
        $addendum->director_appellative = $signer->appellative;
        $addendum->director_decree = $signer->decree;
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
        $signer = Signer::findOrFail($request->signer_id);
        $addendum->director_id = $signer->user_id;
        $addendum->director_appellative = $signer->appellative;
        $addendum->director_decree = $signer->decree;
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
        
        if($request->hasFile('file')){
            Storage::delete($addendum->file);
            $addendum->file = $request->file('file')->store('resolutions');
            $addendum->save();
        }

        if($request->hasFile('res_file')){
            Storage::delete($addendum->res_file);
            $addendum->res_file = $request->file('file_res')->store('resolutions');
            $addendum->save();
        }

        session()->flash('info', 'El addendum #'.$addendum->id.' ha sido actualizado.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Agreements\Addendum  $addendum
     * @return \Illuminate\Http\Response
     */
    public function show(Addendum $addendum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agreements\Addendum  $addendum
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
     * @param  \App\Agreements\Addendum  $addendum
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agreements\Addendum  $addendum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Addendum $addendum)
    {
        //
    }

    public function downloadRes(Addendum $addendum)
    {
        return Storage::response($addendum->res_file, mb_convert_encoding($addendum->name,'ASCII'));
    }

    public function preview(Addendum $addendum)
    {
        $filename = 'tmp_files/'.$addendum->file;
        if(!Storage::disk('public')->exists($filename))
            Storage::disk('public')->put($filename, Storage::disk('local')->get($addendum->file));
        return Redirect::away('https://view.officeapps.live.com/op/embed.aspx?src='.asset('storage/'.$filename));
    }

    public function sign(Addendum $addendum, $type)
    {
        if(!in_array($type, array('visators', 'signer'))) abort(404);

        $addendum->load('agreement.commune.municipality','agreement.program','referrer', 'director');
        $municipio = (!Str::contains($addendum->agreement->commune->municipality->name_municipality, 'ALTO HOSPICIO') ? 'Ilustre ' : '').'Municipalidad de '.$addendum->agreement->commune->name;
        $first_word = explode(' ',trim($addendum->agreement->program->name))[0];
        $programa = $first_word == 'Programa' ? substr(strstr($addendum->agreement->program->name," "), 1) : $addendum->agreement->program->name;

        $signature = new Signature();
        $signature->request_date = $addendum->date;
        $signature->document_type = 'Convenios';
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
            $signaturesFlow->ou_id = $addendum->director->organizational_unit_id;
            $signaturesFlow->user_id = $addendum->director_id;
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
            $visadores = collect([$addendum->referrer]); //referente tecnico
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
