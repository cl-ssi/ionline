<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping, ShouldAutoSize};
use App\Models\ServiceRequests\Fulfillment;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Http\Request;

class ComplianceExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        return Fulfillment::Search($this->request)
                         ->whereHas('ServiceRequest')
                         ->orderBy('id','Desc')
                         ->get();        
    }

    public function headings(): array
    {
        return [
            'ID',
            'N° Solicitud',
            'Rut',
            'Nombre',
            'Unidad',
            'Período',
            'Teléfono',
            'Email',
            'Programa',
            'Profesión',
            'Hrs. Semanales',
            'Tipo',
            'Tipo de Contrato',
            'Tipo de Jornada',
            'Monto Bruto',
            'N° Boleta',
            'Total Hrs. Pagadas',
            'Total Pagado', 
            'Fecha Pago',
            'Estado',
            'Tiene Resolución',
            'Tiene Certificado',
            'Apr. Responsable',
            'Apr. RRHH',
            'Apr. Finanzas',
            'Tiene Boleta'
        ];
    }

    public function map($fulfillment): array
    {
        return [
            $fulfillment->id,
            $fulfillment->servicerequest?->id ?? '',
            $fulfillment->servicerequest?->employee?->runFormat() ?? '',
            $fulfillment->servicerequest?->employee?->fullname 
                ? strtoupper($fulfillment->servicerequest->employee->fullname) 
                : '',
            $fulfillment->servicerequest?->responsabilityCenter?->name ?? '',
            $fulfillment->year . '-' . $fulfillment->month,
            $fulfillment->servicerequest?->employee?->phone_number ?? '',
            $fulfillment->servicerequest?->employee?->email ?? '',
            $fulfillment->servicerequest?->programm_name ?? '',
            $fulfillment->servicerequest?->profession?->name ?? '',
            $fulfillment->servicerequest?->weekly_hours ?? '',
            $fulfillment->servicerequest?->type ?? '',
            $fulfillment->servicerequest?->program_contract_type ?? '',
            $fulfillment->servicerequest?->working_day_type ?? '',
            $fulfillment->servicerequest?->gross_amount ?? '',
            $fulfillment->bill_number ?? '',
            $fulfillment->total_hours_paid ?? '',
            $fulfillment->total_paid ?? '',
            $fulfillment->payment_date ? $fulfillment->payment_date->format('Y-m-d') : '',
            $this->getStatus($fulfillment),
            $fulfillment->serviceRequest?->has_resolution_file ? 'Sí' : 'No',
            $fulfillment->signatures_file_id ? 'Sí' : 'No',
            $fulfillment->responsable_approbation ? 'Sí' : 'No',
            $fulfillment->rrhh_approbation ? 'Sí' : 'No',
            $fulfillment->finances_approbation ? 'Sí' : 'No',
            $fulfillment->has_invoice_file ? 'Sí' : 'No'
        ];
    }

    private function getStatus($fulfillment)
    {
        if ($fulfillment->quit_status() == 'Sí') {
            return 'Renunció';
        }
        if ($fulfillment->payment_date) {
            return 'Pagado';
        }
        if ($fulfillment->has_invoice_file) {
            return 'Con Boleta';
        }
        return 'En Proceso';
    }
}