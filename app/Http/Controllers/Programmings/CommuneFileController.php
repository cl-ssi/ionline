<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Programmings\CommuneFile;
use App\Models\Commune;
use App\Models\Programmings\Programming;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CommuneFileController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->year ?? Carbon::now()->year + 1;
        $accessByCommune = null;
        if( auth()->user()->cannot('Reviews: edit') ){
            $last_year = Programming::latest()->first()->year;
            $accessByCommune = collect();
            $last_programmings = Programming::with('establishment')->where('year', $last_year)->get();
            //El usuario tiene acceso por comuna(s)?
            foreach($last_programmings as $programming){
                if(Str::contains($programming->access, auth()->user()->id)){
                    $accessByCommune->push($programming->establishment->commune_id);
                }
            }
        }

        $communeFiles = CommuneFile::with('commune', 'user')->where('year', $year)->where('status', 'active')
            ->when($accessByCommune != null, function($q) use($accessByCommune){
                $q->whereIn('commune_id', $accessByCommune);
            })
            ->get();
        
        foreach($communeFiles as $communeFile){
            $communeFile->programming_status = Programming::where('year', $year)->whereHas('establishment.commune', function($q) use ($communeFile){
                return $q->where('id', $communeFile->commune_id);
            })->first()->status;
        }

        return view('programmings.communeFiles.index', compact('communeFiles', 'request', 'year'));
    }

    public function create() 
    {   
        $communes = Commune::get();
        $users = User::where('position', 'Funcionario Programación')->OrderBy('name')->get(); // Sólo Funcionario Programación
        return view('programmings.communeFiles.create', compact('communes', 'users'));
    }

    public function store(Request $request)
    {
        // SI ES ALTO HOSPICIO, PERMITE MÁS REGISTROS PARA HECTOR REYNO
        if($request->commune == 7)
        {
            $communeFileValid = null;
        }
        else {

            $communeFileValid = CommuneFile::where('commune_id', $request->commune)
            ->where('year', $request->date)
            ->first();
        }

        if($communeFileValid){
            session()->flash('warning', 'Ya se ha iniciado el registro adjunto para esta comuna el año ingresado');
        }
        else {
            $communeFile  = new CommuneFile($request->All());
            $communeFile->year = $request->date;
            $communeFile->description = $request->description;
            $communeFile->commune_id = $request->commune;
            $communeFile->user_id  = $request->user;
            $communeFile->access   = serialize($request->access);
        
            $communeFile->save();

            //dd($communeFile->id);

             //INSERT EVALUACION
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'RECEPCION DENTRO DEL PLAZO LEGAL','active'=> 'SI','user_id'=>  auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'EL PLAN SE PRESENTA POR COMUNA','active'=> 'SI','user_id'=>  auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'PRESENTA  DIAGNÓSTICO','active'=> 'SI','user_id'=>  auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'DIAGNOSTICO PRESENTA estructura organizacional de los Centros de Salud de la comuna y de la unidad encargada de salud en la entidad administradora, sobre la base del plan de salud comunal y del modelo de atención definido por el Ministerio de Salud','active'=> 'SI','user_id'=>  auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'DIAGNOSTICO PRESENTA DOTACIÓN DE PERSONAL (presentada por categorías y jornada laboral)','active'=> 'SI','user_id'=>  auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'DIAGNOSTICO INCORPORA SITUACIÓN EPIDEMIOLÓGICA','active'=> 'SI','user_id'=>  auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'PRESENTA APARTADO DE MATRIZ DE CUIDADOS','active'=> 'SI','user_id'=>  auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'A LOS NODOS CRÍTICOS IDENTIFICADOS EN EL DIAGNÓSTICO SE LE  CREAN ESTRATEGIAS ABORDADAS  EN LA MATRIZ DE CUIDADOS ','active'=> 'SI','user_id'=>  auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'PRESENTA APARTADO DE PROGRAMACIÓN NUMÉRICA','active'=> 'SI','user_id'=>  auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'PROGRAMACIÓN NUMÉRICA EXISTE: PORGRAMACION DE HORAS DIRECTAS/ PROGRAMACION DE HORAS INDIRECTAS/PLA DE CAPACITACION ANUAL.','active'=> 'SI','user_id'=>  auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REFERENTE DE GÉNERO','general_features'=> 'EL DIAGNOSTICO PRESENTA LAS CONSIDERACIONES DE GENÉRO ADECUADAS (Apoyo referente de temática)','active'=> 'SI','user_id'=>  auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REFERENTE  PESPI e INTERCULTUALIDAD','general_features'=> 'EL DIAGNOSTICO PRESENTA ASPECTOS SUFICIENTES DE INTERCULTURALIDAD (Apoyo referente de temática)','active'=> 'SI','user_id'=>  auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REFERENTE OIRS','general_features'=> 'EL DIAGNÓSTICO IDENTIFICA ANALISIS DE RECLAMOS DE LA COMUNIDAD ','active'=> 'SI','user_id'=>  auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION REFERENTE RURAL (cuando corresponda)','general_features'=> 'DIAGNOSTICO INCORPORA Y ANALIZA LAS PROBLEMATICAS DE LOS POBALDOS RURALES ','active'=> 'SI','user_id'=>  auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION REFERENTE RURAL (cuando corresponda)','general_features'=> 'MATRIZ DE CUIDADOS INTEGRA PROBLEMAS DIAGNOSTICADOS EN LOCALIDADES RURALES','active'=> 'SI','user_id'=>  auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION REFERENTE RURAL (cuando corresponda)','general_features'=> 'EN PROGRAMACIÓN NUMÉRICA SE CONSIDERA TIEMPOS DE VIAJE A RONDAS','active'=> 'SI','user_id'=>  auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION DE CAPACITACIÓN MUNICIPAL','general_features'=> 'EL DIAGNÓTICO PRESENTA LAS BRECHAS DE CAPACITACIÓN  Y SE ENCUENTRA SEPARADO Y PRIORIZADO POR LOS EJES ESTRATÉGICOS DE LA ENS','active'=> 'SI','user_id'=>  auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION DE CAPACITACIÓN MUNICIPAL','general_features'=> 'LA PROGRAMACION NUMÉRICA SE ENCUENTRA COMPLETAMENTE LLENA DE ACUERDO A LAS ORIENTACIONES PARA PROGRAMACIÓN EN RED','active'=> 'SI','user_id'=>  auth()->user()->id,'commune_file_id'=>$communeFile->id]);
 
             
           
            session()->flash('info', 'Se ha iniciado una nueva registro adjunto');
        }

        return redirect()->back();
    }

    public function show(CommuneFile $communeFiles, $id)
    {
        $communeFile = CommuneFile::with('commune')->find($id);
        //dd($comFile);
        $communes = Commune::get();
        $users = User::with('organizationalUnit')->where('position', 'Funcionario Programación')->OrderBy('name')->get(); // Sólo Funcionario Programación
        $access_list = unserialize($communeFile->access);
        $user = $communeFile->user;
        return view('programmings.communeFiles.show')->withCommuneFile($communeFile)->with('access_list', $access_list)->with('user', $user)->withCommunes($communes)->withUsers($users);
    }

    public function update(Request $request,$id)
    {
       // DD($request);

        $communeFile = CommuneFile::find($id);

        $communeFile->fill($request->all());
        if($request->description){
            $communeFile->description = $request->description;
        }
        if($request->date){
            $communeFile->year = $request->date;
        }
        if($request->user){
            $communeFile->user_id  = $request->user;
        }
        if($request->access){
            $communeFile->access   = serialize($request->access);
        }

        if($request->hasFile('file_a')){
            Storage::delete($communeFile->file_a);
            $communeFile->file_a = $request->file('file_a')->store('ionline/programmings', ['disk', 'gcs']);
        }
        if($request->hasFile('file_b')){
            Storage::delete($communeFile->file_b);
            $communeFile->file_b = $request->file('file_b')->store('ionline/programmings', ['disk', 'gcs']);
        }
        if($request->hasFile('file_c')){
            Storage::delete($communeFile->file_c);
            $communeFile->file_c = $request->file('file_c')->store('ionline/programmings', ['disk', 'gcs']);
        }
        
        $communeFile->save();

        return redirect()->back();
    }

    public function download(CommuneFile $file)
    {
        return Storage::response($file->file_a, mb_convert_encoding($file->name,'ASCII'));
    }
    public function downloadFileB(CommuneFile $file)
    {
        return Storage::response($file->file_b, mb_convert_encoding($file->name,'ASCII'));
    }

    public function downloadFileC(CommuneFile $file)
    {
        return Storage::response($file->file_c, mb_convert_encoding($file->name,'ASCII'));
    }

}
