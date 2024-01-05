<?php

namespace App\Http\Controllers\Agreements;

use App\Models\Agreements\Addendum;
use App\Models\Agreements\Signer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Agreements\ContinuityResolution;
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
            //                 ['ou_id' => 61, 'user_id' => 6811637], // DEPTO.ASESORIA JURIDICA  - CARMEN HENRIQUEZ OLIVARES
            //                 ['ou_id' => 31, 'user_id' => 17432199], // DEPTO.GESTION FINANCIERA (40) - ROMINA GARÍN
            //                 ['ou_id' => 2, 'user_id' => 14104369], // SUBDIRECCION GESTION ASISTENCIAL - CARLOS CALVO
            //             ]);
            $visadores = collect([$continuityResolution->referrer]); //referente tecnico
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
}
