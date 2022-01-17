<?php

namespace App\Http\Controllers\ServiceRequests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\ServiceRequests\ServiceRequest;
use App\Models\ServiceRequests\Fulfillment;
use App\Models\Rrhh\UserBankAccount;
use App\Rrhh\Authority;
use Luecano\NumeroALetras\NumeroALetras;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Auth;
use App\Establishment;
use App\Rrhh\OrganizationalUnit;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ComplianceExport;
use App\Exports\PayedExport;
use App\Exports\ContractExport;
use App\User;
use App\Models\Parameters\Profession;


class ReportController extends Controller
{
  public function toPay(Request $request)
  {
    $establishment_id = $request->establishment_id;
    $type = $request->type;
    $topay_fulfillments1 = Fulfillment::whereHas("ServiceRequest", function ($subQuery) {
      $subQuery->where('has_resolution_file', 1);
    })
      ->when($establishment_id != null, function ($q) use ($establishment_id) {
        return $q->whereHas("ServiceRequest", function ($subQuery) use ($establishment_id) {
          $subQuery->where('establishment_id', $establishment_id);
        });
      })
      ->when($type != null, function ($q) use ($type) {
        return $q->whereHas("ServiceRequest", function ($subQuery) use ($type) {
          $subQuery->where('type', $type);
        });
      })
      // ->when($establishment_id == 0, function ($q) use ($establishment_id) {
      //      return $q->whereHas("ServiceRequest", function($subQuery) use ($establishment_id) {
      //                  $subQuery->where('establishment_id',38);
      //                });
      //   })
      ->where('has_invoice_file', 1)
      ->whereNotNull('signatures_file_id')
      ->whereIn('type', ['Mensual', 'Parcial', 'Horas Médicas'])
      ->where('responsable_approbation', 1)
      ->where('rrhh_approbation', 1)
      ->where('finances_approbation', 1)
      ->whereNull('total_paid')
      ->get();

    $topay_fulfillments2 = Fulfillment::whereHas("ServiceRequest", function ($subQuery) {
      $subQuery->where('has_resolution_file', 1);
    })
      ->when($request->establishment_id != null, function ($q) use ($establishment_id) {
        return $q->whereHas("ServiceRequest", function ($subQuery) use ($establishment_id) {
          $subQuery->where('establishment_id', $establishment_id);
        });
      })
      ->when($type != null, function ($q) use ($type) {
        return $q->whereHas("ServiceRequest", function ($subQuery) use ($type) {
          $subQuery->where('type', $type);
        });
      })

      // ->when($request->establishment_id === 0, function ($q) use ($establishment_id) {
      //      return $q->whereHas("ServiceRequest", function($subQuery) use ($establishment_id) {
      //                  $subQuery->where('establishment_id',38);
      //                });
      //   })
      ->where('has_invoice_file', 1)
      ->whereNotNull('signatures_file_id')
      ->whereNotIn('type', ['Mensual', 'Parcial', 'Horas Médicas'])
      ->whereNull('total_paid')
      ->get();

    $topay_fulfillments = $topay_fulfillments1->merge($topay_fulfillments2);

    return view('service_requests.reports.to_pay', compact('topay_fulfillments', 'request'));
  }

  public function payed(Request $request)
  {
    $establishment_id = $request->establishment_id;
    $service_request_id = $request->service_request_id;
    $working_day_type = $request->working_day_type;

    $from = $request->from;
    $to = $request->to;
    if ($to == null) {
      $to = Carbon::now();
    }

    $request->flash();
    if ($request->has('excel')) {
      return Excel::download(new PayedExport($request), 'reporte-de-pagados.xlsx');
    }

    $payed_fulfillments1 = Fulfillment::whereHas("ServiceRequest", function ($subQuery) {
      $subQuery->where('has_resolution_file', 1);
    })
      ->when($establishment_id != null, function ($q) use ($establishment_id) {
        return $q->whereHas("ServiceRequest", function ($subQuery) use ($establishment_id) {
          $subQuery->where('establishment_id', $establishment_id);
        });
      })
      ->when($service_request_id != null, function ($q) use ($service_request_id) {
        return $q->whereHas("ServiceRequest", function ($subQuery) use ($service_request_id) {
          $subQuery->where('id', $service_request_id);
        });
      })
      ->when($working_day_type != null, function ($q) use ($working_day_type) {
        return $q->whereHas("ServiceRequest", function ($subQuery) use ($working_day_type) {
          $subQuery->where('working_day_type', $working_day_type);
        });
      })
      ->when($from != null, function ($q) use ($from, $to) {
        return $q->whereBetween('payment_date',[$from, $to]);
      })
      ->where('has_invoice_file', 1)
      ->whereIn('type', ['Mensual', 'Parcial'])
      ->where('responsable_approbation', 1)
      ->where('rrhh_approbation', 1)
      ->where('finances_approbation', 1)
      ->whereNotNull('total_paid')
      ->get();

    $payed_fulfillments2 = Fulfillment::whereHas("ServiceRequest", function ($subQuery) {
      $subQuery->where('has_resolution_file', 1);
    })
      ->when($request->establishment_id != null, function ($q) use ($establishment_id) {
        return $q->whereHas("ServiceRequest", function ($subQuery) use ($establishment_id) {
          $subQuery->where('establishment_id', $establishment_id);
        });
      })
      ->when($service_request_id != null, function ($q) use ($service_request_id) {
        return $q->whereHas("ServiceRequest", function ($subQuery) use ($service_request_id) {
          $subQuery->where('id', $service_request_id);
        });
      })
      ->when($working_day_type != null, function ($q) use ($working_day_type) {
        return $q->whereHas("ServiceRequest", function ($subQuery) use ($working_day_type) {
          $subQuery->where('working_day_type', $working_day_type);
        });
      })
      ->when($from != null, function ($q) use ($from, $to) {
        return $q->whereBetween('payment_date',[$from, $to]);
      })
      ->where('has_invoice_file', 1)
      ->whereNotIn('type', ['Mensual', 'Parcial'])
      ->whereNotNull('total_paid')
      ->get();

    $payed_fulfillments = $payed_fulfillments1->merge($payed_fulfillments2);
    //$payed_fulfillments = $payed_fulfillments->paginate(100);
    $payed_fulfillments = $this->paginate($payed_fulfillments);

    return view('service_requests.reports.payed', compact('payed_fulfillments', 'request'));
  }

  public function export(){

      $headers = array(
          "Content-type" => "text/csv",
          "Content-Disposition" => "attachment; filename=export_data.csv",
          "Pragma" => "no-cache",
          "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
          "Expires" => "0"
      );

      $filas = ServiceRequest::all();

      $columnas = array(
          'ID'
          // 'Establecimiento',
          // 'Unidad Organizacional',
          // 'Informado a través',
          // 'Nombre',
          // 'A.Paterno',
          // 'A.Materno',
          // 'RUN',
          // '1° Dosis Cita',
          // '1° Suministrada',
          // '2° Dosis Cita',
          // '2° Suministrada'
      );

      $callback = function() use ($filas, $columnas)
      {
          $file = fopen('php://output', 'w');
          fputs($file, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
          fputcsv($file, $columnas,';');
          foreach($filas as $fila) {
              fputcsv($file, array(
                  $fila->id
                  // $fila->aliasEstab,
                  // $fila->organizationalUnit,
                  // $fila->aliasInformMethod,
                  // $fila->name,
                  // $fila->fathers_family,
                  // $fila->mothers_family,
                  // $fila->runFormat,
                  // $fila->first_dose,
                  // $fila->first_dose_at,
                  // $fila->second_dose,
                  // $fila->second_dose_at,
              ),';');
          }
          fclose($file);
      };
      return response()->stream($callback, 200, $headers);
  }



  public function bankPaymentFile($establishment_id = NULL)
  {
    $fulfillments1 = Fulfillment::whereHas("ServiceRequest", function ($subQuery) {
      $subQuery->where('has_resolution_file', 1);
    })
      ->when($establishment_id != null, function ($q) use ($establishment_id) {
        return $q->whereHas("ServiceRequest", function ($subQuery) use ($establishment_id) {
          $subQuery->where('establishment_id', $establishment_id);
        });
      })
      // ->when($establishment_id === 0, function ($q) use ($establishment_id) {
      //      return $q->whereHas("ServiceRequest", function($subQuery) use ($establishment_id) {
      //                  $subQuery->whereNotIn('establishment_id',[1,2]);
      //                });
      //   })
      ->where('has_invoice_file', 1)
      ->whereNotNull('signatures_file_id')
      ->where('payment_ready', 1)
      ->whereNull('total_paid')
      ->whereIn('type', ['Mensual', 'Parcial'])
      ->where('responsable_approbation', 1)
      ->where('rrhh_approbation', 1)
      ->where('finances_approbation', 1)
      ->get();

    $fulfillments2 = Fulfillment::whereHas("ServiceRequest", function ($subQuery) {
      $subQuery->where('has_resolution_file', 1);
    })
      ->when($establishment_id != null, function ($q) use ($establishment_id) {
        return $q->whereHas("ServiceRequest", function ($subQuery) use ($establishment_id) {
          $subQuery->where('establishment_id', $establishment_id);
        });
      })
      // ->when($establishment_id === 0, function ($q) use ($establishment_id) {
      //      return $q->whereHas("ServiceRequest", function($subQuery) use ($establishment_id) {
      //                  $subQuery->whereNotIn('establishment_id',[1,2]);
      //                });
      //   })
      ->where('has_invoice_file', 1)
      ->whereNotNull('signatures_file_id')
      ->where('payment_ready', 1)
      ->whereNull('total_paid')
      ->whereNotIn('type', ['Mensual', 'Parcial'])
      ->get();

    $fulfillments = $fulfillments1->merge($fulfillments2);

    if ($fulfillments->count() == 0) {
      session()->flash('warning', "No existen solicitudes aptas para pago.");
      return redirect()->back();
    }

    $txt = '';
    foreach ($fulfillments as $fulfillment) {
      if (!$fulfillment->serviceRequest->employee->bankAccount) {
        session()->flash('warning', "La solicitud con id {$fulfillment->serviceRequest->id} no contiene el banco a donde se debe pagar.");
        return redirect()->back();
      }
      if (!$fulfillment->serviceRequest->employee->bankAccount->type) {
        session()->flash('warning', "La solicitud con id {$fulfillment->serviceRequest->id} no contiene método de pago.");
        return redirect()->back();
      }
      if (!$fulfillment->serviceRequest->employee->bankAccount->number) {
        session()->flash('warning', "La solicitud con id {$fulfillment->serviceRequest->id} no contiene número de cuenta.");
        return redirect()->back();
      }
      if (!$fulfillment->total_to_pay) {
        session()->flash('warning', "La solicitud con id {$fulfillment->serviceRequest->id} no contiene total a pagar.");
        return redirect()->back();
      }

      $totalToPay = $fulfillment->total_to_pay - round($fulfillment->total_to_pay * 0.115);
      $txt .=
        $fulfillment->serviceRequest->employee->id . strtoupper($fulfillment->serviceRequest->employee->dv) . "\t" .
        strtoupper(trim($fulfillment->serviceRequest->employee->fullName)) . "\t" .
        strtolower($fulfillment->serviceRequest->email) . "\t" .
        $fulfillment->serviceRequest->employee->bankAccount->bank->code . "\t" .
        $fulfillment->serviceRequest->employee->bankAccount->type . "\t" .
        intval($fulfillment->serviceRequest->employee->bankAccount->number) . "\t" .
        $totalToPay . "\r\n"; // Para final de linea de txt en windows
    }

    $response = new StreamedResponse();
    $response->setCallBack(function () use ($txt) {
      echo $txt;
    });
    $response->headers->set('Content-Type', 'text/plain');
    $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, "pago-banco.txt");
    $response->headers->set('Content-Disposition', $disposition);

    return $response;
  }

  public function pendingResolutions(Request $request)
  {
    $serviceRequests = ServiceRequest::whereNull('has_resolution_file')->orWhere('has_resolution_file', '===', 0)
    ->paginate(100);
      //->get();
    foreach ($serviceRequests as $key => $serviceRequest) {
      //only completed
      if ($serviceRequest->SignatureFlows->where('status', '===', 0)->count() == 0 && $serviceRequest->SignatureFlows->whereNull('status')->count() == 0) {
      } else {
        $serviceRequests->forget($key);
      }
    }

    // dd($fulfillments);
    return view('service_requests.reports.pending_resolutions', compact('serviceRequests'));
  }


  public function withoutBankDetails()
  {

    $servicerequests = ServiceRequest::whereHas("fulfillments", function ($subQuery) {
      $subQuery->where('has_invoice_file', 1);
    })
      ->get();

    return view('service_requests.reports.without_bank_details', compact('servicerequests'));
  }

  public function withBankDetails()
  {

    $userbankaccounts = UserBankAccount::paginate(50);

    return view('service_requests.reports.with_bank_details', compact('userbankaccounts'));
  }

  public function exportCsv()
  {
    $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=exportacion.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $filas = UserBankAccount::all();

        $columnas = array(
            'RUT',
            'NOMBRE',
            'DIRECCIÓN',
            'TELEFONO',
            'EMAIL',
            'BANCO',
            'NUMERO DE CUENTA',
            'TIPO DE PAGO'
        );

        $callback = function() use ($filas, $columnas)
        {
            $file = fopen('php://output', 'w');
            fputs($file, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
            fputcsv($file, $columnas,';');

            foreach($filas as $fila) {
                fputcsv($file, array(
                  $fila->user->runFormat(),
                  $fila->user->getFullNameAttribute(),
                  $fila->user->address,
                  $fila->user->phone_number,
                  $fila->user->email,
                  $fila->bank->name,
                  $fila->number,
                  $fila->getTypeText()
                ),';');
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
  }

  public function indexWithResolutionFile()
  {
    $serviceRequests = ServiceRequest::orderByDesc('id')
      ->where('has_resolution_file', 1)->paginate(50);
    $title = 'Solicitudes con resolución cargada';
    return view('service_requests.reports.index_with_resolution_file', compact('serviceRequests', 'title'));
    /* Hacer foreach de cada SRs y dentro hacer un foreach de sus fulfillments y mostrar cual tiene boleta y cual no */
  }

  public function indexWithoutResolutionFile()
  {
    $serviceRequests = ServiceRequest::orderByDesc('id')
      ->whereNull('has_resolution_file')
      ->orWhere('has_resolution_file', 0)->paginate(50);
    $title = 'Solicitudes sin resolución cargada';
    return view('service_requests.reports.index_with_resolution_file', compact('serviceRequests', 'title'));
    /* Hacer foreach de cada SRs y dentro hacer un foreach de sus fulfillments y mostrar cual tiene boleta y cual no */
  }

  public function resolutionPDF(ServiceRequest $ServiceRequest)
  {
    $formatter = new NumeroALetras();
    $ServiceRequest->gross_amount_description = $formatter->toWords($ServiceRequest->gross_amount, 0);

    if ($ServiceRequest->fulfillments) {
      foreach ($ServiceRequest->fulfillments as $key => $fulfillment) {
        $fulfillment->total_to_pay_description = $formatter->toWords($fulfillment->total_to_pay, 0);
      }
    }

    $pdf = app('dompdf.wrapper');
    $pdf->loadView('service_requests.report_resolution', compact('ServiceRequest'));

    return $pdf->stream('mi-archivo.pdf');
    // return view('service_requests.report_resolution', compact('serviceRequest'));
    // $pdf = \PDF::loadView('service_requests.report_resolution');
    // return $pdf->stream();
  }

  public function resolutionPDFhsa(ServiceRequest $ServiceRequest)
  {
    $formatter = new NumeroALetras();
    $ServiceRequest->gross_amount_description = $formatter->toWords($ServiceRequest->gross_amount, 0);

    if ($ServiceRequest->fulfillments) {
      foreach ($ServiceRequest->fulfillments as $key => $fulfillment) {
        $fulfillment->total_to_pay_description = $formatter->toWords($fulfillment->total_to_pay, 0);
      }
    }

    $pdf = app('dompdf.wrapper');

    if ($ServiceRequest->working_day_type == "DIARIO") {
      $pdf->loadView('service_requests.report_resolution_diary', compact('ServiceRequest'));
    }else{
      $pdf->loadView('service_requests.report_resolution_hsa', compact('ServiceRequest'));
    }


    return $pdf->stream('mi-archivo.pdf');
    // return view('service_requests.report_resolution', compact('serviceRequest'));
    // $pdf = \PDF::loadView('service_requests.report_resolution');
    // return $pdf->stream();
  }

  public function payRejected(Request $request)
  {

    $program_contract_type = $request->program_contract_type;
    $working_day_type = $request->working_day_type;
    $responsabilityCenters = OrganizationalUnit::orderBy('name', 'ASC')->get();
    $establishments = Establishment::orderBy('name', 'ASC')->get();
    $responsability_center_ou_id = $request->responsability_center_ou_id;
    $establishment_id = $request->establishment_id;
    $type = $request->type;

    $fulfillments = Fulfillment::where('payment_ready', 0)
      ->when($program_contract_type != null, function ($q) use ($program_contract_type) {
        return $q->whereHas("ServiceRequest", function ($subQuery) use ($program_contract_type) {
          $subQuery->where('program_contract_type', $program_contract_type);
        });
      })
      ->when($working_day_type != null, function ($q) use ($working_day_type) {
        return $q->whereHas("ServiceRequest", function ($subQuery) use ($working_day_type) {
          $subQuery->where('working_day_type', $working_day_type);
        });
      })
      ->when($responsability_center_ou_id != null, function ($q) use ($responsability_center_ou_id) {
        return $q->whereHas("ServiceRequest", function ($subQuery) use ($responsability_center_ou_id) {
          $subQuery->where('responsability_center_ou_id', $responsability_center_ou_id);
        });
      })
      ->when($establishment_id != null, function ($q) use ($establishment_id) {
        return $q->whereHas("ServiceRequest", function ($subQuery) use ($establishment_id) {
          $subQuery->where('establishment_id', $establishment_id);
        });
      })
      ->when($type != null, function ($q) use ($type) {
        return $q->whereHas("ServiceRequest", function ($subQuery) use ($type) {
          $subQuery->where('type', $type);
        });
      })

      ->orderByDesc('id')
      ->get();

    // if(isset($program_contract_type))
    // {
    //   $fulfillments = $fulfillments::with('ServiceRequest')->whereHas("ServiceRequest", function ($subQuery) use ($program_contract_type) {
    //     $subQuery->where('program_contract_type', $program_contract_type);
    //   })->get();

    // }
    $request->flash();
    return view('service_requests.reports.pay_rejected', compact('fulfillments', 'request', 'responsabilityCenters', 'establishments'));
  }

  public function budgetAvailability(ServiceRequest $serviceRequest)
  {
    // $pdf = app('dompdf.wrapper');
    // $pdf->loadView('service_requests.requests.report_certificate', compact('serviceRequest'));

    // return $pdf->stream('mi-archivo.pdf');


    //$authority = Authority::find(serviceRequest)
    $authority = new Authority;
    //1 es el hospital
    if ($serviceRequest->responsabilityCenter->establishment->id == 1) {
      //$authority = authority->getAuthorityFromDate(1,'2020-04-09','manager');
    }


    return view('service_requests.reports.budget_availability', compact('serviceRequest'));
  }

  public function pending(Request $request, $who)
  {
    if (Auth::user()->organizationalUnit->establishment_id == 38) {
      $responsabilityCenters = OrganizationalUnit::where('establishment_id', 38)->orderBy('name', 'ASC')->get();
    }
    //hospital
    elseif (Auth::user()->organizationalUnit->establishment_id == 1) {
      $responsabilityCenters = OrganizationalUnit::where('establishment_id', 1)->orderBy('name', 'ASC')->get();
    }

    $establishments = Establishment::all();
    $user_id = Auth::user()->id;
    $query = Fulfillment::query();
    $responsability_center = $request->responsability_center;

    // dd($request->responsability_center);
    $query->Search($request)
      ->whereHas('ServiceRequest')
      ->when($responsability_center != null, function ($q) use ($responsability_center) {
        return $q->whereHas("serviceRequest", function ($subQuery) use ($responsability_center) {
          $subQuery->where('responsability_center_ou_id', $responsability_center);
        });
      })
      ->orderBy('year')
      ->orderBy('month');


    switch ($who) {
      case 'responsable':
        $query->whereNull('responsable_approbation')
          ->whereHas("serviceRequest", function ($subQuery) use ($user_id) {
            $subQuery->whereHas("signatureFlows", function ($subQuery) use ($user_id) {
              $subQuery->where('responsable_id', $user_id);
            });
          });
        break;
      case 'rrhh':
        $query->whereNotNull('responsable_approbation');
        $query->whereNull('rrhh_approbation');
        break;
      case 'finance':
        $query->whereNotNull('responsable_approbation');
        $query->whereNotNull('rrhh_approbation');
        $query->whereNull('finances_approbation');
        break;
      default:
        break;
    }

    $fulfillments = $query->paginate(100);

    $periodo = '';

    $request->flash(); // envía los inputs de regreso

    return view(
      'service_requests.requests.fulfillments.reports.pending',
      compact('fulfillments', 'request', 'periodo', 'who', 'establishments', 'responsabilityCenters')
    );
  }

  public function compliance(Request $request)
  {
    //$users = User::getUsersBySearch($request->get('name'))->orderBy('name','Asc')->paginate(150);
    $fulfillments = Fulfillment::Search($request)
      ->whereHas('ServiceRequest')
      ->orderBy('id', 'Desc')
      ->paginate(200);

    /* Año actual y año anterior */
    $years[] = now()->format('Y');
    $years[] = now()->subYear('1')->format('Y');
    $years[] = now()->addYear('1')->format('Y');

    $request->flash();
    if ($request->has('excel')) {
      //$this->complianceExport($request);
      return Excel::download(new ComplianceExport($request), 'reporte-de-cumplimiento.xlsx');
    }



    //$this->complianceExport($request);
    else {
      return view(
        'service_requests.requests.fulfillments.reports.compliance',
        compact('years', 'fulfillments', 'request')
      );
    }
  }




  //public function paginate($items, $perPage = 5, $page = null, $options = [])
  public function paginate($items, $perPage = 100, $page = null, $options = ["path" => "payed"])
  {
    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
    //$currentPage = LengthAwarePaginator::resolveCurrentPage();
    $items = $items instanceof Collection ? $items : Collection::make($items);
    return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
  }

  public function export_sirh(Request $request)
  {


    $filitas = null;

    $filitas = ServiceRequest::where('establishment_id', 1)->paginate(100);



    $run = $request->run;
    $id_from = $request->id_from;
    $id_to = $request->id_to;
    $from = $request->from;
    $to = $request->to;





    $filitas = ServiceRequest::where('establishment_id', 1)
      ->when($request->run != null, function ($q) use ($run) {
        return $q->where('user_id', $run);
      })
      ->when($request->id_from != null, function ($q) use ($id_from) {
        return $q->where('id', '>=', $id_from);
      })
      ->when($request->id_to != null, function ($q) use ($id_to) {
        return $q->where('id', '<=', $id_to);
      })
      ->when($request->from != null, function ($q) use ($from) {
        return $q->where('start_date', '>=', $from);
      })
      ->when($request->to != null, function ($q) use ($to) {
        return $q->where('start_date', '<=', $to);
      })

      //->whereBetween('start_date', [$request->from, $request->to])
      ->where(function ($q) {
        $q->whereNotNull('resolution_number')
          ->whereNotNull('gross_amount')
          ->orwhereNotNull('resolution_date');
      })->paginate(100);

    $request->flash(); //envia los input de regreso



    return view('service_requests.export_sirh', compact('request', 'filitas'));
  }


  public function duplicateContracts(Request $request)
  {
    $srall = ServiceRequest::all();
    $srUnique = $srall->unique('user_id');
    $serviceRequestssinordenar = $srall->diff($srUnique);
    $serviceRequests = $serviceRequestssinordenar->sortBy('user_id');
    //$serviceRequests = $serviceRequests->paginate(100);
    return view('service_requests.reports.duplicate_contracts', compact('request', 'serviceRequests'));
  }

  public function overlappingContracts(Request $request)
  {

    //se
///$users = User::with(['posts' => function ($query) {
//   $query->orderBy('created_at', 'desc');
// }])->get();


    $users = User::with(['serviceRequests'
    => function ($query) {
        $query->orderBy('start_date', 'asc');
      }])
    ->has('serviceRequests', '>=', 2)->get('id');
    foreach($users as $user)
    {

      foreach($user->serviceRequests as $sr)
      {
        //dd($sr);
        foreach($user->serviceRequests as $srtemporal)
        if($sr != $srtemporal)
        {
         if ($srtemporal->start_date >= $sr->start_date and $srtemporal->end_date <= $sr->end_date)
         {
          //dd("encontre algo ".$sr->user_id);
          if ($sr->srsolapados != null) {
            $sr->srsolapados->push($srtemporal);
            dd($sr->srsolapados);
          }
         }

        }

      }

    }



    }



  	public function contract(Request $request)
  	{
    	$responsabilityCenters = OrganizationalUnit::where('establishment_id', Auth::user()->organizationalUnit->establishment_id)->orderBy('name', 'ASC')->get();
    	//dd($responsabilityCenters);

		$srs = array();
		$total_srs = 0;
    $profession_id = $request->profession_id;

		if(isset($request->option))
		{

			$srs = ServiceRequest::query();

			if ($request->has('excel')) {
				return Excel::download(new ContractExport($request), 'reporte-de-contrato.xlsx');
			}

			//lista los que no son vigente, creados, solicitados, que comiencen, que terminen entre
			if ($request->option != 'vigenci') {
				if ($request->has('from')) {
					$srs = $srs->whereBetween($request->option, [$request->from, $request->to])
						->when($request->uo != null, function ($q) use ($request) {
							return $q->where('responsability_center_ou_id', $request->uo);
					})
					->when($request->type != null, function ($q) use ($request) {
						return $q->where('type',  $request->type);
					})
					->orderBy($request->option);
				}
			}

			else //aca son solo los vigentes
			{
				$srs = $srs->whereDate('start_date','>=',$request->from)
        ->whereDate('end_date','<=',$request->to)
        ->when($request->uo != null, function ($q) use ($request) {
          return $q->where('responsability_center_ou_id', $request->uo);
        })
        ->when($request->type != null, function ($q) use ($request) {
          return $q->where('type',  $request->type);
        })
        ->whereDoesntHave("fulfillments", function ($subQuery) {
          $subQuery->whereHas("FulfillmentItems", function ($subQuery) {
                        $subQuery->where('type','Renuncia voluntaria');
                });
        })
        ->whereDoesntHave("fulfillments", function ($subQuery) {
          $subQuery->whereHas("FulfillmentItems", function ($subQuery) {
                        $subQuery->where('type','Abandono de funciones');
                });
        })
        ->whereDoesntHave("fulfillments", function ($subQuery) {
          $subQuery->whereHas("FulfillmentItems", function ($subQuery) {
                        $subQuery->where('type','Término de contrato anticipado');
                });
        })
        ->orderBy('start_date');
			}

      $srs->when($profession_id != NULL, function ($q) use ($profession_id) {
        return $q->where('profession_id', $profession_id);
      });

			$total_srs = $srs->count();

			$srs = $srs->paginate(100);

			$request->flash(); // envía los inputs de regreso

		}

    $professions = Profession::orderBy('name', 'ASC')->get();

    	return view('service_requests.reports.contract',
			compact('request', 'responsabilityCenters','srs','total_srs','professions'));
  	}

  public function export_sirh_txt(Request $request)
  {

    $filas = null;

    $filas = ServiceRequest::where('establishment_id', 1);


    $run = $request->run;
    $id_from = $request->id_from;
    $id_to = $request->id_to;
    $from = $request->from;
    $to = $request->to;



    $filas = ServiceRequest::where('establishment_id', 1)
      ->when($request->run != null, function ($q) use ($run) {
        return $q->where('user_id', $run);
      })
      ->when($request->id_from != null, function ($q) use ($id_from) {
        return $q->where('id', '>=', $id_from);
      })
      ->when($request->id_to != null, function ($q) use ($id_to) {
        return $q->where('id', '<=', $id_to);
      })
      ->when($request->from != null, function ($q) use ($from) {
        return $q->where('start_date', '>=', $from);
      })
      ->when($request->to != null, function ($q) use ($to) {
        return $q->where('start_date', '<=', $to);
      })
      //->whereBetween('start_date', [$request->from, $request->to])
      ->where(function ($q) {
        $q->whereNotNull('resolution_number')
          ->whereNotNull('gross_amount')
          ->orwhereNotNull('resolution_date');
      })->get();





    $txt = null;
    // 'RUN|' .
    // 'DV|' .
    // ' N°  cargo |' .
    // ' Fecha  inicio  contrato |' .
    // ' Fecha  fin  contrato |' .
    // 'Establecimiento|' .
    // ' Tipo  de  decreto |' .
    // ' Contrato  por  prestación |' .
    // ' Monto  bruto |' .
    // ' Número  de  cuotas |' .
    // 'Impuesto|' .
    // ' Día  de  proceso |' .
    // ' Honorario  suma  alzada |' .
    // ' Financiado  proyecto |' .
    // ' Centro  de  costo |' .
    // 'Unidad|' .
    // ' Tipo  de  pago |' .
    // ' Código  de  banco |' .
    // ' Cuenta  bancaria |' .
    // 'Programa|' .
    // 'Glosa|' .
    // 'Profesión|' .
    // 'Planta|' .
    // 'Resolución|' .
    // ' N°  resolución |' .
    // ' Fecha  resolución |' .
    // 'Observación|' .
    // 'Función|' .
    // ' Descripción  de  la  función  que  cumple |' .
    // ' Estado  tramitación  del  contrato |' .
    // ' Tipo  de  jornada |' .
    // ' Agente  público |' .
    // ' Horas  de  contrato |' .
    // ' Código  por  objetivo |' .
    // ' Función  dotación |' .
    // ' Tipo  de  función |' .
    // ' Afecto  a  sistema  de  turno' . "\r\n";

    foreach ($filas as $fila) {
      $cuotas = $fila->end_date->month - $fila->start_date->month + 1;
      switch ($fila->program_contract_type) {
        case 'Horas':
          $por_prestacion = 'S';
          $fila->weekly_hours = 0;
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
        default:
          $sirh_program_code = '';
          break;
      }

      switch ($fila->weekly_hours) {
        case 44:
          $type_of_day = 'C';
          break;
        case 0:
          $type_of_day = 'S';
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
        default:
          $sirh_profession_id = '';
          $sirh_function_id = ''; // Atención Clínica
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
        //$fila->weekly_hours . '|' .
        $fila->weekly_hours . '|' .
        '2103001' . '|' . // único para honorarios
        'N' . '|' .
        $function_type . '|' . // Apoyo asistenciasl S o N
        $turno_afecto . // working_day_type Diurno = S, el resto N
        "\r\n";

      $txt = mb_convert_encoding($txt, 'utf-8');
    }
    //dd($fila);

    $response = new StreamedResponse();
    $response->setCallBack(function () use ($txt) {
      echo $txt;
    });
    $response->headers->set('Content-Type', 'text/plain; charset=utf-8');
    $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, "export_sirh.txt");
    $response->headers->set('Content-Disposition', $disposition);
    // dd($fila);
    return $response;
  }

  public function service_request_continuity(Request $request){

    $results = array();
    if ($request->from != null && $request->to != null) {
      $serviceRequests = ServiceRequest::where('program_contract_type','Mensual')
                                      ->where('type','Covid')
                                      ->where('start_date','<=',$request->from)
                                      ->where('end_date','>',$request->from)
                                      ->orderBy('start_date','asc')
                                      ->get(['user_id','id','start_date','end_date'])
                                      ->unique('user_id');

                                      // dd($serviceRequests[0]);


      // dd($serviceRequests->count());
      if ($serviceRequests->count()>0) {


        foreach ($serviceRequests as $key => $serviceRequest) {
          $id = $serviceRequest->id;
          $user_id = $serviceRequest->user_id;
          $start_date = $serviceRequest->start_date;
          $end_date = $serviceRequest->end_date;

          $results[$serviceRequest->employee->getFullNameAttribute()][$serviceRequest->start_date->format('Y-m-d') . " - " . $serviceRequest->end_date->format('Y-m-d')] = $serviceRequest;
          do {
            $serviceRequest_aux = ServiceRequest::where('program_contract_type','Mensual')
                                                ->where('type','Covid')
                                                ->where('start_date','>=',$request->from)
                                                ->where('id','!=',$id)
                                                ->where('user_id',$user_id)
                                                ->where('start_date',$end_date->addDay(1))
                                                ->whereHas('SignatureFlows', function($q) {
                                                    return $q->where('status', 1);
                                                })
                                                ->first();

            if ($serviceRequest_aux) {
              $id = $serviceRequest_aux->id;
              $user_id = $serviceRequest_aux->user_id;
              $start_date = $serviceRequest_aux->start_date;
              $end_date = $serviceRequest_aux->end_date;

              $results[$serviceRequest->employee->getFullNameAttribute()][$start_date->format('Y-m-d') . " - " . $end_date->format('Y-m-d')] = $serviceRequest_aux;

              // print_r($serviceRequest->employee->getFullNameAttribute() ." - ". $end_date."<br>");
            }else{
              // $results[$serviceRequest->employee->getFullNameAttribute()][$end_date->format('Y-m-d') . " - xx"] = 0; //muestra los contratos que debiesen estar pero no existen
              unset($results[$serviceRequest->employee->getFullNameAttribute()]); //elimina los que no son consecutivos
            }


          }while ($serviceRequest_aux && $end_date <= $request->to);

        }
        // dd($end_date);
      }

      // dd($results);

    }
    return view('service_requests.reports.service_request_continuity',compact('request','results'));
  }
}
