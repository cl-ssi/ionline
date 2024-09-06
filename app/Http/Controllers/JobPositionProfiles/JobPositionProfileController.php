<?php

namespace App\Http\Controllers\JobPositionProfiles;

use App\Models\JobPositionProfiles\JobPositionProfile;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Models\Parameters\StaffDecree;
use App\Models\Parameters\StaffDecreeByEstament;
use App\Models\JobPositionProfiles\Role;
use App\Models\JobPositionProfiles\Liability;
use App\Models\JobPositionProfiles\JobPositionProfileLiability;
use App\Models\JobPositionProfiles\Expertise;
use App\Models\JobPositionProfiles\ExpertiseProfile;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\JobPositionProfiles\WorkTeam;
use App\Models\Rrhh\Authority;

class JobPositionProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return view('job_position_profile.index');
    }

    public function own_index()
    {   
        return view('job_position_profile.own_index');
    }

    public function index_review()
    {   
        return view('job_position_profile.index_review');
    }

    public function index_to_sign()
    {   
        return view('job_position_profile.index_to_sign');
    }

    public function all_index()
    {   
        return view('job_position_profile.all_index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('job_position_profile.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jobPositionProfile = new JobPositionProfile($request->All());
        $jobPositionProfile->status = 'saved';
        $jobPositionProfile->user()->associate(auth()->user());
        $jobPositionProfile->creatorOrganizationalUnit()->associate(auth()->user()->organizationalUnit->id);
        
        /* O.U. DONDE SE DIRIGE EL PERFIL DE CARGO */
        $jobPositionProfile->organizationalUnit()->associate($request->jpp_ou_id);

        $jobPositionProfile->estament()->associate($request->estament_id);
        $jobPositionProfile->area()->associate($request->area_id);
        $jobPositionProfile->contractualCondition()->associate($request->contractual_condition_id);

        $jobPositionProfile->save();

        session()->flash('success', 'Estimado Usuario, se ha creado Exitosamente El Perfil de Cargo');
        return redirect()->route('job_position_profile.edit', $jobPositionProfile);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobPositionProfile  $jobPositionProfile
     * @return \Illuminate\Http\Response
     */
    public function show(JobPositionProfile $jobPositionProfile)
    {   
        return view('job_position_profile.show', compact('jobPositionProfile'));
    }

    public function show_approval($job_position_profile_id)
    {
        $jobPositionProfile = JobPositionProfile::find($job_position_profile_id);
        return view('job_position_profile.show_approval', compact('jobPositionProfile'));
    }

    public function to_sign(JobPositionProfile $jobPositionProfile)
    {   
        $authorities = Authority::getAmIAuthorityFromOu(today(), 'manager', auth()->id());
        $iam_authorities_in = array();

        foreach ($authorities as $authority){
            $iam_authorities_in[] = $authority->organizational_unit_id;
        }

        return view('job_position_profile.to_sign', compact('jobPositionProfile','iam_authorities_in'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobPositionProfile  $jobPositionProfile
     * @return \Illuminate\Http\Response
     */
    public function edit(JobPositionProfile $jobPositionProfile)
    {
        return view('job_position_profile.edit', compact('jobPositionProfile'));
    }

    public function edit_formal_requirements(JobPositionProfile $jobPositionProfile)
    {
        if($jobPositionProfile->contractual_condition_id != 2){
            if($jobPositionProfile->law == '18834'){
                $staffDecree = StaffDecree::latest()->first();

                $staffDecreeByEstaments = StaffDecreeByEstament::
                    where('staff_decree_id', $staffDecree->id)
                    ->where('estament_id', $jobPositionProfile->estament_id)
                    ->get();

                $generalRequirementsCount = collect(new StaffDecreeByEstament());
                
                foreach($staffDecreeByEstaments as $staffDecreeByEstament){
                    if($jobPositionProfile->degree >= $staffDecreeByEstament->start_degree
                        && $jobPositionProfile->degree <= $staffDecreeByEstament->end_degree){
                        $generalRequirementsCount->add($staffDecreeByEstament);
                    }
                }

                if($generalRequirementsCount->count() == 0){
                    session()->flash('danger', 'Estimado Usuario, existe un error en el rango de grados correspondiente al estamento: '.$jobPositionProfile->estament->name);
                    return view('job_position_profile.edit', compact('jobPositionProfile'));
                }
                else{
                    $generalRequirements = $generalRequirementsCount->first();
                }
            }
            else{
                /* EVALUAR CAMBIAR POR PARAMETRO */
                $generalRequirements = collect(new StaffDecreeByEstament());
                $generalRequirements->description   = 
                'Título Profesional otorgado por una Universidad del Estado o instituto profesional del estado o reconocido por éste o aquellos validados en Chile, de acuerdo a la legislación vigente.<br>Acredita dicho título con el certificado de inscripción en el registro nacional de prestadores individuales de salud de la superintendencia de salud, dicho documento será validado para profesionales nacionales y extranjeros provenientes del sector público y privado.';
            }
        }
        else{
            $generalRequirements = collect(new StaffDecreeByEstament());
            // Auxiliar o Administrativo
            if($jobPositionProfile->estament_id == 1 || $jobPositionProfile->estament_id == 2){
                $generalRequirements->description   = 'Licencia de Enseñanza Media o equivalente.';
            }
            // Profesional
            if($jobPositionProfile->estament_id == 3){
                $generalRequirements->description   = 'Título Profesional otorgado por una Universidad o Instituto Profesional del Estado o reconocido por éste o aquellos validados en Chile de acuerdo con la legislación vigente.';
            }
            // Técnico
            if($jobPositionProfile->estament_id == 4){
                $generalRequirements->description   = 'Título de Técnico de Nivel Medio o Superior otorgado por un Establecimiento de Educación reconocido y validado en Chile de acuerdo con la legislación vigente.';
            }
        }
        return view('job_position_profile.edit_formal_requirements', 
            compact('jobPositionProfile', 'generalRequirements'));
    }

    public function edit_objectives(JobPositionProfile $jobPositionProfile)
    {
        return view('job_position_profile.edit_objectives', compact('jobPositionProfile'));
    }

    public function edit_organization(JobPositionProfile $jobPositionProfile)
    {   
        $tree = $jobPositionProfile->organizationalUnit->treeWithChilds->toJson();

        return view('job_position_profile.edit_organization', compact('jobPositionProfile', 'tree'));
    }

    public function edit_liabilities(JobPositionProfile $jobPositionProfile)
    {
        $liabilities = Liability::all();

        $jppLiabilities = JobPositionProfileLiability::
            where('job_position_profile_id', $jobPositionProfile->id)
            ->get();

        return view('job_position_profile.edit_liabilities', compact('jobPositionProfile', 'liabilities', 'jppLiabilities'));
    }

    public function edit_expertise_map(JobPositionProfile $jobPositionProfile)
    {   
        $expertises = Expertise::where('estament_id', $jobPositionProfile->estament_id)
            ->where('area_id', $jobPositionProfile->area_id)
            ->get();

        return view('job_position_profile.edit_expertise_map', compact('jobPositionProfile', 'expertises'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobPositionProfile  $jobPositionProfile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobPositionProfile $jobPositionProfile)
    {
        /* Cambio de U.O. */
        $jobPositionProfile->fill($request->all());

        if($jobPositionProfile->organizationalUnit->id != $request->jpp_ou_id){
            if($jobPositionProfile->StatusValue == "Guardado"){
                /* O.U. DONDE SE DIRIGE EL PERFIL DE CARGO */
                $jobPositionProfile->organizationalUnit()->associate($request->jpp_ou_id);
            }
            if($jobPositionProfile->StatusValue == "Enviado" || $jobPositionProfile->StatusValue == "En revisión" ||
                $jobPositionProfile->StatusValue == "Pendiente"){
                /* O.U. DONDE SE DIRIGE EL PERFIL DE CARGO */
                $jobPositionProfile->organizationalUnit()->associate($request->jpp_ou_id);

                /* SE ELIMINAN LAS APROBACIONES */
                if(count($jobPositionProfile->approvals) > 0){
                    $jobPositionProfile->approvals()->delete();
                }
                if($jobPositionProfile->jobPositionProfileSigns){
                    $jobPositionProfile->jobPositionProfileSigns()->delete();
                }
                $jobPositionProfile->status = 'saved';
            }
        }
 
        $jobPositionProfile->estament()->associate($request->estament_id);
        $jobPositionProfile->area()->associate($request->area_id);
        $jobPositionProfile->contractualCondition()->associate($request->contractual_condition_id);

        $jobPositionProfile->save();

        session()->flash('success', 'Estimado Usuario, se ha actualizado Exitosamente El Perfil de Cargo');
        return redirect()->route('job_position_profile.edit', $jobPositionProfile);
    }

    public function update_formal_requirements(Request $request, JobPositionProfile $jobPositionProfile, $generalRequirements)
    {
        if($jobPositionProfile->law == '18834'){
            $jobPositionProfile->staffDecreeByEstament()->associate($generalRequirements);
        }
        else{
            $jobPositionProfile->general_requirement = $request->general_requirement;
        }
        $jobPositionProfile->fill($request->all());
        $jobPositionProfile->save();
        
        session()->flash('success', 'Estimado Usuario, se ha actualizado Exitosamente El Perfil de Cargo');
        return redirect()->route('job_position_profile.edit_formal_requirements', $jobPositionProfile);
    }

    public function update_objectives(Request $request, JobPositionProfile $jobPositionProfile)
    {
        $jobPositionProfile->fill($request->all());
        $jobPositionProfile->save();

        if($request->descriptions){
            foreach ($request->descriptions as $key => $description) {
                $role = new Role();
                $role->description = $description;
                $role->jobPositionProfile()->associate($jobPositionProfile->id);
                $role->save();
            }
        }
        
        session()->flash('success', 'Estimado Usuario, se han actualizado exitosamente los objetivos Perfil de Cargo');
        return redirect()->route('job_position_profile.edit_objectives', $jobPositionProfile);
    }

    public function update_organization(Request $request, JobPositionProfile $jobPositionProfile)
    {
        $jobPositionProfile->fill($request->all());
        $jobPositionProfile->save();

        if($request->descriptions){
            foreach ($request->descriptions as $key => $description) {
                $workTeam = new WorkTeam();
                $workTeam->description = $description;
                $workTeam->jobPositionProfile()->associate($jobPositionProfile->id);
                $workTeam->save();
            }
        }
        
        session()->flash('success', 'Estimado Usuario, se ha actualizado exitosamente la organización y contexto del cargo');
        return redirect()->route('job_position_profile.edit_organization', $jobPositionProfile);
    }

    public function store_liabilities(Request $request, JobPositionProfile $jobPositionProfile)
    {
        foreach($request->values as $key => $value){
            $jppLiabilities = new JobPositionProfileLiability();            
            $jppLiabilities->liability_id = $key;
            $jppLiabilities->value = $request->values[$key];
            $jppLiabilities->job_position_profile_id = $jobPositionProfile->id;

            $jppLiabilities->save();
        }
    
        session()->flash('success', 'Estimado Usuario, se han actualizado exitosamente las responsabilidades del cargo');
        return redirect()->route('job_position_profile.edit_liabilities', $jobPositionProfile);
    }

    public function update_liabilities(Request $request, JobPositionProfile $jobPositionProfile)
    {
        $jppLiabilities = JobPositionProfileLiability::
            where('job_position_profile_id', $jobPositionProfile->id)
            ->get();

        foreach($jppLiabilities as $jppLiability){
            foreach($request->values as $key => $value){
                // dd($key.' '.$jppLiability->liability_id, $value.' '.$jppLiability->value);
                if($key == $jppLiability->liability_id && $value != $jppLiability->value){  
                    // dd($jppLiability);  
                    $jppLiability->value = $request->values[$key];
                    $jppLiability->save();
                }
            }
        }
        
        session()->flash('success', 'Estimado Usuario, se han actualizado exitosamente las responsabilidades del cargo');
        return redirect()->route('job_position_profile.edit_liabilities', $jobPositionProfile);
    }

    public function store_expertises(Request $request, JobPositionProfile $jobPositionProfile)
    {
        foreach($request->values as $key => $value){
            $expertiseProfile = new ExpertiseProfile();
            $expertiseProfile->expertise_id = $key;        
            $expertiseProfile->value = $request->values[$key];  
            $expertiseProfile->job_position_profile_id = $jobPositionProfile->id;
            $expertiseProfile->save();
        }
    
        session()->flash('success', 'Estimado Usuario, se han actualizado exitosamente las competencias vinculadas al S.S.I.');
        return redirect()->route('job_position_profile.edit_expertise_map', $jobPositionProfile);
    }

    public function update_expertises(Request $request, JobPositionProfile $jobPositionProfile)
    {
        $expertisesProfile = ExpertiseProfile::
            where('job_position_profile_id', $jobPositionProfile->id)
            ->get();

        foreach($expertisesProfile as $expertiseProfile){
            foreach($request->values as $key => $value){
                // dd($key.' '.$jppLiability->liability_id, $value.' '.$jppLiability->value);
                if($key == $expertiseProfile->expertise_id && $value != $expertiseProfile->value){  
                    // dd($jppLiability);  
                    $expertiseProfile->value = $request->values[$key];
                    $expertiseProfile->save();
                }
            }
        }
        
        session()->flash('success', 'Estimado Usuario, se han actualizado exitosamente las competencias vinculadas al S.S.I.');
        return redirect()->route('job_position_profile.edit_expertise_map', $jobPositionProfile);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobPositionProfile  $jobPositionProfile
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobPositionProfile $jobPositionProfile)
    {
        $jobPositionProfile->roles()->delete();
        $jobPositionProfile->jppLiabilities()->delete();
        $jobPositionProfile->jppExpertises()->delete();
        $jobPositionProfile->jobPositionProfileSigns()->delete();
        $jobPositionProfile->delete();

        session()->flash('success', 'Estimado Usuario, se ha eliminado exitosamente el perfil de cargo');
        return redirect()->route('job_position_profile.index');
    }

    public function create_document(JobPositionProfile $jobPositionProfile){
        $tree = $jobPositionProfile->organizationalUnit->treeWithChilds->toJson();

        $pdf = PDF::loadView('job_position_profile.documents.document', compact('jobPositionProfile', 'tree'));

        return $pdf->stream('mi-perfil-de-cargo.pdf');

        // return view('job_position_profile.documents.chart', compact('jobPositionProfile', 'tree'));
        //return view('job_position_profile.index_to_sign');
    }

    public function download_signed_pdf(JobPositionProfile $jobPositionProfile)
    {
        if( Storage::exists($jobPositionProfile->approvals->last()->filename) ) {
            return Storage::response($jobPositionProfile->approvals->last()->filename);
        } 
        else {
            return redirect()->back()->with('warning', 'El archivo no se ha encontrado.');
        }
    }
}
