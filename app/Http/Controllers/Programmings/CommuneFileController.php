<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Programmings\Programming;
use App\Models\Programmings\CommuneFile;
use App\Programmings\Review;
use App\Models\Commune;
use App\Establishment;
use App\User;

use Illuminate\Support\Facades\Storage;

class CommuneFileController extends Controller
{
    public function index()
    {
        
        $year = '';
        if(Auth()->user()->hasAllRoles('Programming: Review') == True || Auth()->user()->hasAllRoles('Programming: Admin') == True )
        {
        
        $communeFiles = CommuneFile::select(
                             'pro_commune_files.id'
                            ,'pro_commune_files.year'
                            ,'pro_commune_files.user_id'
                            ,'pro_commune_files.description'
                            ,'pro_commune_files.created_at'
                            ,'pro_commune_files.file_a'
                            ,'pro_commune_files.file_b'
                            ,'pro_commune_files.file_c'
                            ,'T2.name AS commune'
                            ,'T3.name' 
                            ,'T3.fathers_family'
                            ,'T3.mothers_family')
                ->leftjoin('communes AS T2', 'pro_commune_files.commune_id', '=', 'T2.id')
                ->leftjoin('users AS T3', 'pro_commune_files.user_id', '=', 'T3.id')
                ->Where('pro_commune_files.year','LIKE','%'.$year.'%')
                ->orderBy('T2.name','ASC')->get();
        }
        else {
            $communeFiles = CommuneFile::select(
                        'pro_commune_files.id'
                        ,'pro_commune_files.year'
                        ,'pro_commune_files.user_id'
                        ,'pro_commune_files.description'
                        ,'pro_commune_files.created_at'
                        ,'pro_commune_files.file_a'
                        ,'pro_commune_files.file_b'
                        ,'pro_commune_files.file_c'
                        ,'T2.name AS commune'
                        ,'T3.name' 
                        ,'T3.fathers_family'
                        ,'T3.mothers_family')
            ->leftjoin('communes AS T2', 'pro_commune_files.commune_id', '=', 'T2.id')
            ->leftjoin('users AS T3', 'pro_commune_files.user_id', '=', 'T3.id')
            ->Where('pro_commune_files.year','LIKE','%'.$year.'%')
            ->Where('pro_commune_files.access','LIKE','%'.Auth()->user()->id.'%')
            ->orderBy('T2.name','ASC')->get();
        }
        
        
        return view('programmings/communeFiles/index')->withCommuneFiles($communeFiles);
    }

    public function create() 
    {   
        $communes = Commune::get();
        $users = User::where('position', 'Funcionario Programación')->OrderBy('name')->get(); // Sólo Funcionario Programación
        return view('programmings/communeFiles/create')->withCommunes($communes)->withUsers($users);
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
             ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'RECEPCION DENTRO DEL PLAZO LEGAL','active'=> 'SI','user_id'=>  Auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'EL PLAN SE PRESENTA POR COMUNA','active'=> 'SI','user_id'=>  Auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'PRESENTA  DIAGNÓSTICO','active'=> 'SI','user_id'=>  Auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'DIAGNOSTICO PRESENTA estructura organizacional de los Centros de Salud de la comuna y de la unidad encargada de salud en la entidad administradora, sobre la base del plan de salud comunal y del modelo de atención definido por el Ministerio de Salud','active'=> 'SI','user_id'=>  Auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'DIAGNOSTICO PRESENTA DOTACIÓN DE PERSONAL (presentada por categorías y jornada laboral)','active'=> 'SI','user_id'=>  Auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'DIAGNOSTICO INCORPORA SITUACIÓN EPIDEMIOLÓGICA','active'=> 'SI','user_id'=>  Auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'PRESENTA APARTADO DE MATRIZ DE CUIDADOS','active'=> 'SI','user_id'=>  Auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'A LOS NODOS CRÍTICOS IDENTIFICADOS EN EL DIAGNÓSTICO SE LE  CREAN ESTRATEGIAS ABORDADAS  EN LA MATRIZ DE CUIDADOS ','active'=> 'SI','user_id'=>  Auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'PRESENTA APARTADO DE PROGRAMACIÓN NUMÉRICA','active'=> 'SI','user_id'=>  Auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'PROGRAMACIÓN NUMÉRICA EXISTE: PORGRAMACION DE HORAS DIRECTAS/ PROGRAMACION DE HORAS INDIRECTAS/PLA DE CAPACITACION ANUAL.','active'=> 'SI','user_id'=>  Auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REFERENTE DE GÉNERO','general_features'=> 'EL DIAGNOSTICO PRESENTA LAS CONSIDERACIONES DE GENÉRO ADECUADAS (Apoyo referente de temática)','active'=> 'SI','user_id'=>  Auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REFERENTE  PESPI e INTERCULTUALIDAD','general_features'=> 'EL DIAGNOSTICO PRESENTA ASPECTOS SUFICIENTES DE INTERCULTURALIDAD (Apoyo referente de temática)','active'=> 'SI','user_id'=>  Auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REFERENTE OIRS','general_features'=> 'EL DIAGNÓSTICO IDENTIFICA ANALISIS DE RECLAMOS DE LA COMUNIDAD ','active'=> 'SI','user_id'=>  Auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION REFERENTE RURAL (cuando corresponda)','general_features'=> 'DIAGNOSTICO INCORPORA Y ANALIZA LAS PROBLEMATICAS DE LOS POBALDOS RURALES ','active'=> 'SI','user_id'=>  Auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION REFERENTE RURAL (cuando corresponda)','general_features'=> 'MATRIZ DE CUIDADOS INTEGRA PROBLEMAS DIAGNOSTICADOS EN LOCALIDADES RURALES','active'=> 'SI','user_id'=>  Auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION REFERENTE RURAL (cuando corresponda)','general_features'=> 'EN PROGRAMACIÓN NUMÉRICA SE CONSIDERA TIEMPOS DE VIAJE A RONDAS','active'=> 'SI','user_id'=>  Auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION DE CAPACITACIÓN MUNICIPAL','general_features'=> 'EL DIAGNÓTICO PRESENTA LAS BRECHAS DE CAPACITACIÓN  Y SE ENCUENTRA SEPARADO Y PRIORIZADO POR LOS EJES ESTRATÉGICOS DE LA ENS','active'=> 'SI','user_id'=>  Auth()->user()->id,'commune_file_id'=>$communeFile->id]);
             $communeFile->programming_reviews()
             ->create(['revisor' => 'REVISION DE CAPACITACIÓN MUNICIPAL','general_features'=> 'LA PROGRAMACION NUMÉRICA SE ENCUENTRA COMPLETAMENTE LLENA DE ACUERDO A LAS ORIENTACIONES PARA PROGRAMACIÓN EN RED','active'=> 'SI','user_id'=>  Auth()->user()->id,'commune_file_id'=>$communeFile->id]);
 
             
           
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
        return view('programmings/communeFiles/show')->withCommuneFile($communeFile)->with('access_list', $access_list)->with('user', $user)->withCommunes($communes)->withUsers($users);
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
            $communeFile->file_a = $request->file('file_a')->store('programmings');
        }
        if($request->hasFile('file_b')){
            Storage::delete($communeFile->file_b);
            $communeFile->file_b = $request->file('file_b')->store('programmings');
        }
        if($request->hasFile('file_c')){
            Storage::delete($communeFile->file_c);
            $communeFile->file_c = $request->file('file_c')->store('programmings');
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
