<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Programmings\Programming;
use App\Establishment;
use App\Models\Commune;
use App\Models\Programmings\Review AS Rev;
use App\Programmings\Review;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class ProgrammingController extends Controller
{
    public function index()
    {
        
        $year = '';
        if(Auth()->user()->id == '15683706' || Auth()->user()->id == '12345678' || Auth()->user()->id == '13641014' || Auth()->user()->id == '17011541' || Auth()->user()->id == '15287582')
        {
        
        $programmings = Programming::select(
                             'pro_programmings.id'
                            ,'pro_programmings.year'
                            ,'pro_programmings.user_id'
                            ,'pro_programmings.description'
                            ,'pro_programmings.created_at'
                            ,'T1.type AS establishment_type'
                            ,'T1.name AS establishment'
                            ,'T2.name AS commune'
                            ,'T3.name' 
                            ,'T3.fathers_family'
                            ,'T3.mothers_family')
                ->leftjoin('establishments AS T1', 'pro_programmings.establishment_id', '=', 'T1.id')
                ->leftjoin('communes AS T2', 'T1.commune_id', '=', 'T2.id')
                ->leftjoin('users AS T3', 'pro_programmings.user_id', '=', 'T3.id')
                ->Where('pro_programmings.year','LIKE','%'.$year.'%')
                ->orderBy('T2.name','ASC')->get();
        }
        else {
            $programmings = Programming::select(
                        'pro_programmings.id'
                        ,'pro_programmings.year'
                        ,'pro_programmings.user_id'
                        ,'pro_programmings.description'
                        ,'pro_programmings.created_at'
                        ,'T1.type AS establishment_type'
                        ,'T1.name AS establishment'
                        ,'T2.name AS commune'
                        ,'T3.name' 
                        ,'T3.fathers_family'
                        ,'T3.mothers_family')
            ->leftjoin('establishments AS T1', 'pro_programmings.establishment_id', '=', 'T1.id')
            ->leftjoin('communes AS T2', 'T1.commune_id', '=', 'T2.id')
            ->leftjoin('users AS T3', 'pro_programmings.user_id', '=', 'T3.id')
            ->Where('pro_programmings.year','LIKE','%'.$year.'%')
            ->Where('pro_programmings.access','LIKE','%'.Auth()->user()->id.'%')
            ->orderBy('T2.name','ASC')->get();
        }
        
        return view('programmings/programmings/index')->withProgrammings($programmings);
    }

    public function create() 
    {   
        $establishments = Establishment::whereIn('type',['CESFAM','CGR'])
                                       ->OrderBy('name')->get(); // Filtrar CENTROS
        $users = User::where('position', 'Funcionario Programación')->OrderBy('name')->get(); // Sólo Funcionario Programación
        return view('programmings/programmings/create')->withEstablishments($establishments)->withUsers($users);
    }

    public function store(Request $request)
    {
        $programmingValid = Programming::where('establishment_id', $request->establishment)
                                       ->where('year', $request->date)
                                       ->first();
        if($programmingValid){
            session()->flash('warning', 'Ya se ha iniciado esta Programación Operativa anteriormente');
        }
        else {
            $programming  = new Programming($request->All());
            $programming->year = $request->date;
            $programming->description = $request->description;
            $programming->establishment_id = $request->establishment;
            $programming->user_id  = $request->user;
            $programming->access   = serialize($request->access);
        
            $programming->save();
           
            //INSERT EVALUACION
            $programming->programming_reviews()
            ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'RECEPCION DENTRO DEL PLAZO LEGAL','active'=> 'SI','user_id'=>  Auth()->user()->id,'programming_id'=>$programming->id]);
            $programming->programming_reviews()
            ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'EL PLAN SE PRESENTA POR COMUNA','active'=> 'SI','user_id'=>  Auth()->user()->id,'programming_id'=>$programming->id]);
            $programming->programming_reviews()
            ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'PRESENTA  DIAGNÓSTICO','active'=> 'SI','user_id'=>  Auth()->user()->id,'programming_id'=>$programming->id]);
            $programming->programming_reviews()
            ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'DIAGNOSTICO PRESENTA estructura organizacional de los Centros de Salud de la comuna y de la unidad encargada de salud en la entidad administradora, sobre la base del plan de salud comunal y del modelo de atención definido por el Ministerio de Salud','active'=> 'SI','user_id'=>  Auth()->user()->id,'programming_id'=>$programming->id]);
            $programming->programming_reviews()
            ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'DIAGNOSTICO PRESENTA DOTACIÓN DE PERSONAL (presentada por categorías y jornada laboral)','active'=> 'SI','user_id'=>  Auth()->user()->id,'programming_id'=>$programming->id]);
            $programming->programming_reviews()
            ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'DIAGNOSTICO INCORPORA SITUACIÓN EPIDEMIOLÓGICA','active'=> 'SI','user_id'=>  Auth()->user()->id,'programming_id'=>$programming->id]);
            $programming->programming_reviews()
            ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'PRESENTA APARTADO DE MATRIZ DE CUIDADOS','active'=> 'SI','user_id'=>  Auth()->user()->id,'programming_id'=>$programming->id]);
            $programming->programming_reviews()
            ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'A LOS NODOS CRÍTICOS IDENTIFICADOS EN EL DIAGNÓSTICO SE LE  CREAN ESTRATEGIAS ABORDADAS  EN LA MATRIZ DE CUIDADOS ','active'=> 'SI','user_id'=>  Auth()->user()->id,'programming_id'=>$programming->id]);
            $programming->programming_reviews()
            ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'PRESENTA APARTADO DE PROGRAMACIÓN NUMÉRICA','active'=> 'SI','user_id'=>  Auth()->user()->id,'programming_id'=>$programming->id]);
            $programming->programming_reviews()
            ->create(['revisor' => 'REVISION JEFATURA DEL DEPARTAMENTO DE APS Y REDES','general_features'=> 'PROGRAMACIÓN NUMÉRICA EXISTE: PORGRAMACION DE HORAS DIRECTAS/ PROGRAMACION DE HORAS INDIRECTAS/PLA DE CAPACITACION ANUAL.','active'=> 'SI','user_id'=>  Auth()->user()->id,'programming_id'=>$programming->id]);
            $programming->programming_reviews()
            ->create(['revisor' => 'REFERENTE DE GÉNERO','general_features'=> 'EL DIAGNOSTICO PRESENTA LAS CONSIDERACIONES DE GENÉRO ADECUADAS (Apoyo referente de temática)','active'=> 'SI','user_id'=>  Auth()->user()->id,'programming_id'=>$programming->id]);
            $programming->programming_reviews()
            ->create(['revisor' => 'REFERENTE  PESPI e INTERCULTUALIDAD','general_features'=> 'EL DIAGNOSTICO PRESENTA ASPECTOS SUFICIENTES DE INTERCULTURALIDAD (Apoyo referente de temática)','active'=> 'SI','user_id'=>  Auth()->user()->id,'programming_id'=>$programming->id]);
            $programming->programming_reviews()
            ->create(['revisor' => 'REFERENTE OIRS','general_features'=> 'EL DIAGNÓSTICO IDENTIFICA ANALISIS DE RECLAMOS DE LA COMUNIDAD ','active'=> 'SI','user_id'=>  Auth()->user()->id,'programming_id'=>$programming->id]);
            $programming->programming_reviews()
            ->create(['revisor' => 'REVISION REFERENTE RURAL (cuando corresponda)','general_features'=> 'DIAGNOSTICO INCORPORA Y ANALIZA LAS PROBLEMATICAS DE LOS POBALDOS RURALES ','active'=> 'SI','user_id'=>  Auth()->user()->id,'programming_id'=>$programming->id]);
            $programming->programming_reviews()
            ->create(['revisor' => 'REVISION REFERENTE RURAL (cuando corresponda)','general_features'=> 'MATRIZ DE CUIDADOS INTEGRA PROBLEMAS DIAGNOSTICADOS EN LOCALIDADES RURALES','active'=> 'SI','user_id'=>  Auth()->user()->id,'programming_id'=>$programming->id]);
            $programming->programming_reviews()
            ->create(['revisor' => 'REVISION REFERENTE RURAL (cuando corresponda)','general_features'=> 'EN PROGRAMACIÓN NUMÉRICA SE CONSIDERA TIEMPOS DE VIAJE A RONDAS','active'=> 'SI','user_id'=>  Auth()->user()->id,'programming_id'=>$programming->id]);
            $programming->programming_reviews()
            ->create(['revisor' => 'REVISION DE CAPACITACIÓN MUNICIPAL','general_features'=> 'EL DIAGNÓTICO PRESENTA LAS BRECHAS DE CAPACITACIÓN  Y SE ENCUENTRA SEPARADO Y PRIORIZADO POR LOS EJES ESTRATÉGICOS DE LA ENS','active'=> 'SI','user_id'=>  Auth()->user()->id,'programming_id'=>$programming->id]);
            $programming->programming_reviews()
            ->create(['revisor' => 'REVISION DE CAPACITACIÓN MUNICIPAL','general_features'=> 'LA PROGRAMACION NUMÉRICA SE ENCUENTRA COMPLETAMENTE LLENA DE ACUERDO A LAS ORIENTACIONES PARA PROGRAMACIÓN EN RED','active'=> 'SI','user_id'=>  Auth()->user()->id,'programming_id'=>$programming->id]);

            

            session()->flash('info', 'Se ha iniciado una nueva Programación Operativa');
        }

        return redirect()->back();
    }

    public function show(Programming $programming)
    {
        //dd($programming);
        $establishments = Establishment::whereIn('type',['CESFAM','CGR'])
                                       ->OrderBy('name')->get();
        
        $reviews = Rev::where('programming_id',$programming->id)
                                       ->OrderBy('id')->get();
        //dd($reviews);
        $users = User::with('organizationalUnit')->where('position', 'Funcionario Programación')->OrderBy('name')->get(); // Sólo Funcionario Programación
        $access_list = unserialize($programming->access);
        $user = $programming->user;
        return view('programmings/programmings/show')->withProgramming($programming)->withReview($reviews)->with('access_list', $access_list)->with('user', $user)->withEstablishments($establishments)->withUsers($users);
    }

    public function update(Request $request, Programming $programming)
    {
      //dd($request);
      $programming->fill($request->all());
      $programming->year = $request->date;
      $programming->user_id  = $request->user;
      $programming->access   = serialize($request->access);
      $programming->save();
      return redirect()->back();
    }

}
