<?php

namespace App\Http\Controllers\Agreements;

use App\Models\Agreements\Addendum;
use App\Models\Agreements\Signer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Documents\Signature;
use App\Models\Documents\SignaturesFile;
use App\Models\Documents\SignaturesFlow;
use App\Models\Documents\Type;
use App\Models\Parameters\Municipality;
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
            //                 ['ou_id' => 61, 'user_id' => 6811637], // DEPTO.ASESORIA JURIDICA  - CARMEN HENRIQUEZ OLIVARES
            //                 ['ou_id' => 31, 'user_id' => 17432199], // DEPTO.GESTION FINANCIERA (40) - ROMINA GARÍN
            //                 ['ou_id' => 2, 'user_id' => 14104369], // SUBDIRECCION GESTION ASISTENCIAL - CARLOS CALVO
            //             ]);
            $visadores = collect([$addendum->referrer]); //referente tecnico
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
