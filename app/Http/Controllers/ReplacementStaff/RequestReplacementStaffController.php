<?php
namespace App\Http\Controllers\ReplacementStaff;

use App\Models\ReplacementStaff\RequestReplacementStaff;
use App\Models\ReplacementStaff\ReplacementStaff;
use App\Models\ReplacementStaff\RequestSign;
use App\Models\ReplacementStaff\AssignEvaluation;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\Rrhh\Authority;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Notifications\ReplacementStaff\NotificationSign;
use App\Notifications\ReplacementStaff\NotificationNewRequest;
use App\Notifications\ReplacementStaff\NotificationEndSigningProcess;
use Illuminate\Support\Facades\Storage;
use App\Models\Parameters\Parameter;
use App\Models\Parameters\BudgetItem;
use App\Models\ReplacementStaff\Position;
use Illuminate\Http\Response;
use App\Models\Documents\SignaturesFile;
use App\Models\Documents\Approval;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ReplacementStaff\Applicant;

class RequestReplacementStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('replacement_staff.request.index');
    }

    public function assign_index()
    {
        return view('replacement_staff.request.assign_index');
    }

    public function sdgp_index()
    {
        return view('replacement_staff.request.sdgp_index');
    }

    public function store_change_degree(Request $request, RequestReplacementStaff $requestReplacementStaff)
    {
        $requestReplacementStaff->degree = $request->degree;
        $requestReplacementStaff->save();

        session()->flash('success', 'Estimado Usuario/a: Se ha modificado correctamente el grado en la solicitud.');
        return redirect()->back();
    }

    public function own_index()
    {
        return view('replacement_staff.request.own_index');
    }

    public function personal_index()
    {
        return view('replacement_staff.request.personal_index');
    }

    public function pending_personal_index()
    {
        /*
        $requests = RequestReplacementStaff::latest()
            ->where('request_status', 'pending')
            ->paginate(15);

        return view('replacement_staff.request.pending_personal_index', compact('requests'));
        */
    }

    public function ou_index()
    {
        return view('replacement_staff.request.ou_index');
    }

    public function to_sign_index(RequestReplacementStaff $requestReplacementStaff)
    {
        $authorities = Authority::getAmIAuthorityFromOu(today(), 'manager', auth()->id());
        $iam_authorities_in = array();

        foreach ($authorities as $authority){
            $iam_authorities_in[] = $authority->organizational_unit_id;
        }


        /* Listado de items presupuestarios */
        $budgetItems= BudgetItem::whereIn('code', ['210300500102', '210300500101','210100100102',
            '210100100103', '210200100102', '210200100103'])->get();

        if($authorities->isNotEmpty()){
            $pending_requests_to_sign = RequestReplacementStaff::
                with('legalQualityManage', 'fundamentManage', 'fundamentDetailManage', 'user', 'organizationalUnit')
                ->latest()
                ->whereHas('requestSign', function($q) use ($authority, $iam_authorities_in){
                    $q->WhereIn('organizational_unit_id', $iam_authorities_in)
                    ->Where('request_status', 'pending');
                })
                ->get();

            $requests_to_sign = RequestReplacementStaff::
                with('legalQualityManage', 'fundamentManage', 'fundamentDetailManage', 'user', 'organizationalUnit')
                ->latest()
                ->whereHas('requestSign', function($q) use ($authority, $iam_authorities_in){
                    $q->Where('organizational_unit_id', $iam_authorities_in)
                    ->Where(function ($j){
                        $j->Where('request_status', 'accepted')
                        ->OrWhere('request_status', 'rejected');
                    });
                })
                ->paginate(10);
            return view('replacement_staff.request.to_sign_index', compact('iam_authorities_in', 'pending_requests_to_sign', 
                'requests_to_sign'));
        }
        else{
            if(auth()->user()->organizationalUnit->id == Parameter::get('ou','PersonalSSI')){
                $iam_authorities_in[] = Parameter::get('ou','PersonalSSI');
            }

            $pending_requests_to_sign = RequestReplacementStaff::
                with('legalQualityManage', 'fundamentManage', 'fundamentDetailManage', 'user', 'organizationalUnit')
                ->latest()
                ->whereHas('requestSign', function($q) use ($iam_authorities_in) {
                    $q->WhereIn('organizational_unit_id', $iam_authorities_in)
                    ->Where('request_status', 'pending');
                })
                ->get();

            $requests_to_sign = RequestReplacementStaff::
                with('legalQualityManage', 'fundamentManage', 'fundamentDetailManage', 'user', 'organizationalUnit')
                ->latest()
                ->whereHas('requestSign', function($q) {
                    $q->Where('organizational_unit_id', 46)
                    ->Where(function ($j){
                        $j->Where('request_status', 'accepted')
                        ->OrWhere('request_status', 'rejected');
                    });
                })
                ->paginate(10);
            return view('replacement_staff.request.to_sign_index', compact('iam_authorities_in', 'pending_requests_to_sign', 
                'requests_to_sign'));
        }



        session()->flash('danger', 'Estimado Usuario/a: Usted no dispone de solicitudes para aprobación.');
        return redirect()->route('replacement_staff.request.own_index');
    }

    public function to_sign(RequestReplacementStaff $requestReplacementStaff){
        $authorities = Authority::getAmIAuthorityFromOu(today(), 'manager', auth()->id());
        $iam_authorities_in = array();

        foreach ($authorities as $authority){
            $iam_authorities_in[] = $authority->organizational_unit_id;
        }

        /* Listado de items presupuestarios */
        $budgetItems= BudgetItem::whereIn('code', ['210300500102', '210300500101','210100100102',
            '210100100103', '210200100102', '210200100103'])->get();

        return view('replacement_staff.request.to_sign', compact('requestReplacementStaff', 'iam_authorities_in', 'budgetItems'));
    }

    public function to_sign_approval($request_replacement_staff_id){
        $requestReplacementStaff = RequestReplacementStaff::find($request_replacement_staff_id);
        return view('replacement_staff.request.to_sign_approval', compact('requestReplacementStaff'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('replacement_staff.request.create');
    }

    public function create_replacement()
    {
        /*
        session()->flash('danger', 'Estimados Usuario: No es posible crear solicitudes debido a mantención programada, agradecemos su comprensión');
        return redirect()->route('replacement_staff.request.own_index');
        */

        return view('replacement_staff.request.create_replacement');
    }

    public function create_announcement()
    {
        /*
        session()->flash('danger', 'Estimados Usuario: No es posible crear solicitudes debido a mantención programada, agradecemos su comprensión');
        return redirect()->route('replacement_staff.request.own_index');
        */
        
        return view('replacement_staff.request.create_announcement');
    }

    public function create_extension(RequestReplacementStaff $requestReplacementStaff)
    {
        /*
        session()->flash('danger', 'Estimados Usuario: No es posible crear solicitudes debido a mantención programada, agradecemos su comprensión');
        return redirect()->route('replacement_staff.request.own_index');
        */

        $ouRoots = OrganizationalUnit::where('level', 1)->get();
        return view('replacement_staff.request.create_extension', compact('requestReplacementStaff', 'ouRoots'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $formType)
    {
        if(auth()->user()->organizationalUnit->level != 1){
            /* SE OBTIENEN LA INFORMACIÓN DEL FORMULARIO */
            if($formType == 'announcement'){
                $request_replacement = new RequestReplacementStaff();
                $request_replacement->name = $request->name;
                $request_replacement->ou_of_performance_id = $request->ou_of_performance_id;
                $position = new Position($request->All());
            }else{
                $request_replacement = new RequestReplacementStaff($request->All());
                /* CONDICIÓN DE CONVOCATORIA INTERNA O MIXTA 
                if($request->fundament_detail_manage_id != 6 && $request->fundament_detail_manage_id != 7){
                    $request_replacement->request_status = 'pending';
                }
                else{
                    $request_replacement->request_status = 'complete';
                }
                */
            }

            $request_replacement->request_status = 'pending';
            $request_replacement->form_type = $formType;
            $request_replacement->user()->associate(auth()->user());
            $request_replacement->organizationalUnit()->associate(auth()->user()->organizationalUnit);
            $request_replacement->establishment()->associate(auth()->user()->organizationalUnit->establishment);
            $request_replacement->requesterUser()->associate($request->requester_id);

            $now = Carbon::now()->format('Y_m_d_H_i_s');

            if($request->hasFile('job_profile_file')){
                $file = $request->file('job_profile_file');
                $file_name = $now.'_job_profile';
                if($formType == 'announcement'){
                    $position->job_profile_file = $file->storeAs('/ionline/replacement_staff/request_job_profile/', $file_name.'.'.$file->extension(), 'gcs');
                }
                else
                {
                    $request_replacement->job_profile_file = $file->storeAs('/ionline/replacement_staff/request_job_profile/', $file_name.'.'.$file->extension(), 'gcs');
                }
            }

            $file_verification = $request->file('request_verification_file');
            $file_name_verification = $now.'_request_verification';
            $request_replacement->request_verification_file = $file_verification->storeAs('/ionline/replacement_staff/request_verification_file/', $file_name_verification.'.'.$file_verification->extension(), 'gcs');

            $request_replacement->save();

            if($formType == 'announcement') $request_replacement->positions()->save($position);
            
            /* *********** NUEVA FUNCIONALIDAD HASTA 2024 ****************************** */
            // PROCESO DE APROBACIONES
            $organizationalUnit = $request_replacement->organizationalUnit;
            $previousApprovalId = null;

            for ($i = $request_replacement->organizationalUnit->level; $i >= 2; $i--){
                if($organizationalUnit->id != Parameter::get('ou','SubRRHH')){
                    $approval = $request_replacement->approvals()->create([
                        "module"                            => "Solicitudes de Contración",
                        "module_icon"                       => "bi bi-id-card",
                        "subject"                           => "Solicitud de Aprobación Jefatura Depto. o Unidad",
                        "sent_to_ou_id"                     => $organizationalUnit->id,
                        "document_route_name"               => "replacement_staff.request.to_sign_approval",
                        "document_route_params"             => json_encode(["request_replacement_staff_id" => $request_replacement->id]),
                        "active"                            => ($previousApprovalId == null) ? true : false,
                        "previous_approval_id"              => $previousApprovalId,
                        "callback_controller_method"        => "App\Http\Controllers\ReplacementStaff\RequestReplacementStaffController@approvalCallback",
                        "callback_controller_params"        => json_encode([
                            'request_replacement_staff_id'  => $request_replacement->id,
                            'applicant_id'                  => null,
                            'process'                       => ($i == 2) ? 'end leadership sign' : (($organizationalUnit->father->id == Parameter::get('ou','SubRRHH')) ? 'end leadership sign' :null)
                        ]),
                        "position"                          => "left",
                    ]);
                    $previousApprovalId = $approval->id;

                    if($organizationalUnit->level >= $i){
                        $organizationalUnit = $organizationalUnit->father;
                    }
                }
            }
            
            /*
            // SE CREA APROBACIÓN UNIDAD DE PERSONAL (EN MODULO INTERNO)
            if($request_replacement->form_type == 'replacement'){
                $request_sing = new RequestSign();
                $request_sing->position = 1;
                $request_sing->ou_alias = 'uni_per';
                $request_sing->organizationalUnit()->associate(Parameter::get('ou','PersonalSSI'));
                $request_sing->request_status = 'pending';
                $request_sing->requestReplacementStaff()->associate($request_replacement->id);
                $request_sing->save();
            }
            */

            /*
            if($formType == 'replacement'){
                $up_approval = $request_replacement->approvals()->create([
                    "module"                            => ($formType == "announcement") ? "Solicitudes de Contración: Convocatoria" : "Solicitudes de Contración: Reemplazo",
                    "module_icon"                       => "bi bi-id-card",
                    "subject"                           => "Solicitud de Aprobación Unidad de Personal",
                    "sent_to_ou_id"                     => Parameter::get('ou','PersonalSSI'),
                    "document_route_name"               => "replacement_staff.request.to_sign_approval",
                    "document_route_params"             => json_encode([
                        "request_replacement_staff_id" => $request_replacement->id
                    ]),
                    "active"                            => false,
                    "previous_approval_id"              => $previousApprovalId,
                    "callback_feedback_inputs"          => json_encode([
                        [
                            "type" => "select",
                            "label" => "Item presupuestario",
                            "name" => "budget_item_id",
                            "options" => [
                                262 => "210300500102 - Reemplazos del personal no médico",
                                263 => "210300500101 - Reemplazos del personal médico",
                                264 => "210100100102 - Personal de Planta Ley 18.834",
                                265 => "210100100103 - Personal de Planta Ley 19.664",
                                266 => "210200100102 - Personal a Contrata Ley 18.834",
                                267 => "210200100103 - Personal a Contrata Ley 19.664"
                            ],
                            "value" => null, // Acá se almacenará el resultado, no es necesario enviar
                        ]
                    ]),
                    "callback_controller_method"        => "App\Http\Controllers\ReplacementStaff\RequestReplacementStaffController@approvalCallback",
                    "callback_controller_params"        => json_encode([
                        'request_replacement_staff_id'  => $request_replacement->id,
                        'process'                       => 'budget item'
                    ])
                ]);
            }

            // SE CREA APROBACIÓN UNIDAD DE PLANIFICACION
            $prrhh_approval = $request_replacement->approvals()->create([
                "module"                            => ($formType == "announcement") ? "Solicitudes de Contración: Convocatoria" : "Solicitudes de Contración: Reemplazo",
                "module_icon"                       => "bi bi-id-card",
                "subject"                           => "Solicitud de Aprobación Planificación",
                "sent_to_ou_id"                     => Parameter::get('ou','PlanificacionRrhhSST'),
                "document_route_name"               => "replacement_staff.request.to_sign_approval",
                "document_route_params"             => json_encode(["request_replacement_staff_id" => $request_replacement->id]),
                "active"                            => false,
                "previous_approval_id"              => ($formType == 'replacement') ? $up_approval->id : $previousApprovalId,
                "callback_controller_method"        => "App\Http\Controllers\ReplacementStaff\RequestReplacementStaffController@approvalCallback",
                "callback_controller_params"        => json_encode([
                    'request_replacement_staff_id'  => $request_replacement->id,
                    'process'                       => null
                ])
            ]);

            // SE CREA APROBACIÓN SGDP 
            $sdgp_approval = $request_replacement->approvals()->create([
                "module"                            => ($formType == "announcement") ? "Solicitudes de Contración: Convocatoria" : "Solicitudes de Contración: Reemplazo",
                "module_icon"                       => "bi bi-id-card",
                "subject"                           => "Solicitud de Aprobación SDGP",
                "sent_to_ou_id"                     => Parameter::get('ou','SubRRHH'),
                "document_route_name"               => "replacement_staff.request.to_sign_approval",
                "document_route_params"             => json_encode(["request_replacement_staff_id" => $request_replacement->id]),
                "active"                            => false,
                "previous_approval_id"              => $prrhh_approval->id,
                "callback_controller_method"        => "App\Http\Controllers\ReplacementStaff\RequestReplacementStaffController@approvalCallback",
                "callback_controller_params"        => json_encode([
                    'request_replacement_staff_id'  => $request_replacement->id,
                    'process'                       => null
                ])
            ]);
            */
            /* ----------------------------------------------------------------------- */

            /*
            $position = 1;

            for ($i = $request_replacement->organizationalUnit->level; $i >= 2; $i--) {
                if ($i > 2) {
                    $request_sing = new RequestSign();

                    $request_sing->position = $position;
                    $request_sing->ou_alias = 'leadership';
                    if($i == $request_replacement->organizationalUnit->level){
                        $request_sing->organizationalUnit()->associate($request_replacement->organizational_unit_id);
                        $request_sing->request_status = 'pending';

                        //SE NOTIFICA PARA INICIAR EL PROCESO DE FIRMAS
                        $notification_ou_manager = Authority::getAuthorityFromDate($request_sing->organizational_unit_id, today(), 'manager');
                        if($notification_ou_manager){
                            $notification_ou_manager->user->notify(new NotificationSign($request_replacement));
                        }
                    }
                    else{
                        $lastSign = RequestSign::
                            where('request_replacement_staff_id', $request_replacement->id)
                            ->latest()
                            ->first();

                        $request_sing->organizationalUnit()->associate( $lastSign->organizationalUnit->father->id);
                    }

                    $request_sing->requestReplacementStaff()->associate($request_replacement->id);
                    $request_sing->save();
                }
                if ($i == 2){
                    $lastSign = RequestSign::    
                        where('request_replacement_staff_id', $request_replacement->id)
                        ->where('ou_alias', 'leadership')
                        ->orderBy('position', 'DESC')
                        ->first();

                    if($lastSign && $lastSign->organizationalUnit->father->id != Parameter::where('module', 'ou')->where('parameter', 'SubRRHH')->first()->value){
                        $request_sing = new RequestSign();
                        $request_sing->position = $position;
                        $request_sing->ou_alias = 'sub';
                        $request_sing->organizationalUnit()->associate($lastSign->organizationalUnit->father->id);
                        $request_sing->requestReplacementStaff()->associate($request_replacement->id);
                        $request_sing->save();
                    }
                    else{
                        if($i == $request_replacement->organizationalUnit->level){
                            $request_sing = new RequestSign();
                            $request_sing->position = $position;
                            $request_sing->ou_alias = 'sub';
                            $request_sing->organizationalUnit()->associate(auth()->user()->organizationalUnit);
                            $request_sing->request_status = 'pending';
                            $request_sing->requestReplacementStaff()->associate($request_replacement->id);
                            $request_sing->save();
                        }
                        else{
                            $position = $position - 1;
                        }
                    }

                    //  APROBACION UNIDAD DE PERSONAL 
                    if($request_replacement->form_type == 'replacement'){
                        $request_sing = new RequestSign();
                        $request_sing->position = $position + 1;
                        $request_sing->ou_alias = 'uni_per';
                        $request_sing->organizationalUnit()->associate(Parameter::where('module', 'ou')->where('parameter', 'PersonalSSI')->first()->value);
                        $request_sing->requestReplacementStaff()->associate($request_replacement->id);
                        $request_sing->save();
                    }
                    
                    // APROBACIÓN RR.HH. 
                    $request_sing = new RequestSign();
                    if($request_replacement->form_type == 'replacement'){
                        $request_sing->position = $position + 2;
                    }
                    else{
                        $request_sing->position = $position + 1;
                    }
                    $request_sing->ou_alias = 'sub_rrhh';
                    $request_sing->organizationalUnit()->associate(Parameter::where('module', 'ou')->where('parameter', 'SubRRHH')->first()->value);
                    $request_sing->requestReplacementStaff()->associate($request_replacement->id);
                    $request_sing->save();

                    // APROBACIÓN FINANZAS
                    $request_sing = new RequestSign();
                    if($request_replacement->form_type == 'replacement'){
                        $request_sing->position = $position + 3;
                    }
                    else{
                        $request_sing->position = $position + 2;
                    }
                    $request_sing->ou_alias = 'finance';
                    $request_sing->organizationalUnit()->associate(Parameter::where('module', 'ou')->where('parameter', 'FinanzasSSI')->first()->value);
                    $request_sing->requestReplacementStaff()->associate($request_replacement->id);
                    $request_sing->save();
                }
                $position++;
            }
            /* ----------------------------------------------------------------------- */

            //SE NOTIFICA A UNIDAD DE RECLUTAMIENTO
            $notification_reclutamiento_manager = Authority::getAuthorityFromDate(Parameter::get('ou', 'Reclutamiento', $request_replacement->establishment_id), today(), 'manager');
            if($notification_reclutamiento_manager){
                $notification_reclutamiento_manager->user->notify(new NotificationNewRequest($request_replacement, 'reclutamiento'));
            }
            //SE NOTIFICA A FUNCIONARIO SOLICITANTE
            $request_replacement->requesterUser->notify(new NotificationNewRequest($request_replacement, 'requester'));
            

            session()->flash('success', 'Estimados Usuario, se ha creado la Solicitud Exitosamente');
            return redirect()->route('replacement_staff.request.own_index');
        }
        else{
            session()->flash('danger', 'Estimado Usuario, su unidad organizacional no está autorizada para generar solicitudes, favor contactar a la Unidad de Reclutamiento');
            return redirect()->route('replacement_staff.request.own_index');
        }
    }

    public function store_extension(Request $request, RequestReplacementStaff $requestReplacementStaff, $formType)
    {
        /* SE OBTIENEN LA INFORMACIÓN DEL FORMULARIO */
        $newRequestReplacementStaff = new RequestReplacementStaff($request->All());
        $newRequestReplacementStaff->form_type = $formType;
        $newRequestReplacementStaff->request_id = $requestReplacementStaff->id;
        $newRequestReplacementStaff->request_status = 'pending';
        $newRequestReplacementStaff->user()->associate(auth()->user());
        $newRequestReplacementStaff->organizationalUnit()->associate(auth()->user()->organizationalUnit->id);
        $newRequestReplacementStaff->establishment()->associate(auth()->user()->organizationalUnit->establishment);
        $newRequestReplacementStaff->requesterUser()->associate($request->requester_id);

        /*
        //REVISAR ESTO...
        if($request->fundament_detail_manage_id != 6 && $request->fundament_detail_manage_id != 7){
            $newRequestReplacementStaff->request_status = 'pending';
        }
        else{
            $newRequestReplacementStaff->request_status = 'complete';
        }
        */

        $now = Carbon::now()->format('Y_m_d_H_i_s');
        if($request->hasFile('job_profile_file')){
            $file = $request->file('job_profile_file');
            $file_name = $now.'_job_profile';
            $newRequestReplacementStaff->job_profile_file = $file->storeAs('/ionline/replacement_staff/request_job_profile/', $file_name.'.'.$file->extension(), 'gcs');
        }

        $file_verification = $request->file('request_verification_file');
        $file_name_verification = $now.'_request_verification';
        $newRequestReplacementStaff->request_verification_file = $file_verification->storeAs('/ionline/replacement_staff/request_verification_file/', $file_name_verification.'.'.$file_verification->extension(), 'gcs');

        $newRequestReplacementStaff->save();

        // APPROVALS JEFATURA DIRECTA
        if($newRequestReplacementStaff->organizationalUnit->id != Parameter::get('ou','SubRRHH')){
            $approval = $newRequestReplacementStaff->approvals()->create([
                "module"                            => "Solicitudes de Contración",
                "module_icon"                       => "bi bi-id-card",
                "subject"                           => "Solicitud de Aprobación Jefatura Depto. o Unidad",
                "sent_to_ou_id"                     => $newRequestReplacementStaff->organizationalUnit->id,
                "document_route_name"               => "replacement_staff.request.to_sign_approval",
                "document_route_params"             => json_encode(["request_replacement_staff_id" => $newRequestReplacementStaff->id]),
                "active"                            => true,
                "previous_approval_id"              => null,
                "callback_controller_method"        => "App\Http\Controllers\ReplacementStaff\RequestReplacementStaffController@approvalCallback",
                "callback_controller_params"        => json_encode([
                    'request_replacement_staff_id'  => $newRequestReplacementStaff->id,
                    'applicant_id'                  => null,
                    'process'                       => 'end leadership sign',
                ]),
                "position"                          => "left",
            ]);
        }
        
        /*
        //  APROBACIÓN JEFATURA DIRECTA 
        $request_sing = new RequestSign();
        $request_sing->position = '1';
        $request_sing->ou_alias = 'leadership';
        $request_sing->organizationalUnit()->associate(auth()->user()->organizationalUnit->id);
        $request_sing->request_status = 'pending';
        $request_sing->requestReplacementStaff()->associate($newRequestReplacementStaff->id);
        $request_sing->save();

        // SE NOTIFICA PARA INICIAR EL PROCESO DE FIRMAS
        $notification_ou_manager = Authority::getAuthorityFromDate($request_sing->organizational_unit_id, today(), 'manager');
        if($notification_ou_manager){
            $notification_ou_manager->user->notify(new NotificationSign($newRequestReplacementStaff));
        }

        // APROBACIÓN UNIDAD PERSONAL 
        $request_sing_uni_per = new RequestSign();
        $request_sing_uni_per->position = '2';
        $request_sing_uni_per->ou_alias = 'uni_per';
        $request_sing_uni_per->organizationalUnit()->associate(Parameter::where('module', 'ou')->where('parameter', 'PersonalSSI')->first()->value);
        $request_sing_uni_per->requestReplacementStaff()->associate($newRequestReplacementStaff->id);
        $request_sing_uni_per->save();

        // APROBACIÓN RR.HH.
        $request_sing_rrhh = new RequestSign();
        $request_sing_rrhh->position = 3;
        $request_sing_rrhh->ou_alias = 'sub_rrhh';
        $request_sing_rrhh->organizationalUnit()->associate(Parameter::where('module', 'ou')->where('parameter', 'SubRRHH')->first()->value);
        $request_sing_rrhh->requestReplacementStaff()->associate($newRequestReplacementStaff->id);
        $request_sing_rrhh->save();

        // APROBACIÓN DEPTO. FINANZAS 
        $request_sing_finance = new RequestSign();
        $request_sing_finance->position = '4';
        $request_sing_finance->ou_alias = 'finance';
        $request_sing_finance->organizationalUnit()->associate(Parameter::where('module', 'ou')->where('parameter', 'FinanzasSSI')->first()->value);
        $request_sing_finance->requestReplacementStaff()->associate($newRequestReplacementStaff->id);
        $request_sing_finance->save();

        */
        //SE NOTIFICA A UNIDAD DE RECLUTAMIENTO
        $notification_reclutamiento_manager = Authority::getAuthorityFromDate(48, today(), 'manager');
        if($notification_reclutamiento_manager){
            $notification_reclutamiento_manager->user->notify(new NotificationNewRequest($newRequestReplacementStaff, 'reclutamiento'));
        }
        $newRequestReplacementStaff->requesterUser->notify(new NotificationNewRequest($newRequestReplacementStaff, 'requester'));

        session()->flash('success', 'Estimados Usuario, se ha creado la Solicitud de Extensión Exitosamente');
        return redirect()->route('replacement_staff.request.own_index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RequestReplacementStaff  $requestReplacementStaff
     * @return \Illuminate\Http\Response
     */
    public function show(RequestReplacementStaff $requestReplacementStaff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RequestReplacementStaff  $requestReplacementStaff
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestReplacementStaff $requestReplacementStaff)
    {
        if($requestReplacementStaff->form_type == 'announcement')
            return view('replacement_staff.request.edit_announcement', compact('requestReplacementStaff'));
        else
            return view('replacement_staff.request.edit_replacement', compact('requestReplacementStaff'));
    }

    public function edit_replacement(RequestReplacementStaff $requestReplacementStaff)
    {
        return view('replacement_staff.request.edit_replacement', compact('requestReplacementStaff'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RequestReplacementStaff  $requestReplacementStaff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequestReplacementStaff $requestReplacementStaff)
    {
        // return $request;
        if($requestReplacementStaff->form_type == 'announcement'){
            $requestReplacementStaff->name = $request->name;
            $requestReplacementStaff->ou_of_performance_id = $request->ou_of_performance_id;
            $position = Position::find($request->position_id);
            if($position){
                $position->fill($request->all());
            }else{
                $position = new Position($request->All());
                $position->request_replacement_staff_id = $requestReplacementStaff->id;
            }
        }else{
            $requestReplacementStaff->fill($request->all());
        }
        $requestReplacementStaff->requesterUser()->associate($request->requester_id);
        $now = Carbon::now()->format('Y_m_d_H_i_s');

        if($request->hasFile('job_profile_file')){
            $file = $request->file('job_profile_file');
            $file_name = $requestReplacementStaff->id.'_'.$now.'_job_profile';
            if($requestReplacementStaff->form_type == 'announcement'){
                //DELETE LAST
                Storage::delete($position->job_profile_file);
                $position->job_profile_file = $file->storeAs('/ionline/replacement_staff/request_job_profile/', $file_name.'.'.$file->extension(), 'gcs');
            }else{
                Storage::delete($requestReplacementStaff->job_profile_file);
                $requestReplacementStaff->job_profile_file = $file->storeAs('/ionline/replacement_staff/request_job_profile/', $file_name.'.'.$file->extension(), 'gcs');
            }
        }

        if($request->hasFile('request_verification_file')){
            $file_verification = $request->file('request_verification_file');
            $file_name_verification = $requestReplacementStaff->id.'_'.$now.'_request_verification';
            Storage::delete($requestReplacementStaff->request_verification_file);
            $requestReplacementStaff->request_verification_file = $file_verification->storeAs('/ionline/replacement_staff/request_verification_file/', $file_name_verification.'.'.$file_verification->extension(), 'gcs');
        }

        $requestReplacementStaff->save();
        if($requestReplacementStaff->form_type == 'announcement' && ($request->create_new_position == 'yes' || !$request->has('create_new_position'))) $position->save();

        session()->flash('success', 'Su solicitud ha sido sido correctamente actualizada.');
        return redirect()->route('replacement_staff.request.own_index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequestReplacementStaff  $requestReplacementStaff
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequestReplacementStaff $requestReplacementStaff)
    {
        //
    }

    public function show_file(RequestReplacementStaff $requestReplacementStaff)
    {
        return Storage::response($requestReplacementStaff->job_profile_file);
    }

    public function show_file_position(Position $position)
    {
        if($position->job_profile_file){
            return Storage::response($position->job_profile_file);
        }
        else{
            return redirect()->back()->with('danger', 'Estimado Usuario: El archivo no se encuentra disponible.');
        }
    }

    public function download(RequestReplacementStaff $requestReplacementStaff)
    {
        return Storage::download($requestReplacementStaff->job_profile_file);
    }

    public function show_verification_file(RequestReplacementStaff $requestReplacementStaff)
    {
        return Storage::response($requestReplacementStaff->request_verification_file);
    }

    public function download_verification(RequestReplacementStaff $requestReplacementStaff)
    {
        return Storage::download($requestReplacementStaff->request_verification_file);
    }

    public function request_by_dates(Request $request){
        $totalRequestByDates = collect(new RequestReplacementStaff);
        $pending    = 0;
        $complete   = 0;
        $rejected   = 0;

        $continuity     = 0;
        $firstRequest   = 0;

        return view('replacement_staff.reports.request_by_dates', compact('totalRequestByDates', 
            'request', 'pending', 'complete', 'rejected', 'firstRequest', 'continuity'));
    }

    public function search_request_by_dates(Request $request){
        // dd(request('organizational_unit_id_search'));

        $totalRequestByDates = RequestReplacementStaff::
            whereBetween('created_at', [$request->start_date_search, $request->end_date_search." 23:59:59"])
            // ->where('organizational_unit_id', $request->organizational_unit_id_search)
            ->when(request('organizational_unit_id_search') != null, function ($q) {
                return $q->where('organizational_unit_id', request('organizational_unit_id_search'));
            })
            ->get();
        
        $pending    = 0;
        $complete   = 0;
        $rejected   = 0;

        $continuity     = 0;
        $firstRequest   = 0;

        foreach($totalRequestByDates as $totalRequestByDate){
            /* Se cuentan Solicitudes por Estado */ 
            if($totalRequestByDate->request_status == 'pending'){
                $pending = $pending + 1;
            }
            if($totalRequestByDate->request_status == 'complete'){
                $complete = $complete + 1;
            }
            if($totalRequestByDate->request_status == 'rejected'){
                $rejected = $rejected + 1;
            }

            /* Se contabiliza Tipo de Solicitudes (Primer Formulario o Continuidad) */
            if($totalRequestByDate->request_id ){
                $continuity = $continuity + 1;
            }
            else{
                $firstRequest = $firstRequest + 1;
            }   
        }

        return view('replacement_staff.reports.request_by_dates', compact('totalRequestByDates', 
            'request', 'pending', 'complete', 'rejected', 'firstRequest', 'continuity'));
    }

    public function approval_status()
    {
        return view('replacement_staff.reports.approvals_status');
    }

    /*
    public function create_budget_availability_certificate_view(RequestReplacementStaff $requestReplacementStaff){
        $pdf = app('dompdf.wrapper');

        $pdf->loadView('replacement_staff.request.documents.budget_availability_certificate', compact('requestReplacementStaff'));

        $output = $pdf->output();

        return new Response($output, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' =>  'inline; filename="certificado_disponibilidad_presupuestaria.pdf"']
        );
    }
    */

    public function show_new_budget_availability_certificate_pdf($request_replacement_staff_id){

        $requestReplacementStaff = RequestReplacementStaff::find($request_replacement_staff_id);
        $establishment = $requestReplacementStaff->organizationalUnit->establishment;
        return Pdf::loadView('replacement_staff.request.documents.new_budget_availability_certificate_pdf', [
            'requestReplacementStaff' => $requestReplacementStaff,
            'establishment' => $establishment
        ])->stream('download.pdf');
    }

    public function create_budget_availability_certificate_document(RequestReplacementStaff $requestReplacementStaff){
        /*
        
        $noAttendanceRecord = NoAttendanceRecord::find($no_attendance_record_id);
        $documentFile = \PDF::loadView('rrhh.attendances.no-attendance-record', compact('noAttendanceRecord'));

        return $documentFile->stream();
        */

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('replacement_staff.request.documents.budget_availability_certificate', compact('requestReplacementStaff'));

        return $pdf->stream('certificado-disponibilidad-presupuestaria.pdf');
    }

    public function callbackSign($message, $modelId, SignaturesFile $signaturesFile = null)
    {
        if (!$signaturesFile) { 
            session()->flash('danger', $message);
            return redirect()->route('request_forms.pending_forms');   
        }
        else{
            // dd(auth()->id());
            $requestReplacementStaff = RequestReplacementStaff::find($modelId);

            //SE ACTUALIZA SIGN DE FINANZAS
            $event = $requestReplacementStaff->requestSign->where('ou_alias', 'finance')->first();

            $event->user_id         = auth()->id();
            $event->request_status  = 'accepted';
            $event->date_sign       = now();
            $event->save();

            /* MODIFICAR REQUEST CON SIGNATURE ID */  
            $requestReplacementStaff->signatures_file_id = $signaturesFile->id;
            $requestReplacementStaff->save();

            $notification_reclutamiento_manager = Authority::getAuthorityFromDate(Parameter::where('module', 'ou')->where('parameter', 'Reclutamiento', $requestReplacementStaff->establishment_id)->first()->value, today(), 'manager');
            if($notification_reclutamiento_manager){
                $notification_reclutamiento_manager->user->notify(new NotificationEndSigningProcess($requestReplacementStaff));
            }
            session()->flash('success', 'Su solicitud ha sido Aceptada en su totalidad.');
            return redirect()->route('replacement_staff.request.to_sign_index');
        }

    }

    public function show_budget_availability_certificate_signed(RequestReplacementStaff $requestReplacementStaff)
    {
        return Storage::response($requestReplacementStaff->signaturesFile->signed_file);
    }

    public function approvalCallback($approval_id, $request_replacement_staff_id, $process, $applicant_id){
        $approval = Approval::find($approval_id);
        $requestReplacementStaff = RequestReplacementStaff::find($request_replacement_staff_id);
        
        //APROBAR
        if($approval->status == 1){
            if($process == 'end leadership sign'){
                if($requestReplacementStaff->form_type == 'replacement'){
                    $request_sing = new RequestSign();
                    $request_sing->position = 1;
                    $request_sing->ou_alias = 'uni_per';
                    $request_sing->organizationalUnit()->associate(Parameter::get('ou', 'UnidadPersonal', $requestReplacementStaff->establishment_id));
                    $request_sing->request_status = 'pending';
                    $request_sing->requestReplacementStaff()->associate($requestReplacementStaff->id);
                    $request_sing->save();
                }
                else{
                    //AHORA SE CREA APROBACIONES EN APPROVALS (PLANIFICACION, )

                    // SE CREA APROBACIÓN UNIDAD DE PLANIFICACION
                    $prrhh_approval = $requestReplacementStaff->approvals()->create([
                        "module"                            => "Solicitudes de Contración",
                        "module_icon"                       => "bi bi-id-card",
                        "subject"                           => "Solicitud de Aprobación Planificación",
                        "sent_to_ou_id"                     => Parameter::get('ou','PlanificacionRrhh', $requestReplacementStaff->establishment_id),
                        "document_route_name"               => "replacement_staff.request.to_sign_approval",
                        "document_route_params"             => json_encode(["request_replacement_staff_id" => $requestReplacementStaff->id]),
                        "active"                            => true,
                        "previous_approval_id"              => $requestReplacementStaff->approvals->last()->id,
                        "callback_controller_method"        => "App\Http\Controllers\ReplacementStaff\RequestReplacementStaffController@approvalCallback",
                        "callback_controller_params"        => json_encode([
                            'request_replacement_staff_id'  => $requestReplacementStaff->id,
                            'applicant_id'                  => null,
                            'process'                       => null
                        ]),
                        "position"                          => "left",
                    ]);

                    // SE CREA APROBACIÓN SGDP 
                    $sdgp_approval = $requestReplacementStaff->approvals()->create([
                        "module"                            => "Solicitudes de Contración",
                        "module_icon"                       => "bi bi-id-card",
                        "subject"                           => "Solicitud de Aprobación SDGP",
                        "sent_to_ou_id"                     => Parameter::get('ou', 'SubRRHH', $requestReplacementStaff->establishment_id),
                        "document_route_name"               => "replacement_staff.request.to_sign_approval",
                        "document_route_params"             => json_encode(["request_replacement_staff_id" => $requestReplacementStaff->id]),
                        "active"                            => false,
                        "previous_approval_id"              => $prrhh_approval->id,
                        "callback_controller_method"        => "App\Http\Controllers\ReplacementStaff\RequestReplacementStaffController@approvalCallback",
                        "callback_controller_params"        => json_encode([
                            'request_replacement_staff_id'  => $requestReplacementStaff->id,
                            'applicant_id'                  => null,
                            'process'                       => 'to select'
                        ]),
                        "position"                          => "left",
                    ]);

                    // NOTIFICACION PARA RECLUTAMIENTO
                    /*
                    $notification_reclutamiento_manager = Authority::getAuthorityFromDate(Parameter::get('ou','ReclutamientoSSI'), today(), 'manager');
                    if($notification_reclutamiento_manager){
                        $notification_reclutamiento_manager->user->notify(new NotificationEndSigningProcess($requestReplacementStaff));
                    }
                    */
                }
            }
            if($process == 'to select'){
                $requestReplacementStaff->request_status = 'to assign';
                $requestReplacementStaff->save();
            }
            if($process == 'end'){
                // SE AGREGA CERTIFICADO AL POSTULANTE
                $applicant = Applicant::find($applicant_id);
                $applicant->approval_id = $approval_id;
                $applicant->save();

                // SE FINALIZA SOLICITUD: FINALIZADO
                $requestReplacementStaff->request_status = 'complete';
                $requestReplacementStaff->save();
            }
        }   

        // RECHAZAR
        if($approval->status == 0){
            $requestReplacementStaff->request_status = 'rejected';
            $requestReplacementStaff->save();
        }
    }
}
