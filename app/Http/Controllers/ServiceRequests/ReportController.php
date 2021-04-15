<?php

namespace App\Http\Controllers\ServiceRequests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceRequests\ServiceRequest;
use App\Models\ServiceRequests\Fulfillment;
use App\Rrhh\Authority;
use Luecano\NumeroALetras\NumeroALetras;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
  public function toPay(Request $request)
  {
    $establishment_id = $request->establishment_id;
    $topay_fulfillments1 = Fulfillment::whereHas("ServiceRequest", function ($subQuery) {
      $subQuery->where('has_resolution_file', 1);
    })
      ->when($establishment_id != null, function ($q) use ($establishment_id) {
        return $q->whereHas("ServiceRequest", function ($subQuery) use ($establishment_id) {
          $subQuery->where('establishment_id', $establishment_id);
        });
      })
      // ->when($establishment_id == 0, function ($q) use ($establishment_id) {
      //      return $q->whereHas("ServiceRequest", function($subQuery) use ($establishment_id) {
      //                  $subQuery->where('establishment_id',38);
      //                });
      //   })
      ->where('has_invoice_file', 1)
      ->whereNotNull('signatures_file_id')
      ->whereIn('type', ['Mensual', 'Parcial'])
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
      // ->when($request->establishment_id === 0, function ($q) use ($establishment_id) {
      //      return $q->whereHas("ServiceRequest", function($subQuery) use ($establishment_id) {
      //                  $subQuery->where('establishment_id',38);
      //                });
      //   })
      ->where('has_invoice_file', 1)
      ->whereNotNull('signatures_file_id')
      ->whereNotIn('type', ['Mensual', 'Parcial'])
      ->whereNull('total_paid')
      ->get();

    $topay_fulfillments = $topay_fulfillments1->merge($topay_fulfillments2);

    return view('service_requests.reports.to_pay', compact('topay_fulfillments', 'request'));
  }

  public function payed(Request $request)
  {
    $establishment_id = $request->establishment_id;

    $payed_fulfillments1 = Fulfillment::whereHas("ServiceRequest", function ($subQuery) {
      $subQuery->where('has_resolution_file', 1);
    })
      ->when($establishment_id != null, function ($q) use ($establishment_id) {
        return $q->whereHas("ServiceRequest", function ($subQuery) use ($establishment_id) {
          $subQuery->where('establishment_id', $establishment_id);
        });
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
      ->where('has_invoice_file', 1)
      ->whereNotIn('type', ['Mensual', 'Parcial'])
      ->whereNotNull('total_paid')
      ->get();

    $payed_fulfillments = $payed_fulfillments1->merge($payed_fulfillments2);

    return view('service_requests.reports.payed', compact('payed_fulfillments', 'request'));
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
      ->get();
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

  public function payRejected()
  {
    $fulfillments = Fulfillment::where('payment_ready', 0)->orderByDesc('id')->get();
    return view('service_requests.reports.pay_rejected', compact('fulfillments'));
  }

  public function budgetAvailability(ServiceRequest $serviceRequest)
  {
    // $pdf = app('dompdf.wrapper');
    // $pdf->loadView('service_requests.requests.report_certificate', compact('serviceRequest'));

    // return $pdf->stream('mi-archivo.pdf');


    //$authority = Authority::find(serviceRequest)
    $authority = new Authority;
    //1 es el hospital
    if($serviceRequest->responsabilityCenter->establishment->id == 1)
    {
      //$authority = authority->getAuthorityFromDate(1,'2020-04-09','manager');
    }


    return view('service_requests.reports.budget_availability', compact('serviceRequest'));
  }

	public function pending(Request $request, $who) {
		switch($who) {
			case 'responsable':
				$condition = 'responsable_approbation';
				break;
			case 'rrhh':
				$condition = 'rrhh_approbation';
				break;
			case 'finance':
				$condition = 'finances_approbation';
				break;
			default:
				$condition = '';
				break;
		}

		$fulfillments = Fulfillment::whereNull($condition)
			->whereHas('ServiceRequest')
			->orderBy('year')
			->orderBy('month')
			->paginate(250);
		$periodo = '';
		
		return view('service_requests.requests.fulfillments.reports.pending',
			compact('fulfillments','request','periodo','who')
		);

	}

	public function compliance(Request $request)
	{
		//$users = User::getUsersBySearch($request->get('name'))->orderBy('name','Asc')->paginate(150);
		$fulfillments = Fulfillment::Search($request)->paginate(100);

		return view('service_requests.requests.fulfillments.reports.compliance', compact('fulfillments','request'));
	}

}
