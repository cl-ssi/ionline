<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping, ShouldAutoSize};
use App\Models\ServiceRequests\Fulfillment;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PayedExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     return Fulfillment::all();
    // }

    public function collection()
    {
        // return Fulfillment::all();

        $establishment_id = $this->request->establishment_id;
        $service_request_id = $this->request->service_request_id;
        $working_day_type = $this->request->working_day_type;

        $from = $this->request->from;
        $to = $this->request->to;
        if ($to == null) {
          $to = Carbon::now();
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
          ->whereNotIn('type', ['Mensual', 'Parcial'])
          ->whereNotNull('total_paid')
          ->get();

        $payed_fulfillments = $payed_fulfillments1->merge($payed_fulfillments2);

        return $payed_fulfillments;
    }


    public function headings(): array
    {
        return [
          'ID',
          'Rut',
          'Nombre',
          'Unidad',
          'Año',
          'Tipo',
          'Tipo de Contrato',
          'Tipo de Jornada',
          'Hrs pagadas',
          'F.Pago',
          'Monto'
        ];
    }

    public function map($fulfillment): array
    {
        return [
            $fulfillment->servicerequest->id,
            ($fulfillment->servicerequest)?$fulfillment->servicerequest->employee->runFormat(): '',
            ($fulfillment->servicerequest->employee)? strtoupper($fulfillment->servicerequest->employee->fullname) : '',
            $fulfillment->servicerequest->responsabilityCenter->name,
            $fulfillment->year . "-" . $fulfillment->month,
            $fulfillment->servicerequest->type,
            $fulfillment->servicerequest->program_contract_type,
            $fulfillment->servicerequest->working_day_type,
            $fulfillment->total_hours_paid,
            $fulfillment->payment_date->format('Y-m-d'),
            $fulfillment->total_paid
        ];
    }
}
