<?php

namespace App\Http\Controllers\ServiceRequests;

use App\Models\Documents\SignaturesFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Models\ServiceRequests\ServiceRequest;
use App\Models\ServiceRequests\Fulfillment;
use App\Models\ServiceRequests\Subdirection;
use App\Models\ServiceRequests\ResponsabilityCenter;
use App\Models\Parameters\Bank;
use App\Models\ServiceRequests\SignatureFlow;
use App\Models\ServiceRequests\ShiftControl;
use App\Models\Country;
use App\Models\ClCommune;
use App\Models\Parameters\Profession;
use App\Models\Rrhh\UserBankAccount;
use Illuminate\Support\Facades\Storage;
use Luecano\NumeroALetras\NumeroALetras;
use App\Mail\ServiceRequestNotification;
use App\Mail\DerivationNotification;
use App\Notifications\ServiceRequests\NewServiceRequest;
use Illuminate\Support\Facades\Mail;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\Establishment;
use App\Models\User;
use DB;
use App\Exports\ConsolidatedDataExport;
use App\Exports\ConsolidatedMasterDataExport;

use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Auth;
use App\Models\Rrhh\Authority;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;

use App\Exports\ServiceRequest\ConsolidatedReport;

use DateTime;
use DatePeriod;
use DateInterval;

class ServiceRequestController extends Controller

{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function test()

  {
    //16.152.174-
    $a1 = User::find(16055586);
    //dd($a1);

    $au = Authority::getBossFromUser($a1->organizationalUnit->id,Carbon::now());


    //$au = Authority::getBossFromUser(auth()->user()->organizationalUnit->id,Carbon::now());
    dd($au);

  }

  //función queda de respaldo, no se utiliza desde 14/04/2023
  public function index_bak()
  {
    $user_id = auth()->id();
    $users = User::orderBy('name', 'ASC')->get();

    $serviceRequestsOthersPendings = [];
    $serviceRequestsMyPendings = [];
    $serviceRequestsAnswered = [];
    $serviceRequestsCreated = [];
    $serviceRequestsRejected = [];

    $serviceRequests = ServiceRequest::whereHas("SignatureFlows", function ($subQuery) use ($user_id) {
      $subQuery->where('responsable_id', $user_id);
      $subQuery->orwhere('user_id', $user_id);
    })
    ->with('SignatureFlows','responsabilityCenter','employee')
    ->orderBy('id', 'asc')
    ->get();

    foreach ($serviceRequests as $key => $serviceRequest) {
      //not rejected
      if ($serviceRequest->SignatureFlows->where('status', '===', 0)->count() == 0) {
        foreach ($serviceRequest->SignatureFlows->sortBy('sign_position') as $key2 => $signatureFlow) {
          //with responsable_id
          if ($user_id == $signatureFlow->responsable_id) {
            if ($signatureFlow->status == NULL) {
              if ($serviceRequest->SignatureFlows->where('status', '!=', 2)->where('sign_position', $signatureFlow->sign_position - 1)->first()) {
                if ($serviceRequest->SignatureFlows->where('status', '!=', 2)->where('sign_position', $signatureFlow->sign_position - 1)->first()->status == NULL) {
                  $serviceRequestsOthersPendings[$serviceRequest->id] = $serviceRequest;
                } else {
                  $serviceRequestsMyPendings[$serviceRequest->id] = $serviceRequest;
                }
              }
              else{
                session()->flash('warning', 'Error con la solicitud ' . $serviceRequest->id . ', contactar al área TIC por este problema.');
              }
            } else {
              $serviceRequestsAnswered[$serviceRequest->id] = $serviceRequest;
            }
          }
          //with organizational unit authority
          if ($user_id == $signatureFlow->ou_id) {
          }
        }
      } else {
        $serviceRequestsRejected[$serviceRequest->id] = $serviceRequest;
      }
    }


    foreach ($serviceRequests as $key => $serviceRequest) {
      if (!array_key_exists($serviceRequest->id, $serviceRequestsOthersPendings)) {
        if (!array_key_exists($serviceRequest->id, $serviceRequestsMyPendings)) {
          if (!array_key_exists($serviceRequest->id, $serviceRequestsAnswered)) {
            $serviceRequestsCreated[$serviceRequest->id] = $serviceRequest;
          }
        }
      }
    }

    return view('service_requests.requests.index_bak', compact('serviceRequestsMyPendings', 'serviceRequestsOthersPendings', 'serviceRequestsRejected', 'serviceRequestsAnswered', 'serviceRequestsCreated', 'users'));
  }

  public function index($type)
  {
    $user_id = auth()->id();
    $users = User::orderBy('name', 'ASC')->get();

    $data = [];

    $notAvailableCount = 0;
    $pendingCount = 0;
    $signedCount = 0;
    $rejecedCount = 0;
    $createdCount = 0;

    $serviceRequests = ServiceRequest::whereHas("SignatureFlows", function($subQuery) use($user_id){
        $subQuery->whereNull('status')
                ->where( function($query) use($user_id){
                    $query->where('responsable_id', $user_id)
                            ->orwhere('user_id', $user_id);
                });
    })
    ->wheredoesnthave("SignatureFlows", function($subQuery) {
        $subQuery->where('status',0);
    })
    // ->wheredoesnthave("SignatureFlows", function($subQuery) {
    //     $subQuery->whereNull('status')
    //             ->where('sign_position',2);
    // })
    ->with('SignatureFlows')
    ->get();

    foreach ($serviceRequests as $key => $serviceRequest) {
        if ($serviceRequest->SignatureFlows->where('status', '===', 0)->count() == 0) {
            foreach ($serviceRequest->SignatureFlows->sortBy('sign_position') as $key2 => $signatureFlow) {
                //with responsable_id
                if ($user_id == $signatureFlow->responsable_id) {
                    if ($signatureFlow->status == NULL) {
                        // se encuentra signature flow anterior
                        $last_signature_flow = $serviceRequest->SignatureFlows->where('status', '!=', 2)->where('sign_position', $signatureFlow->sign_position - 1)->first();
                        if ($last_signature_flow) {
                            if ($last_signature_flow->status == NULL) {

                            } 
                            else 
                            {
                                if($type == "pending" && $user_id == $signatureFlow->responsable_id){
                                    $data[$serviceRequest->id] = $serviceRequest;
                                }

                                $pendingCount += 1;
                            }
                        }
                    } 
                }
            }
        }
    }

    $serviceRequests = ServiceRequest::whereHas("SignatureFlows", function($subQuery) use($user_id){
        $subQuery->whereNull('status')
                ->where( function($query) use($user_id){
                    $query->where('responsable_id', $user_id);
                });
    })
    ->wheredoesnthave("SignatureFlows", function($subQuery) {
        $subQuery->where('status',0);
    })
    ->with('SignatureFlows')
    ->get();

    foreach ($serviceRequests as $key => $serviceRequest) {
        if ($serviceRequest->SignatureFlows->where('status', '===', 0)->count() == 0) {
            foreach ($serviceRequest->SignatureFlows->sortBy('sign_position') as $key2 => $signatureFlow) {
                //with responsable_id
                if ($user_id == $signatureFlow->responsable_id) {
                    if ($signatureFlow->status == NULL) {
                        // se encuentra signature flow anterior
                        $last_signature_flow = $serviceRequest->SignatureFlows->where('status', '!=', 2)->where('sign_position', $signatureFlow->sign_position - 1)->first();
                        if ($last_signature_flow) {
                            if ($last_signature_flow->status == NULL) {

                                if($type == "notAvaliable"){
                                    $data[$serviceRequest->id] = $serviceRequest;
                                }
                                $notAvailableCount += 1;
                            } 
                        }
                    } 
                }
            }
        }
    }

    $rejecedCount = ServiceRequest::whereHas("SignatureFlows", function ($subQuery) use ($user_id) {
                                                $subQuery->where( function($query) use($user_id){
                                                            $query->where('responsable_id', $user_id);
                                                        });
                                            })
                                            ->whereHas("SignatureFlows", function ($subQuery) {
                                                $subQuery->where('status',0);
                                            })->count();
    if($type == "rejected"){
        $data = ServiceRequest::whereHas("SignatureFlows", function ($subQuery) use ($user_id) {
                                    $subQuery->where( function($query) use($user_id){
                                                $query->where('responsable_id', $user_id);
                                            });
                                })
                                ->whereHas("SignatureFlows", function ($subQuery) {
                                    $subQuery->where('status',0);
                                })->paginate(100);
    }

    $signedCount = ServiceRequest::whereHas("SignatureFlows", function ($subQuery) use ($user_id) {
                                                $subQuery->where('status',1)
                                                    ->where( function($query) use($user_id){
                                                        $query->where('responsable_id', $user_id);
                                                    });
                                            })->count();

    if($type == "signed"){
        $data = ServiceRequest::whereHas("SignatureFlows", function ($subQuery) use ($user_id) {
                                        $subQuery->where('status',1)
                                                ->where( function($query) use($user_id){
                                                    $query->where('responsable_id', $user_id);
                                                });
                                })->paginate(100);
    }

    $createdCount = ServiceRequest::where('creator_id',auth()->user()->id)->count();
    if($type == "created"){
        $data = ServiceRequest::where('creator_id',auth()->user()->id)->paginate(100);
    }

    $unitTotal = 0;
    // se verifica si usuario es autoridad (cualquiera)
    if(auth()->user()->can('Service Request: view-all ou requests')){
        $unitTotal = ServiceRequest::where('responsability_center_ou_id',auth()->user()->organizational_unit_id)->count();
        if($type == "unitTotal"){
            $data = ServiceRequest::where('responsability_center_ou_id',auth()->user()->organizational_unit_id)->paginate(100);
        }
    }

    return view('service_requests.requests.index', compact('data','type','users','notAvailableCount','pendingCount','rejecedCount',
                                                            'signedCount','createdCount','unitTotal'));
  }

  public function user(Request $request)
  {
    $fulfillments = array();
    $user = null;

    if ($request->input('run')) {
      $user = User::where('id',$request->input('run'))->withTrashed()->get()->first();

      if ($user) {
        $fulfillments = Fulfillment::whereHas(
          'ServiceRequest',
          function ($query) use ($user) {
            $query->where('user_id', $user->id);
          }
        )->orderBy('year', 'DESC')->orderBy('month', 'DESC')->get();
      }
    }
    $request->flash();

    return view('service_requests.requests.user', compact('user', 'fulfillments'));
  }

  public function aditional_data_list(Request $request)
  {
    $responsability_center_ou_id = $request->responsability_center_ou_id;
    $program_contract_type = $request->program_contract_type;
    $name = $request->name;
    // $estate = $request->estate;
    $profession_id = $request->profession_id;
    $id = $request->id;
    $type = $request->type;

    $establishment_id = auth()->user()->organizationalUnit->establishment_id;

    // dd($responsability_center_ou_id);
    $serviceRequests = ServiceRequest::when($responsability_center_ou_id != NULL, function ($q) use ($responsability_center_ou_id) {
        return $q->where('responsability_center_ou_id', $responsability_center_ou_id);
        })
        ->when($program_contract_type != NULL, function ($q) use ($program_contract_type) {
            return $q->where('program_contract_type', $program_contract_type);
        })
        ->when($type != NULL, function ($q) use ($type) {
            return $q->where('type', $type);
        })
        // ->when($estate != NULL, function ($q) use ($estate) {
        //   return $q->where('estate', $estate);
        // })
        ->when($profession_id != NULL, function ($q) use ($profession_id) {
            return $q->where('profession_id', $profession_id);
        })
        ->when(($name != NULL), function ($q) use ($name) {
            return $q->whereHas("employee", function ($subQuery) use ($name) {
            $subQuery->where('name', 'LIKE', '%' . $name . '%');
            $subQuery->orwhere('fathers_family', 'LIKE', '%' . $name . '%');
            $subQuery->orwhere('mothers_family', 'LIKE', '%' . $name . '%');
            });
        })
        ->when($id != NULL, function ($q) use ($id) {
            return $q->where('id', $id);
        })
        // si es sst, se devuelve toda la info que no sea hetg ni hah.
        ->when($establishment_id == 38, function ($q) {
            return $q->whereNotIn('establishment_id', [1, 41]);
        })
        ->when($establishment_id != 38, function ($q) use ($establishment_id) {
            return $q->where('establishment_id',$establishment_id);
        })
        ->orderBy('id', 'desc')
        ->paginate(100);
    // ->get();
    
    $responsabilityCenters = OrganizationalUnit::where('establishment_id',$establishment_id)
                                                ->orderBy('name')->get();   
    $professions = Profession::orderBy('name', 'ASC')->get();

    return view('service_requests.requests.aditional_data_list', compact('serviceRequests', 'responsabilityCenters', 'request','professions'));
  }

  public function transfer_requests(Request $request)
  {
    return view('service_requests.requests.transfer_requests');
  }

  public function change_signature_flow_view(Request $request)
  {
    $establishment_id = auth()->user()->organizationalUnit->establishment_id;
    $users = User::orderBy('name', 'ASC')->get();
    $serviceRequests = ServiceRequest::where('id',$request->id)
                                        // si es sst, se devuelve toda la info que no sea hetg ni hah.
                                        ->when($establishment_id == 38, function ($q) {
                                            return $q->whereNotIn('establishment_id', [1, 41]);
                                        })
                                        ->when($establishment_id != 38, function ($q) use ($establishment_id) {
                                            return $q->where('establishment_id',$establishment_id);
                                        })
                                        ->first();
    return view('service_requests.requests.change_signature_flow', compact('users', 'request', 'serviceRequests'));
  }

  public function change_signature_flow(Request $request)
  {
    $signatureFlow = SignatureFlow::find($request->signature_flow_id);
    $signatureFlow->responsable_id = $request->user_id;
    if (User::find($request->user_id)->organizational_unit_id != null) {
      $signatureFlow->ou_id = User::find($request->user_id)->organizational_unit_id;
    }
    $signatureFlow->save();

    session()->flash('success', 'Se ha modificado el responsable del flujo de firmas.');
    return redirect()->back();
  }

  public function delete_signature_flow(Request $request)
  {
    //flujos de firma siguientes, se les resta 1
    $signature_flows = SignatureFlow::where('service_request_id',SignatureFlow::find($request->signature_flow_id)->service_request_id)
                                    ->where('sign_position','>',SignatureFlow::find($request->signature_flow_id)->sign_position)
                                    ->get();
    foreach ($signature_flows as $key => $signature_flow) {
      $signature_flow->sign_position = $signature_flow->sign_position - 1;
      $signature_flow->save();
    }

    //elimina el flujo de firma
    $signatureFlow = SignatureFlow::find($request->signature_flow_id);
    $signatureFlow->delete();

    session()->flash('success', 'Se ha eliminado el responsable del flujo de firmas.');
    return redirect()->back();
  }





  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    // $users = User::where('organizational_unit_id',auth()->user()->organizationalUnit->id)->orderBy('name', 'ASC')->get();
    // $users = User::whereHas('organizationalUnit', function ($q) {
    //   $q->where('establishment_id', auth()->user()->organizationalUnit->establishment->id);
    // })->get();
    $establishments = Establishment::orderBy('name', 'ASC')->get();
    $professions = Profession::orderBy('name', 'ASC')->get();

    //signature flow
    if (auth()->user()->organizationalUnit->establishment_id == 38) {
        $subdirections = OrganizationalUnit::where('name', 'LIKE', '%direc%')->where('establishment_id', 38)->orderBy('name', 'ASC')->get();
        $responsabilityCenters = OrganizationalUnit::where('establishment_id', 38)->orderBy('name', 'ASC')->get();
    }
    //hospital
    elseif (auth()->user()->organizationalUnit->establishment_id == 1) {
        $subdirections = OrganizationalUnit::where('name', 'LIKE', '%direc%')->where('establishment_id', 1)->orderBy('name', 'ASC')->get();
        $responsabilityCenters = OrganizationalUnit::where('establishment_id', 1)
            ->orderBy('name', 'ASC')->get();
    }
    elseif (auth()->user()->organizationalUnit->establishment_id == 41) {
        $subdirections = OrganizationalUnit::where('name', 'LIKE', '%direc%')->where('establishment_id', 41)->orderBy('name', 'ASC')->get();
        $responsabilityCenters = OrganizationalUnit::where('establishment_id', 41)
            ->orderBy('name', 'ASC')->get();
    }
    //another
    else {
        session()->flash('info', 'Usted no posee una unidad organizacional válida para ingresar hojas de ruta.');
        return redirect()->back();
    }

    return view('service_requests.requests.create', compact('subdirections', 'responsabilityCenters', 'establishments', 'professions'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    // Valida si exista una solicitud ya creada para el funcionario
    if ($request->type != "Suma alzada") {
      $serviceRequest = ServiceRequest::where('user_id', $request->user_id)
        ->where('program_contract_type', $request->program_contract_type)
        ->where('start_date', $request->start_date)
        ->where('end_date', $request->end_date)
        ->where('responsability_center_ou_id', $request->responsability_center_ou_id)
        ->where('working_day_type', $request->working_day_type)
        ->get();
      if ($serviceRequest->count() > 0) {
        session()->flash('danger', 'ATENCIÓN! Ya existe una solicitud ingresada para este funcionario (Solicitud nro <b>' . $serviceRequest->first()->id . '</b> )');
        return redirect()->back();
      }
    }

    // 07/09/2023: solo para usuarios que no pertenezcan a RRHH del hospital
    // 07/09/2023: validación solicitada por samantha: en HETGH no se pueden crear más de 412 contratos (se obtienen en la consulta) suma alzada que 
    // sean del programa COVID 2022
    if(!auth()->user()->can('Service Request: fulfillments rrhh')){
        if ($request->type == "Suma alzada" && $request->programm_name == "Covid 2022" && $request->program_contract_type == "Mensual" && $request->establishment_id == 1) {
            // si usuario ya tiene creado un contrato en agosto, se permite la creación, de lo contrario no.
            $serviceRequestCount = ServiceRequest::whereDoesntHave("SignatureFlows", function ($subQuery) {
                                                    $subQuery->where('status', 0);
                                                })
                                                ->where('program_contract_type', $request->program_contract_type)
                                                ->where('type', $request->type)
                                                ->where('programm_name', $request->programm_name)
                                                ->where('establishment_id', $request->establishment_id)
                                                ->where('end_date', '>=', '2023-08-01')
                                                ->where('end_date', '<=', '2023-08-31')
                                                ->where('user_id', $request->user_id)
                                                ->count();
            if($serviceRequestCount==0){
                session()->flash('danger', 'ATENCIÓN! No es posible crear contrato nuevo, solicitar autorización a la subdirección de gestión de RRHH.');
                return redirect()->back();
            }
        } 
    }

    if (count($request->users) <= 1) {
      session()->flash('danger', 'ATENCIÓN! Ocurrió un error al crear el flujo de firmas. Intente nuevamente, si vuelve a ocurrir contacte al área de RRHH.');
      return redirect()->back();
    }

    //validate, user has ou
    if ($request->users <> null) {
      foreach ($request->users as $key => $user) {
        // dd(User::find($user)->id);
        $authorities = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', User::find($user)->id);
        $employee = User::find($user)->position;
        if ($authorities->isNotEmpty()) {
          $employee = $authorities[0]->position;
          $ou_id = $authorities[0]->organizational_unit_id;
        } else {
          $ou_id = User::find($user)->organizational_unit_id;
        }

        if ($ou_id == null) {
          session()->flash('info', User::find($user)->fullName . ' no posee unidad organizacional asignada.');
          return redirect()->back();
        }
      }
    }

    // si el usuario se encuentra eliminado, se vuelve a dejar activo
    if(User::withTrashed()->find($request->user_id)){
        if(User::withTrashed()->find($request->user_id)->trashed()){
            User::withTrashed()->find($request->user_id)->restore();
        }
    }

    // //devuelve user o lo crea
    // $user = User::updateOrCreate(
    // ['id' => $request->user_id],
    // [
    //     'dv' =>  $request->dv,
    //     'name' =>  $request->name,
    //     'fathers_family' =>  $request->fathers_family,
    //     'mothers_family' =>  $request->mothers_family,
    //     'country_id' =>  $request->country_id,
    //     'commune_id' => $request->commune_id,
    //     'address' =>  $request->address,
    //     'phone_number' =>  $request->phone_number,
    //     'organizational_unit_id' =>  $request->responsability_center_ou_id,
    //     'email' =>  $request->email
    // ]
    // );

    $user = User::find($request->user_id);
    if ($user) {
        // Si el usuario ya existe, lo actualizamos sin cambiar 'organizational_unit_id'
        $user->update([
            'dv' =>  $request->dv,
            'name' =>  $request->name,
            'fathers_family' =>  $request->fathers_family,
            'mothers_family' =>  $request->mothers_family,
            'country_id' =>  $request->country_id,
            'commune_id' => $request->commune_id,
            'address' =>  $request->address,
            'phone_number' =>  $request->phone_number,
            'email' =>  $request->email
        ]);
    } else {
        // Si el usuario no existe, lo creamos incluyendo 'organizational_unit_id'
        $user = User::create([
            'id' => $request->user_id,
            'dv' =>  $request->dv,
            'name' =>  $request->name,
            'fathers_family' =>  $request->fathers_family,
            'mothers_family' =>  $request->mothers_family,
            'country_id' =>  $request->country_id,
            'commune_id' => $request->commune_id,
            'address' =>  $request->address,
            'phone_number' =>  $request->phone_number,
            'organizational_unit_id' =>  $request->responsability_center_ou_id,
            'email' =>  $request->email
        ]);
    }


    //crea service request
    $serviceRequest = new ServiceRequest($request->All());
    $serviceRequest->user_id = $user->id;
    $serviceRequest->creator_id = Auth::id();
    if (isset($request->hsa_schedule_detail)) {
      $serviceRequest->schedule_detail = $request->hsa_schedule_detail;
    }
    $serviceRequest->save();





    //############ guarda cumplimiento ##############

    $start    = new DateTime($serviceRequest->start_date);
    $start->modify('first day of this month');
    $end      = new DateTime($serviceRequest->end_date);
    $end->modify('first day of next month');
    $interval = DateInterval::createFromDateString('1 month');
    $periods   = new DatePeriod($start, $interval, $end);
    $cont_periods = iterator_count($periods);

    // crea de forma automática las cabeceras
    if ($serviceRequest->program_contract_type == "Mensual" || ($serviceRequest->program_contract_type == "Horas" && ($serviceRequest->working_day_type == "HORA MÉDICA" || $serviceRequest->working_day_type == "TURNO DE REEMPLAZO" ))  )
    {
      if ($serviceRequest->fulfillments->count() == 0) {
            foreach ($periods as $key => $period) {
            $program_contract_type = "Mensual";
            $start_date_period = $period->format("Y-m-d");
            $end_date_period = Carbon::createFromFormat('Y-m-d', $period->format("Y-m-d"))->endOfMonth()->format("Y-m-d");
            if ($key == 0) {
                $start_date_period = $serviceRequest->start_date->format("Y-m-d");
            }
            if (($cont_periods - 1) == $key) {
                $end_date_period = $serviceRequest->end_date->format("Y-m-d");
                $program_contract_type = "Parcial";
            }

            $fulfillment = new Fulfillment();
            $fulfillment->service_request_id = $serviceRequest->id;
            if ($serviceRequest->program_contract_type == "Mensual") {
                $fulfillment->year = $period->format("Y");
                $fulfillment->month = $period->format("m");
            } else {
                $program_contract_type = "Horas Médicas";
                $fulfillment->year = $period->format("Y");
                $fulfillment->month = $period->format("m");
            }
            $fulfillment->type = $program_contract_type;
            $fulfillment->start_date = $start_date_period;
            $fulfillment->end_date = $end_date_period;
            $fulfillment->user_id = auth()->id();
            $fulfillment->save();
            }
      }
    } elseif ($serviceRequest->program_contract_type == "Horas") {
        if ($serviceRequest->fulfillments->count() == 0) {
            $fulfillment = new Fulfillment();
            $fulfillment->service_request_id = $serviceRequest->id;
            $fulfillment->type = "Horas No Médicas";
            $fulfillment->year = $serviceRequest->start_date->format("Y");
            $fulfillment->month = $serviceRequest->start_date->format("m");
            $fulfillment->start_date = $serviceRequest->start_date;
            $fulfillment->end_date = $serviceRequest->end_date;
            $fulfillment->user_id = auth()->id();
            $fulfillment->save();
        } else {
            $fulfillment = $serviceRequest->fulfillments->first();
        }
    }

    // ################### fin guarda cumplimiento #######################










    //get responsable_id organization in charge
    $authorities = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', $request->responsable_id);
    $employee = User::find($request->responsable_id)->position;
    if ($authorities->isNotEmpty()) {
        $employee = $authorities[0]->position; // . " - " . $authorities[0]->organizationalUnit->name;
        $ou_id = $authorities[0]->organizational_unit_id;
    } else {
        $ou_id = User::find($request->responsable_id)->organizational_unit_id;
    }

    //se crea la primera firma
    $SignatureFlow = new SignatureFlow($request->All());
    $SignatureFlow->user_id = Auth::id();
    $SignatureFlow->ou_id = $ou_id;
    $SignatureFlow->service_request_id = $serviceRequest->id;
    $SignatureFlow->type = "Responsable";
    $SignatureFlow->employee = $employee;
    $SignatureFlow->signature_date = Carbon::now();
    $SignatureFlow->status = 1;
    $SignatureFlow->sign_position = 1;
    $SignatureFlow->save();

    //firmas seleccionadas en la vista
    $sign_position = 2;
    if ($request->users <> null) {
        foreach ($request->users as $key => $user) {

            //saber la organizationalUnit que tengo a cargo
            $authorities = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', User::find($user)->id);
            $employee = User::find($user)->position;
            if ($authorities->isNotEmpty()) {
            $employee = $authorities[0]->position;
            $ou_id = $authorities[0]->organizational_unit_id;
            } else {
            $ou_id = User::find($user)->organizational_unit_id;
            }

            $SignatureFlow = new SignatureFlow($request->All());
            $SignatureFlow->ou_id = $ou_id;
            $SignatureFlow->responsable_id = User::find($user)->id;
            $SignatureFlow->user_id = Auth::id(); //User::find($user)->id;
            $SignatureFlow->service_request_id = $serviceRequest->id;
            if ($sign_position == 2) {
            $SignatureFlow->type = "Supervisor";
            } else {
            $SignatureFlow->type = "visador";
            }
            $SignatureFlow->employee = $employee;
            $SignatureFlow->sign_position = $sign_position;
            $SignatureFlow->save();

            $sign_position = $sign_position + 1;
        }
    }

    //guarda control de turnos
    if ($request->shift_start_date) {
        if ($request->shift_start_date != null) {
            foreach ($request->shift_start_date as $key => $shift_start_date) {
            $shiftControl = new ShiftControl($request->All());
            // $shiftControl->service_request_id = $serviceRequest->id;
            $shiftControl->fulfillment_id = $fulfillment->id;
            $shiftControl->start_date = $shift_start_date . " " . $request->shift_start_hour[$key];
            $shiftControl->end_date = $request->shift_end_date[$key] . " " . $request->shift_end_hour[$key];
            $shiftControl->observation = $request->shift_observation[$key];
            $shiftControl->save();
            }
        }
    }

    //send emails (2 flow position)
    // if (env('APP_ENV') == 'production') {
        // $email = $serviceRequest->SignatureFlows->where('sign_position', 2)->first()->user->email;
        // Mail::to($email)->send(new ServiceRequestNotification($serviceRequest));
        
        // if($serviceRequest->employee){
        //     if($serviceRequest->employee->email != null){
        //         if (filter_var($serviceRequest->employee->email, FILTER_VALIDATE_EMAIL)) {
        //             /*
        //             * Utilizando Notify
        //             */ 
        //             $serviceRequest->employee->notify(new NewServiceRequest($serviceRequest));
        //         } 
        //     }
        // }  
    // }

    session()->flash('info', 'La solicitud ' . $serviceRequest->id . ' ha sido creada.');
    return redirect()->route('rrhh.service-request.index','pending');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Pharmacies\Establishment  $establishment
   * @return \Illuminate\Http\Response
   */
  public function show(ServiceRequest $serviceRequest)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Pharmacies\Establishment  $establishment
   * @return \Illuminate\Http\Response
   */
  public function edit(ServiceRequest $serviceRequest)
  {
    //validate users without permission Service Request: additional data
    if (!auth()->user()->can('Service Request: view-all ou requests')) {
        if (!auth()->user()->can('Service Request: additional data')) {
        $user_id = auth()->id();
        if (
            $serviceRequest->signatureFlows->where('responsable_id', $user_id)->count() == 0 &&
            $serviceRequest->signatureFlows->where('user_id', $user_id)->count() == 0
        ) {
            session()->flash('danger', 'No tiene acceso a esta solicitud');
            return redirect()->route('rrhh.service-request.index','pending');
        }
        }
    }

    if($serviceRequest->SignatureFlows->isEmpty())
    {
      /* Envío al log de errores el id para su chequeo */
      logger("El ServiceRequest no tiene signature flows creados", ['id' => $serviceRequest->id]);
    }


    $users = User::orderBy('name', 'ASC')->get();
    $establishments = Establishment::orderBy('name', 'ASC')->get();
    $professions = Profession::orderBy('name', 'ASC')->get();
    $establishment_id = auth()->user()->organizationalUnit->establishment->id;
    //dd($establishment_id);

    $subdirections = OrganizationalUnit::where('name', 'LIKE', '%direc%')->where('establishment_id', $establishment_id)->orderBy('name', 'ASC')->get();
    $responsabilityCenters = OrganizationalUnit::orderBy('name', 'ASC')->get();
    $countries = Country::orderBy('name', 'ASC')->get();
    $communes = ClCommune::orderBy('name', 'ASC')->get();

    $SignatureFlow = $serviceRequest->SignatureFlows->where('employee', 'Supervisor de servicio')->first();

    //saber la organizationalUnit que tengo a cargo
    $authorities = Authority::getAmIAuthorityFromOu(Carbon::today(), 'manager', auth()->id());
    $employee = auth()->user()->position;
    if ($authorities->isNotEmpty()) {
        /* FIX: es una colección puede haber más de un authority */
      $employee = $authorities[0]->position . " - " . $authorities[0]->organizationalUnit->name;
    }

    $banks = Bank::where('active_agreement',true)->get();

    return view('service_requests.requests.edit', compact(
      'serviceRequest',
      'users',
      'establishments',
      'subdirections',
      'responsabilityCenters',
      'SignatureFlow',
      'employee',
      'banks',
      'countries',
      'communes',
      'professions'
    ));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Pharmacies\Establishment  $establishment
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, ServiceRequest $serviceRequest)
  {

    // elimina fulfillments que queden fuera del nuevo segmento del contrato
    foreach($serviceRequest->fulfillments->where('end_date','<',$request->start_date) as $fulfillment){
        $fulfillment->delete();
    }
    foreach($serviceRequest->fulfillments->where('start_date','>',$request->end_date) as $fulfillment){
        $fulfillment->delete();
    }

    //se guarda información de la solicitud
    $serviceRequest->fill($request->all());
    $serviceRequest->schedule_detail = $request->hsa_schedule_detail;
    $serviceRequest->save();

    //guarda control de turnos
    if ($request->shift_start_date != null) {
      //se elimina historico
      ShiftControl::where('service_request_id', $serviceRequest->id)->delete();
      //ingreso info.
      foreach ($request->shift_start_date as $key => $shift_start_date) {
        $shiftControl = new ShiftControl($request->All());
        $shiftControl->service_request_id = $serviceRequest->id;
        $shiftControl->start_date = Carbon::parse($shift_start_date . " " . $request->shift_start_hour[$key]);
        $shiftControl->end_date = Carbon::parse($request->shift_end_date[$key] . " " . $request->shift_end_hour[$key]);
        $shiftControl->observation = $request->shift_observation[$key];
        $shiftControl->save();
      }
    }

    session()->flash('info', 'La solicitud ' . $serviceRequest->id . ' ha sido modificada.');
    return redirect()->route('rrhh.service-request.index','pending');
  }

  public function update_aditional_data(Request $request, ServiceRequest $serviceRequest)
  {
    //se guarda información de la solicitud
    $serviceRequest->fill($request->all());
    if($request->has('signature_page_break')){
      $serviceRequest->signature_page_break = 1;
    }else{
      $serviceRequest->signature_page_break = 0;
    }
    $serviceRequest->save();

    session()->flash('info', 'La solicitud ' . $serviceRequest->id . ' ha sido modificada.');
    return redirect()->route('rrhh.service-request.aditional_data_list');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Pharmacies\Establishment  $establishment
   * @return \Illuminate\Http\Response
   */
  public function destroy(ServiceRequest $serviceRequest)
  {
    $serviceRequest->delete();
    session()->flash('info', 'La solicitud ' . $serviceRequest->id . ' ha sido eliminada.');
    return redirect()->route('rrhh.service-request.index','pending');
  }

  public function destroy_with_parameters(Request $request)
  {
    $serviceRequest = ServiceRequest::find($request->id);

    // validación
    if($serviceRequest){
        foreach ($serviceRequest->fulfillments as $key => $fulfillment) {
            if ($fulfillment->total_paid != NULL) {
                session()->flash('success', 'No se puede eliminar la solicitud porque ya tiene información de pago asociada.');
                return redirect()->back();
            }
        }
      
        $serviceRequest->observation = $request->observation;
        $serviceRequest->save();
    
        $serviceRequest->delete();
        session()->flash('info', 'La solicitud ' . $serviceRequest->id . ' ha sido eliminada.');
    }
    
    return redirect()->route('rrhh.service-request.index','pending');
  }

  public function consolidated_data(Request $request)
  {
    $establishment_id = auth()->user()->organizationalUnit->establishment_id;
    $year = $request->year;
    $semester = $request->semester;

    //solicitudes activas
    $serviceRequests = ServiceRequest::whereDoesntHave("SignatureFlows", function ($subQuery) {
        $subQuery->where('status', 0);
    })
    // ->when($establishment_id == 38, function ($q) {
    //     return $q->whereNotIn('establishment_id', [1, 41]);
    // })
    ->when($establishment_id != 38, function ($q) use ($establishment_id) {
        return $q->where('establishment_id',$establishment_id);
    })
    ->whereYear('start_date',$year)
    ->whereMonth('start_date',$semester)
    ->with('SignatureFlows','shiftControls','fulfillments','establishment','employee','profession','responsabilityCenter')
    ->orderBy('request_date', 'asc')
    ->paginate(50);

    //solicitudes Rechazadas
    $serviceRequestsRejected = ServiceRequest::whereHas("SignatureFlows", function ($subQuery) {
        $subQuery->where('status', 0);
    })
    // ->when($establishment_id == 38, function ($q) {
    //     return $q->whereNotIn('establishment_id', [1, 41]);
    // })
    ->when($establishment_id != 38, function ($q) use ($establishment_id) {
        return $q->where('establishment_id',$establishment_id);
    })
    ->whereYear('start_date',$request->year)
    ->whereMonth('start_date',$semester)
    ->with('SignatureFlows','shiftControls','fulfillments','establishment','employee','profession','responsabilityCenter')
    ->orderBy('request_date', 'asc')->get();
    
    return view('service_requests.requests.consolidated_data', compact('serviceRequests', 'serviceRequestsRejected', 'request'));
  }

  public function program_consolidated_report(Request $request)
  {
    $establishment_id = auth()->user()->organizationalUnit->establishment_id;

    $year = $request->year;
    $semester = $request->semester;
    $programm_name = $request->programm_name;

    // dd($year, $semester, $programm_name);

    //solicitudes activas
    $serviceRequests = ServiceRequest::whereDoesntHave("SignatureFlows", function ($subQuery) {
      $subQuery->where('status', 0);
    })
    ->when($establishment_id != 38, function ($q) use ($establishment_id) {
        return $q->where('establishment_id',$establishment_id);
    })
    ->whereYear('start_date',$year)
    ->when($semester == 1, function ($q) use ($semester) {
        return $q->where(function($query) {
                    $query->whereMonth('start_date',1)
                            ->orWhereMonth('start_date',2)
                            ->orWhereMonth('start_date',3)
                            ->orWhereMonth('start_date',4);
                });
      })
      ->when($semester == 2, function ($q) use ($semester) {
        return $q->where(function($query) {
                    $query->whereMonth('start_date',5)
                            ->orWhereMonth('start_date',6)
                            ->orWhereMonth('start_date',7)
                            ->orWhereMonth('start_date',8);
                });
      })
    ->when($semester == 3, function ($q) use ($semester) {
        return $q->where(function($query) {
                    $query->whereMonth('start_date',7)
                            ->orWhereMonth('start_date',9)
                            ->orWhereMonth('start_date',10)
                            ->orWhereMonth('start_date',11)
                            ->orWhereMonth('start_date',12);
                });
    })
    ->where('programm_name','LIKE','%'.$programm_name.'%')
    ->with('SignatureFlows','shiftControls','fulfillments','establishment','employee','profession','responsabilityCenter')
    ->orderBy('request_date', 'asc')
    ->get();

    $programm_name_array = ServiceRequest::where('establishment_id', 1)
                                        ->select('programm_name')
                                        ->distinct()->get();
    
    return view('service_requests.requests.program_consolidated_report', compact('serviceRequests', 'request','programm_name_array'));
  }

  public function active_contracts_report(Request $request)
  {
    $programm_name = $request->programm_name;
    $profession_id = $request->profession_id;

    //solicitudes activas
    $serviceRequests = ServiceRequest::where('id',0)->get();
    if($programm_name!=null || $profession_id != null){
        $serviceRequests = ServiceRequest::whereDoesntHave("SignatureFlows", function ($subQuery) {
            $subQuery->where('status', 0);
          })
          ->where('establishment_id', 1)
          ->when($programm_name != NULL, function ($q) use ($programm_name) {
              return $q->where('programm_name','LIKE','%'.$programm_name.'%');
          })
          ->when($profession_id != NULL, function ($q) use ($profession_id) {
              return $q->where('profession_id',$profession_id);
          })
          ->with('SignatureFlows','shiftControls','fulfillments','establishment','employee','profession','responsabilityCenter')
          ->whereDate('end_date','>=',now())
          ->orderBy('request_date', 'asc')
          ->get();
    }
    
    // dd($serviceRequests);

    $programm_name_array = ServiceRequest::where('establishment_id', 1)
                                        ->select('programm_name')
                                        ->distinct()->get();

    $professions_array = Profession::all();

    return view('service_requests.requests.active_contracts_report', compact('serviceRequests', 'request','programm_name_array','professions_array'));
  }

  public function consolidated_data_excel_download($establishment_id, $year, $semester){
        return Excel::download(new ConsolidatedReport($establishment_id, $year, $semester), 'consolidated.xlsx');
  }

  public function export_sirh()
  {
    return view('service_requests.export_sirh');
  }

  public function export_sirh_txt()
  {
    $filas = ServiceRequest::where('establishment_id', 1)->get();
    // ->where('sirh_contract_registration',0)->orWhereNull('sirh_contract_registration')
    // ->whereDoesntHave("SignatureFlows", function($subQuery) {
    //   $subQuery->where('status',0);
    // })
    // ->orderBy('request_date','asc')
    // ->get();

    $txt =
      'RUN|' .
      'DV|' .
      ' N°  cargo |' .
      ' Fecha  inicio  contrato |' .
      ' Fecha  fin  contrato |' .
      'Establecimiento|' .
      ' Tipo  de  decreto |' .
      ' Contrato  por  prestación |' .
      ' Monto  bruto |' .
      ' Número  de  cuotas |' .
      'Impuesto|' .
      ' Día  de  proceso |' .
      ' Honorario  suma  alzada |' .
      ' Financiado  proyecto |' .
      ' Centro  de  costo |' .
      'Unidad|' .
      ' Tipo  de  pago |' .
      ' Código  de  banco |' .
      ' Cuenta  bancaria |' .
      'Programa|' .
      'Glosa|' .
      'Profesión|' .
      'Planta|' .
      'Resolución|' .
      ' N°  resolución |' .
      ' Fecha  resolución |' .
      'Observación|' .
      'Función|' .
      ' Descripción  de  la  función  que  cumple |' .
      ' Estado  tramitación  del  contrato |' .
      ' Tipo  de  jornada |' .
      ' Agente  público |' .
      ' Horas  de  contrato |' .
      ' Código  por  objetivo |' .
      ' Función  dotación |' .
      ' Tipo  de  función |' .
      ' Afecto  a  sistema  de  turno' . "\r\n";

    foreach ($filas as $fila) {
      if (!$fila->resolution_number or !$fila->resolution_date) {
        $cuotas = $fila->end_date->month - $fila->start_date->month + 1;
        switch ($fila->program_contract_type) {
          case 'Horas':
            $por_prestacion = 'S';
            $sirh_n_cargo = 6;
            break;
          default:
            $por_prestacion = 'N';
            $sirh_n_cargo = 5;
            break;
        }

        switch ($fila->establishment->id) {
          case 1:
            $sirh_estab_code = 130;
            break;
          case 12:
            $sirh_estab_code = 127;
            break;
          case 38:
            $sirh_estab_code = 125;
            break;
          default:
            $sirh_estab_code = 0;
            break;
        }

        switch ($fila->programm_name) {
          case 'Covid19 Médicos':
            $sirh_program_code = 3904;
            break;
          case 'Covid19 No Médicos':
            $sirh_program_code = 3903;
            break;
          case 'Covid19-APS Médicos':
            $sirh_program_code = 3904;
            break;
          case 'Covid19-APS No Médicos':
            $sirh_program_code = 3903;
            break;
        }

        switch ($fila->weekly_hours) {
          case 44:
            $type_of_day = 'C';
            break;
          default:
            $type_of_day = 'P';
            break;
        }

        switch ($fila->estate) {
          case 'Administrativo':
            $function = 'Apoyo Administrativo';
            $function_type = 'N';
            break;
          default:
            $function = 'Apoyo Clínico';
            $function_type = 'S';
            break;
        }

        switch ($fila->working_day_type) {
          case 'DIURNO':
            $turno_afecto = 'S';
            break;
          default:
            $turno_afecto = 'N';
            break;
        }

        switch ($fila->responsabilityCenter->id) {
          case   12:
            $sirh_ou_id = 1253000;
            break;
          case   55:
            $sirh_ou_id = 1305102;
            break;
          case   18:
            $sirh_ou_id = 1301400;
            break;
          case   224:
            $sirh_ou_id = 1253000;
            break;
          case   225:
            $sirh_ou_id = 1252000;
            break;
          case   43:
            $sirh_ou_id = 1304407;
            break;
          case   116:
            $sirh_ou_id = 1301620;
            break;
          case   138:
            $sirh_ou_id = '3510-1';
            break;
          case   130:
            $sirh_ou_id = 1301650;
            break;
          case   141:
            $sirh_ou_id = 1301310;
            break;
          case   142:
            $sirh_ou_id = 1301320;
            break;
          case   136:
            $sirh_ou_id = 1301420;
            break;
          case   133:
            $sirh_ou_id = 1301410;
            break;
          case   140:
            $sirh_ou_id = 1301650;
            break;
          case   2:
            $sirh_ou_id = 1253000;
            break;
          case   125:
            $sirh_ou_id = 1301509;
            break;
          case   194:
            $sirh_ou_id = 1301905;
            break;
          case   177:
            $sirh_ou_id = 1301650;
            break;
          case   192:
            $sirh_ou_id = 1301904;
            break;
          case   162:
            $sirh_ou_id = 1301523;
            break;
          case   122:
            $sirh_ou_id = 1304105;
            break;
          case   99:
            $sirh_ou_id = 1305102;
            break;
          case   147:
            $sirh_ou_id = 1301203;
            break;
          case   126:
            $sirh_ou_id = 1302108;
            break;
          case   149:
            $sirh_ou_id = 1301202;
            break;
          case  24:
            $sirh_ou_id = 1301400;
            break;
          default:
            $sirh_ou_id = 'NO EXISTE';
            break;
        }

        switch ($fila->estate) {
          case "Profesional Médico":
            $planta = 0;
            break;
          case "Profesional":
            $planta = 4;
            break;
          case "Técnico":
            $planta = 5;
            break;
          case "Administrativo":
            $planta = 6;
            break;
          case "Farmaceutico":
            $planta = 3;
            break;
          case "Odontólogo":
            $planta = 1;
            break;
          case "Bioquímico":
            $planta = 2;
            break;
          case "Auxiliar":
            $planta = 7;
            break;
          default:
            $planta = '';
            break;
            // - 0 = Médicos
            // - 1 = Odontologos
            // - 2 = Bioquimicos
            // - 3 = Quimicos Farmaceuticos
            // - 4 = Profesional
            // - 5 = Técnicos
            // - 6 = Administrativos
            // - 7 = Auxiliares
        }

        switch ($fila->rrhh_team) {
          case "Residencia Médica":
            $sirh_profession_id = 1000;
            $sirh_function_id = 9082; // Antención clínica
            break;
          case "Médico Diurno":
            $sirh_profession_id = 1000;
            $sirh_function_id = 9082; // Atención clínica
            break;
          case "Enfermera Supervisora":
            $sirh_profession_id = 1058;
            $sirh_function_id = 9082; // Atención clínica
            break;
          case "Enfermera Diurna":
            $sirh_profession_id = 1058;
            $sirh_function_id = 9082; // Atención clínica
            break;
          case "Enfermera Turno":
            $sirh_profession_id = 1058;
            $sirh_function_id = 9082; // Atención clínica
            break;
          case "Kinesiólogo Diurno":
            $sirh_profession_id = 1057;
            $sirh_function_id = 9082; // Atención clínica
            break;
          case "Kinesiólogo Turno":
            $sirh_profession_id = 1057;
            $sirh_function_id = 9082; // Atención Clínica
            break;
          case "Téc.Paramédicos Diurno":
            $sirh_profession_id = 1027;
            $sirh_function_id = 9082; // Atención Clínica
            break;
          case "Téc.Paramédicos Turno":
            $sirh_profession_id = 1027;
            $sirh_function_id = 9082; // Atención Clínica
            break;
          case "Auxiliar Diurno":
            $sirh_profession_id = 111;
            $sirh_function_id = 9083; // Apoyo Administrativo
            break;
          case "Auxiliar Turno":
            $sirh_profession_id = 111;
            $sirh_function_id = 9083; // Apoyo Administrativo
            break;
          case "Terapeuta Ocupacional":
            $sirh_profession_id = 1055;
            $sirh_function_id = 9082; // Atención Clínica
            break;
          case "Químico Farmacéutico":
            $sirh_profession_id = 320;
            $sirh_function_id = 9082; // Atención Clínica
            break;
          case "Bioquímico":
            $sirh_profession_id = 1003;
            $sirh_function_id = 9082; // Atención Clínica
            break;
          case "Fonoaudiologo":
            $sirh_profession_id = 1319;
            $sirh_function_id = 9082; // Atención Clínica
            break;
          case "Administrativo Diurno":
            $sirh_profession_id = 119;
            $sirh_function_id = 9083; // Apoyo Administrativo
            break;
          case "Administrativo Turno":
            $sirh_profession_id = 119;
            $sirh_function_id = 9083; // Apoyo Administrativo
            break;
          case "Biotecnólogo Turno":
            $sirh_profession_id = 513;
            $sirh_function_id = 9082; // Atención Clínica
            break;
          case "Matrona Turno":
            $sirh_profession_id = 1060;
            $sirh_function_id = 9082; // Atención Clínica
            break;
          case "Matrona Diurno":
            $sirh_profession_id = 1060;
            $sirh_function_id = 9082; // Atención Clínica
            break;
          case "Otros técnicos":
            $sirh_profession_id = 530;
            $sirh_function_id = 9082; // Atención Clínica
            break;
          case "Psicólogo":
            $sirh_profession_id = 1160;
            $sirh_function_id = 9082; // Atención Clínica
            break;
          case "Tecn. Médico Diurno":
            $sirh_profession_id = 1316;
            $sirh_function_id = 9082; // Atención Clínica
            break;
          case "Tecn. Médico Turno":
            $sirh_profession_id = 1316;
            $sirh_function_id = 9082; // Atención Clínica
            break;
          case "Trabajador Social":
            $sirh_profession_id = 1020;
            $sirh_function_id = 9082; // Atención Clínica
            break;
        }

        $txt .=
          $fila->employee->id . '|' .
          $fila->employee->dv . '|' .
          $sirh_n_cargo . '|' . // contrato 5, prestaión u hora extra es 6
          $fila->start_date->format('d/m/Y') . '|' .
          $fila->end_date->format('d/m/Y') . '|' .
          $sirh_estab_code . '|' .
          'S' . '|' .
          $por_prestacion . '|' .
          $fila->gross_amount . '|' .
          $cuotas . '|' . // calculado entre fecha de contratos
          'S' . '|' .
          '5' . '|' .
          'S' . '|' .
          'S' . '|' .
          '18' . '|' .
          $sirh_ou_id . '|' .
          '1' . '|' . // cheque
          '0' . '|' . // tipo de banco 0 o 1
          '0' . '|' . // cuenta 0
          $sirh_program_code . '|' . // 3903 (no medico) 3904 (medico)
          '24' . '|' . // Glosa todos son 24
          $sirh_profession_id . '|' .
          $planta . '|' .
          '0' . '|' . // Todas son excentas = 0
          (($fila->resolution_number) ? $fila->resolution_number : '1') . '|' .
          (($fila->resolution_date) ? $fila->resolution_date->format('d/m/Y') : '15/02/2021') . '|' .
          substr($fila->digera_strategy, 0, 99) . '|' . // maximo 100
          $sirh_function_id . '|' .
          preg_replace("/\r|\n/", " ", substr($fila->service_description, 0, 254)) . '|' . // max 255
          'A' . '|' .
          $type_of_day . '|' . // calcular en base a las horas semanales y tipo de contratacion
          'N' . '|' .
          $fila->weekly_hours . '|' .
          '2103001' . '|' . // único para honorarios
          'N' . '|' .
          $function_type . '|' . // Apoyo asistenciasl S o N
          $turno_afecto . // working_day_type Diurno = S, el resto N
          "\r\n";

        $txt = mb_convert_encoding($txt, 'utf-8');
      } // if de sólo sin numero de resolucion

    }

    $response = new StreamedResponse();
    $response->setCallBack(function () use ($txt) {
      echo $txt;
    });
    $response->headers->set('Content-Type', 'text/plain; charset=utf-8');
    $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, "export_sirh.txt");
    $response->headers->set('Content-Disposition', $disposition);
    return $response;
  }

  public function resolution(ServiceRequest $ServiceRequest)
  {
    return view('service_requests.report_resolution', compact('ServiceRequest'));
  }

  public function derive(Request $request)
  {

    $user_id = auth()->id();
    $sender_name = User::find(auth()->id())->fullName;
    $receiver_name = User::find($request->derive_user_id)->fullName;
    $receiver_email = User::find($request->derive_user_id)->email;

    $serviceRequests = ServiceRequest::whereHas("SignatureFlows", function ($subQuery) use ($user_id) {
      $subQuery->whereNull('status');
      $subQuery->where('responsable_id', $user_id);
    })
      ->orderBy('id', 'asc')
      ->get();

    $cont = 0;
    $cant_rechazados = 0;
    foreach ($serviceRequests as $key => $serviceRequest) {
      if ($serviceRequest->SignatureFlows->where('status', '===', 0)->count() > 0) {
        $cant_rechazados += 1;
      } else {
        foreach ($serviceRequest->SignatureFlows->where('responsable_id', $user_id)->whereNull('status') as $key2 => $signatureFlow) {
          $signatureFlow->responsable_id = $request->derive_user_id;
          $signatureFlow->derive_date = Carbon::now();
          $signatureFlow->employee = $signatureFlow->employee . " (Traspasado desde " . $sender_name . ")";
          $signatureFlow->save();
          $cont += 1;
        }
      }
    }

    //send emails
    if ($cont > 0) {
      if (env('APP_ENV') == 'production') {
        Mail::to($receiver_email)->send(new DerivationNotification($cont, $sender_name, $receiver_name));
      }
    }

    session()->flash('info', $cont . ' solicitudes fueron derivadas.');
    return redirect()->route('rrhh.service-request.index','pending');
  }

  public function accept_all_requests()
  {
    $user_id = auth()->id();

    $serviceRequestsMyPendings = array();

    $serviceRequests = ServiceRequest::whereHas("SignatureFlows", function($subQuery) use($user_id){
                                        $subQuery->whereNull('status');
                                        $subQuery->where('responsable_id', $user_id);
                                    $subQuery->orwhere('user_id', $user_id);
                                    })
                                    ->wheredoesnthave("SignatureFlows", function($subQuery) {
                                        $subQuery->where('status',0);
                                    })
                                    ->with('SignatureFlows')
                                    ->get();

    $cont = 0;
    foreach ($serviceRequests as $key => $serviceRequest) {
      if ($serviceRequest->SignatureFlows->where('status','===',0)->count() == 0) {
        foreach ($serviceRequest->SignatureFlows->sortBy('sign_position') as $key2 => $signatureFlow) {
          if ($user_id == $signatureFlow->responsable_id) {
            if ($signatureFlow->status == NULL) {
              if ($serviceRequest->SignatureFlows->where('status', '!=', 2)->where('sign_position', $signatureFlow->sign_position - 1)->first()) {
                if ($serviceRequest->SignatureFlows->where('status', '!=', 2)->where('sign_position', $signatureFlow->sign_position - 1)->first()->status == NULL) {
                }else{
                  $serviceRequestsMyPendings[$cont] = $serviceRequest;
                  $cont += 1;
                }
              }
            }else{
            }
          }
        }
      }
    }

    //se aceptan todas las solicitudes
    $count = 0;
    foreach ($serviceRequestsMyPendings as $key => $serviceRequest) {
      $SignatureFlow = $serviceRequest->SignatureFlows->where('responsable_id',$user_id)->whereNull('status')->first();
      if ($SignatureFlow!=null) {
        $SignatureFlow->signature_date = Carbon::now();
        $SignatureFlow->status = 1;
        $SignatureFlow->save();
        $count += 1;
      }
    }

    session()->flash('info', $count . ' solicitudes fueron aceptadas.');
    return redirect()->route('rrhh.service-request.index','pending');
  }


  public function corrige_firmas()
  {
    // $serviceRequests = ServiceRequest::whereIn('id',[
    // 383,385,390,396,398,399,400,404,405,406,407,410,411,412,414,427,428,430,431,432,433,434,435,436,437,438,439,440,441,442,443,446,447,450,451,452,453,
    // 458,459,464,473,484,489,493,494,502,504,505,506,507,508,510,511,512,513,514,517,519,520,521,522,523,524,557,565,566,567,568,569,571,573,574,577,578,
    // 579,580,582,583,584,585,586,588,589,592,597,598,599,601,602,603,604,605,606,607,608,609,610,611,612,613,614,615,616,617,618,619,622,623,627,629,630])
    // ->get();
    //
    // foreach ($serviceRequests as $key => $serviceRequest) {
    //
    //   foreach ($serviceRequest->SignatureFlows as $key => $SignatureFlow) {
    //     if($SignatureFlow->sign_position > 2){
    //       $SignatureFlow->sign_position += 1;
    //       $SignatureFlow->save();
    //     }
    //   }
    //
    //   if ($serviceRequest->subdirection_ou_id == 85) {
    //
    //     $SignatureFlow = new SignatureFlow();
    //     $SignatureFlow->ou_id = $serviceRequest->subdirection_ou_id;
    //     $SignatureFlow->responsable_id = 13835321;
    //     $SignatureFlow->user_id = 13835321;
    //     $SignatureFlow->service_request_id = $serviceRequest->id;
    //     $SignatureFlow->type = "visador";
    //     $SignatureFlow->employee = "Subdirector SGCP";
    //     $SignatureFlow->sign_position = 3;
    //     $SignatureFlow->save();
    //
    //   }else{
    //
    //     $SignatureFlow = new SignatureFlow();
    //     $SignatureFlow->ou_id = $serviceRequest->subdirection_ou_id;
    //     $SignatureFlow->responsable_id = 111;
    //     $SignatureFlow->user_id = 111;
    //     $SignatureFlow->service_request_id = $serviceRequest->id;
    //     $SignatureFlow->type = "visador";
    //     $SignatureFlow->employee = "Subdirector Médico";
    //     $SignatureFlow->sign_position = 3;
    //     $SignatureFlow->save();
    //
    //   }
    // }
    // dd("terminó");

  }

  public function pending_requests(Request $request)
  {
    $establishment_id = auth()->user()->organizationalUnit->establishment_id;

    //solicitudes activas
    $serviceRequests = ServiceRequest::orderBy('id', 'asc')
                    ->with('SignatureFlows')
                    ->whereYear('start_date','>=',2023)
                    // si es sst, se devuelve toda la info que no sea hetg ni hah.
                    ->when($establishment_id == 38, function ($q) {
                        return $q->whereNotIn('establishment_id', [1, 41]);
                    })
                    ->when($establishment_id != 38, function ($q) use ($establishment_id) {
                        return $q->where('establishment_id',$establishment_id);
                    })
                    ->get();

    $array = [];
    $hoja_ruta_falta_aprobar = 0;
    // $group_array = [];
    foreach ($serviceRequests as $key => $serviceRequest) {
      $total = 0;
      $cant_aprobados = 0;
      $cant_rechazados = 0;
      $falta_aprobar = "";
      foreach ($serviceRequest->SignatureFlows as $key => $SignatureFlow) {
        $total += 1;
        if ($SignatureFlow->status == 1) {
          $cant_aprobados += 1;
        }
        if ($SignatureFlow->status === 0) {
          $cant_rechazados += 1;
        }
      }

      if ($cant_rechazados == 0) {
        if ($total != $cant_aprobados) {
          if ($serviceRequest->SignatureFlows->whereNull('status')->first()) {
            $array[$serviceRequest->SignatureFlows->whereNull('status')->sortBy('sign_position')->first()->user->fullName][$serviceRequest->id] = $serviceRequest->SignatureFlows->whereNull('status')->sortBy('sign_position')->first()->user;
            $hoja_ruta_falta_aprobar += 1;
          }
        }
      }
    }
    
    arsort($array);

    $serviceRequests = ServiceRequest::orderBy('id', 'asc')
                        ->where('program_contract_type', 'Mensual')
                        ->whereDoesntHave("SignatureFlows", function ($subQuery) {
                            $subQuery->where('status', 0);
                        })
                        ->whereDoesntHave("SignatureFlows", function ($subQuery) {
                            $subQuery->whereNull('status');
                        })
                        ->get();


    //cumplimiento
    $fulfillments_missing = [];
    $cumplimiento_falta_ingresar = 0;
    foreach ($serviceRequests as $key => $serviceRequest) {
        if($serviceRequest->SignatureFlows->where('sign_position', 2)->count() > 0){
            $fulfillments_missing[$serviceRequest->SignatureFlows->where('sign_position', 2)->first()->user->fullName] = 0;
        }
    }

    foreach ($serviceRequests as $key => $serviceRequest) {

        //si es que no tiene cumplimiento
        if ($serviceRequest->fulfillments->count() == 0) {
            $cumplimiento_falta_ingresar += 1;
            if($serviceRequest->SignatureFlows->where('sign_position', 2)->count() > 0){
                $fulfillments_missing[$serviceRequest->SignatureFlows->where('sign_position', 2)->first()->user->fullName] += 1;
            }
        }

        //si es que tiene cumplimiento, pero no aprobado
        if ($serviceRequest->fulfillments->whereNull('responsable_approbation')->count() > 0) {
            $cumplimiento_falta_ingresar += 1;
            if($serviceRequest->SignatureFlows->where('sign_position', 2)->count() > 0){
                $fulfillments_missing[$serviceRequest->SignatureFlows->where('sign_position', 2)->first()->user->fullName] += 1;
            }
            
        }
    }

    arsort($fulfillments_missing);

    return view('service_requests.requests.pending_requests', compact('array', 'hoja_ruta_falta_aprobar', 'fulfillments_missing', 'cumplimiento_falta_ingresar'));
  }

  // public function certificatePDF(ServiceRequest $serviceRequest)
  // {
  //   $pdf = app('dompdf.wrapper');
  //   $pdf->loadView('service_requests.requests.report_certificate', compact('serviceRequest'));

  //   return $pdf->stream('mi-archivo.pdf');
  // }

  public function callbackFirmaBudgetAvailability($message, $modelId, SignaturesFile $signaturesFile = null)
  {
    $serviceRequest = ServiceRequest::find($modelId);

    if (!$signaturesFile) {
      session()->flash('danger', $message);
      return redirect()->route('rrhh.service-request.fulfillment.edit', $serviceRequest->id);
    }

    $serviceRequest->signed_budget_availability_cert_id = $signaturesFile->id;
    $serviceRequest->save();
    // header('Content-Type: application/pdf');
    // echo base64_decode($signaturesFile->signed_file);
    session()->flash('success', $message);
    return redirect()->route('rrhh.service-request.fulfillment.edit', $serviceRequest->id);
  }

  public function signedBudgetAvailabilityPDF(ServiceRequest $serviceRequest)
  {
    return Storage::disk('gcs')->response($serviceRequest->signedBudgetAvailabilityCert->signed_file);
    //        header('Content-Type: application/pdf');
    //        if (isset($serviceRequest->signedBudgetAvailabilityCert)) {
    //            echo base64_decode($serviceRequest->signedBudgetAvailabilityCert->signed_file);
    //        }
  }

  public function existing_contracts_by_prof($user_id){
    $date = Carbon::today();
    $serviceRequests = ServiceRequest::where('user_id',$user_id)
                                      ->where('start_date','<=',$date)
                                      ->where('end_date','>=',$date)
                                      ->get()
                                      ->toJson();
    return $serviceRequests;
  }

  public function existing_active_contracts($start_date, $end_date){
    $start_date = Carbon::parse($start_date);
    $end_date = Carbon::parse($end_date);

    if($start_date->diffInYears($end_date)>0){
        return "El rango de fecha máximo de búsqueda es un año.";
    }

    $serviceRequests = ServiceRequest::where('end_date','>=',$start_date)
                                      ->where('end_date','<=',$end_date)
                                      ->whereDoesntHave("fulfillments", function ($subQuery) {
                                        $subQuery->whereHas("FulfillmentItems", function ($subQuery) {
                                          $subQuery->where('type', 'Renuncia voluntaria');
                                        });
                                      })
                                      ->whereDoesntHave("fulfillments", function ($subQuery) {
                                        $subQuery->whereHas("FulfillmentItems", function ($subQuery) {
                                          $subQuery->where('type', 'Abandono de funciones');
                                        });
                                      })
                                      ->whereDoesntHave("fulfillments", function ($subQuery) {
                                        $subQuery->whereHas("FulfillmentItems", function ($subQuery) {
                                          $subQuery->where('type', 'Término de contrato anticipado');
                                        });
                                      })
                                      ->groupBy('user_id')
                                      ->orderBy('end_date','DESC')
                                      ->get();

    $array = array();
    foreach($serviceRequests as $key => $serviceRequest)
    {
      $array[$key]['employee']['run'] = $serviceRequest->employee->runFormat();
      $array[$key]['employee']['name'] = $serviceRequest->employee->fullName;
      $array[$key]['employee']['email'] = $serviceRequest->email;
      $array[$key]['employee']['phone'] = $serviceRequest->phone_number;

      $array[$key]['contract']['number'] = $serviceRequest->contract_number;
      $array[$key]['contract']['type'] = $serviceRequest->contract_type;
      $array[$key]['contract']['end_date'] = $serviceRequest->end_date->format("Y-m-d");
    }
    return $array;
  }
}
